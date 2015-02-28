<?php
/**
 * DataGrab Model Class
 *
 * Handles the DataGrab import process
 * 
 * @package   DataGrab
 * @author    Andrew Weaver <aweaver@brandnewbox.co.uk>
 * @copyright Copyright (c) Andrew Weaver
 */
class Datagrab_model extends CI_Model {
	
	var $datatypes = array();
	
	var $settings;
	var $datatype;
	var $channel_defaults;
	
	var $check_memory = FALSE;
	var $mem_usage = 0;
	
	var $return_data = "";
	
	function Datagrab_model() {
		parent::__construct(); 
	}

	function fetch_datatype_names() {
		
		$this->initialise_types();

		$types = array();
		foreach( $this->datatypes as $type_name => $type ) {
			$types[ $type_name ] = $type->display_name();
		}
		
		return $types;
	}


	function initialise_types() {
		
		if ( ! class_exists('Datagrab_type') ) {
			require_once PATH_THIRD.'ajw_datagrab/libraries/Datagrab_type'.EXT;
		}	
		
		$path = PATH_THIRD.'ajw_datagrab/datatypes/';
		
		$dir = opendir($path);

		while (($folder = readdir($dir)) !== FALSE) {
			if( is_dir($path.$folder) && $folder != "." && $folder != ".." ) {
				$filename = "/dt." . $folder . EXT;
				if ( ! class_exists( $folder ) ) {
					if( file_exists( $path.$folder.$filename ) ) {
						include($path.$folder.$filename);
						if (class_exists($folder)) {
							$this->datatypes[$folder] = new $folder();
						}
					}
				}
			}
		}
		closedir($dir);
		
		ksort( $this->datatypes );
		
		return count( $this->datatypes );
		
	}

	function do_import( $datatype, $settings ) {
	
		$this->datatype = $datatype;
		$this->settings = $settings;
		
		// Initialise
		$this->load->library('api');
		$this->api->instantiate('channel_fields');
		$this->api_channel_fields->fetch_custom_channel_fields();
		$this->api->instantiate('channel_entries');

		// Set up the data source
		$datatype->initialise( $this->settings );
		$datatype->fetch();

		// Get custom fields from database
		$custom_fields = $this->_fetch_custom_fields_from_channel( $this->settings["channel"] );

		// Get channel details for default values
		$this->channel_defaults = $this->_fetch_channel_defaults( $this->settings["channel"] );
		

		// Can the current member use the Channel API (the import might not be running from
		// the Control Panel)?
		$this->_check_member_status();

		// Set up initial variables
		$entries_added = 0;
		$row_num = 0;
		$timestamp = time();
		$entries = array(); // Used to store a list of which entries have been imported/updated

		// Loop over items
		while( $item = $datatype->next() ) {

			// Reset time out
			set_time_limit(30);

			// if( $this->check_memory ) { $this->_check_mem_usage("Start"); }

			// Check whether to skip this row or not
			$row_num++;
			if( isset($this->settings["skip"]) && is_numeric($this->settings["skip"]) ) {
				if ( $row_num <= $this->settings["skip"] ) {
					continue;
				}
			}
			
			// Initialise array to store entry data
			$data = array();

			// Get title
			$data["title"] = $datatype->get_item( $item, $this->settings[ "title" ] );
		
			// Get date
			$date = isset( $this->settings[ "date" ] ) ? $this->settings[ "date" ] : '';
			$data[ "entry_date" ] = $this->_parse_date( $datatype->get_item( $item, $date ) );

			// @todo: Load static data

			// Loop over all custom fields in this channel
			foreach( $custom_fields as $field => $field_data ) {

				// Update field's fieldtype settings (for 3rd party fieldtypes)
				$this->_get_channel_fields_settings( $field_data["id"] );

				// Should we import anything into this field?
				if( isset( $this->settings[ $field ] ) && $this->settings[ $field ] != "" ) {

					// Check to see if a handler exists for this field type
					if ( ! class_exists('Datagrab_fieldtype') ) {
						require_once PATH_THIRD.'ajw_datagrab/libraries/Datagrab_fieldtype'.EXT;
					}	
					if ( ! class_exists('Datagrab_'.$field_data[ "type" ] ) ) {
						if( file_exists( PATH_THIRD.'ajw_datagrab/fieldtypes/datagrab_'.$field_data[ "type" ].EXT ) ) {
							require_once PATH_THIRD.'ajw_datagrab/fieldtypes/datagrab_'.$field_data[ "type" ].EXT;
						}
					}	
					
					// If so, call the prepare_post_date method to format the $data array
					if ( class_exists('Datagrab_'.$field_data[ "type" ]) ) {
						$classname = "Datagrab_".$field_data[ "type" ];
						$ft = new $classname();
						$ft->prepare_post_date( $this, $item, $field_data["id"], $field, $data );
					} else {
						// If no handler exists, just use the value
						$data[ "field_id_" . $field_data["id"] ] = $datatype->get_item( $item, $this->settings[ $field ] );
					}

					$data[ "field_ft_" . $field_data["id"] ] = $field_data[ "format" ];

				}
			}

			// print_r( $data );
			// print_r( $this->api_channel_fields->settings );

			// Set timestamp field if one is set
			if( isset( $this->settings["timestamp"] ) && $this->settings["timestamp"] != "" ) {
				$data[ $this->settings["timestamp"] ] = $timestamp;
			}
			
			// No of seconds to offset dates/times
			$time_offset = $this->settings["offset"]; 

			// Fetch author id
			$author_id = $this->_fetch_author( $item );

			// Get status
			$status = $this->_fetch_status( $item );

			// Handle Structure module fields
			// @todo: check whether Structure now can handle API entry
			if( $this->db->table_exists('exp_structure_channels') ) {
				// If the structure module tables exists, try and get template id
				$this->db->select( 'template_id' );
				$this->db->where( 'channel_id', $this->channel_defaults["channel_id"] );
				$query = $this->db->get( 'exp_structure_channels' );
				if( $query->num_rows() > 0 ) {
					$row = $query->row_array();
					$data["structure__uri"] = "";
					$data["structure__template_id"]= $row["template_id"];
					// Not needed?
					// $data["structure__parent_id"] = 0;
					// $data["structure__listing_channel"] = 0;
					$data["cp_call"] = TRUE;
				}
			}

			// Handle Solspace Tags
			if( isset( $this->settings["ajw_solspace_tag"] ) ) {
				$tags = explode(",", $datatype->get_item( $item, $this->settings["ajw_solspace_tag"] ));
				foreach( $tags as $idx => $tag ) {
					$tags[ $idx ] = trim( $tag );
				}
				$tags = array_unique( $tags );
				$data["tag__solspace_tag_submit"] = implode( "\n", $tags );
			}

			// Check for duplicate entry
			if( ! isset( $this->settings[ "unique" ] ) ) {
				$this->settings["unique"] = '';
			}

			// Check whether this entry is a duplicate
			$entry_id = $this->_is_entry_unique( $data, $this->settings["unique"], $custom_fields );
			
			// If it is a new entry...
			if (  $entry_id == 0 ) {
				
			// Insert (titles, data, categories)
		
			$this->return_data .= "<p>Found new entry: " . $data[ "title" ] . "</p>\n";
		
				// Add entry using EE channel API
				
				$data["channel_id"] = $this->channel_defaults["channel_id"]; // Shouldn't need this... (http://expressionengine.com/bug_tracker/bug/13483/)
				$data["status"] = $status;
				$data["author_id"] = $author_id;
				$data["ping_servers"] = array(); // API bug (http://expressionengine.com/bug_tracker/bug/14008/)
				$data["allow_comments"] = $this->channel_defaults["deft_comments"];

				// Find and create categories
				$entry_categories = $this->_setup_categories( $item );
				$data["category"] = $entry_categories;

				// Add entry to categories
				// @todo: move this into API call
				/*
				foreach( $entry_categories as $cat_id ) {
					$this->_add_entry_to_category( $entry_id, $cat_id );
				}
				*/

				// Might be needed on some systems
				/*
				$this->api->instantiate('channel_fields');
				$this->api_channel_fields->fetch_custom_channel_fields();
				$this->api_channel_fields->settings = array();
				*/
				
				// Delete unused fields
				/*
				foreach( $this->api_channel_fields->settings as $field_id => $field_data ) {
					if( ! isset( $data[ "field_id_" . $field_id ] ) ) {
						unset( $this->api_channel_fields->settings[ $field_id ] );
					}
				}
				*/

				$this->api_channel_entries->entry_id = 0; // to work around bug in API (http://expressionengine.com/bug_tracker/bug/13549/)

				// Disable notices while running this. Too many 3rd party fieldtypes
				// giving notices
				$errorlevel = error_reporting();
				error_reporting( $errorlevel & ~E_NOTICE );

				if( $this->api_channel_entries->submit_new_entry( 
						$this->channel_defaults["channel_id"], 
						$data ) === FALSE) {
					$this->return_data .= "<p>Could not create new entry: " . $data[ "title" ] . "</p>\n";;
					foreach( $this->api_channel_entries->errors as $eid => $error ) {
						$this->return_data .= "<p>" . $error . " " . $eid . "</p>\n";
					}
				}

				error_reporting( $errorlevel );

				$entry_id = $this->api_channel_entries->entry_id;

				$entries_added++;

				// Do comments
				if( isset( $this->settings["import_comments"] ) && $this->settings["import_comments"] == "y") {
					$no_comments = $this->_import_comments( $entry_id, $item );
					if( $no_comments > 0 ) {
						$this->return_data .= "<p>Added " . $no_comments . " comments.</p>\n";
					}
				}
				
			} else {

				if( $data["title"] != "" ) {
					$this->return_data .= "<p>" . $data[ "title" ] . " already exists.</p>\n";
				} else {
					$this->return_data .= "<p>Entry already exists.</p>\n";
				}

				if( isset( $this->settings["update"] ) && $this->settings["update"] == "y") {

					// Update entry using EE channel API

					$data["channel_id"] = $this->channel_defaults["channel_id"]; // Shouldn't need this...
					$data["status"] = $status;
					$data["author_id"] = $author_id;
					$data["ping_servers"] = array();
					$data["allow_comments"] = $this->channel_defaults["deft_comments"];

					// Find categories

					/*
					// $query = $this->db->query("DELETE FROM exp_category_posts WHERE entry_id = '".$this->db->escape_str($entry_id)."'");
					// @todo: improve this query. Deletes all existing category assignments from the selected category group
					if( isset( $this->settings["cat_group"]) && $this->settings["cat_group"] != "" ) {
						// Only delete if a category group is assigned
						$query = $this->db->query("DELETE p FROM exp_category_posts p LEFT JOIN exp_categories c USING (cat_id) WHERE entry_id = " . $this->db->escape_str($entry_id) . " AND c.group_id = " . $this->db->escape_str($this->settings["cat_group"] ) );
					}
					*/

					// Find and create categories
					$entry_categories = $this->_setup_categories( $item, $entry_id );

					// Add entry to categories
					// @todo: move into API call
					$data["category"] = $entry_categories;
					/*
					foreach( $entry_categories as $cat_id ) {
					 	$this->_add_entry_to_category( $entry_id, $cat_id );
					}
					*/

					$this->_prepare_update_data( $entry_id, $data );

					// Disable notices while running this. Too many 3rd party fieldtypes
					// giving notices
					$errorlevel = error_reporting();
					error_reporting( $errorlevel & ~E_NOTICE) ;
					
					if ($this->_ajw_datagrab_update_entry( 
								$entry_id, 
								$data) === FALSE) {
						$this->return_data .= "<p>Could not update entry: " . $data[ "title" ] . "</p>\n";
						foreach( $this->api_channel_entries->errors as $error ) {
							$this->return_data .= "<p>" . $error . "</p>\n";
						}
					} else {
						$this->return_data .= "<p>Entry updated</p>\n";
					}
					
					error_reporting( $errorlevel );

					
					// @todo: do comments

				}

			}
			
			$entries[] = $entry_id;
			
		}
		
		// Delete old entries
		if( isset( $this->settings["delete_old"] ) && $this->settings["delete_old"] == "y") {
			$no_deleted = $this->_delete_old_entries( $entries );
			if( $no_deleted > 0 ) {
				$this->return_data .= "<p>Deleted " . $no_deleted . " old entries.</p>";
			}
		}
		
		// Report and update caches
		if ($entries_added > 0) {
			$this->return_data .= "<p>New entries: " . $entries_added . "</p>";
			if ($this->config->item('new_posts_clear_caches') == 'y') {
				$this->functions->clear_caching('all');
			} else {
				$this->functions->clear_caching('sql_cache');
			}
			
		}
		
		return $this->return_data;
	}
		
	
	/*
		INTERNAL METHODS
	*/

	/**
	 * Get an array of custom field data for a selected channel
	 *
	 * @param string $channel channel_id
	 * @return array $custom_fields array containing custom field data for selected channel
	 */
	function _fetch_custom_fields_from_channel( $channel ) {

		$this->db->select('exp_channel_fields.field_id, 
			exp_channel_fields.field_name, 
			exp_channel_fields.field_label, exp_channel_fields.field_fmt,
			exp_channel_fields.field_type, exp_channel_fields.field_related_id');
		$this->db->from('exp_channel_fields');
		$this->db->join('exp_channels', 'exp_channels.field_group = exp_channel_fields.group_id');
		if( is_numeric($this->settings["channel"]) ) {
			$this->db->where( 'channel_id', $channel );
		} else {
			$this->db->where( 'channel_name', $channel );
			$this->db->where('exp_channel_fields.site_id', $this->config->item('site_id') );
		}
		$query = $this->db->get();
		$field_ids = '';
		
		$custom_fields = array();
		foreach ( $query->result_array() as $row ) {
			$custom_fields[ $row[ "field_name" ] ][ 'id' ] = $row[ "field_id" ];
			$custom_fields[ $row[ "field_name" ] ][ 'format' ] = $row[ "field_fmt" ];
			$custom_fields[ $row[ "field_name" ] ][ 'type' ] = $row[ "field_type" ];
			if ( $row[ "field_type" ] == "rel" ) {
				$custom_fields[ $row[ "field_name" ] ][ 'related_id' ] = $row[ "field_related_id" ];
			}
		}
		
		return $custom_fields;
	}

	/**
	 * Get default settings for a channel
	 *
	 * @param string $channel channel_id
	 * @return array $channel_default array of channel default settings
	 */
	function _fetch_channel_defaults( $channel ) {

		$this->db->select('channel_id, site_id, channel_title, channel_url, 
			rss_url, ping_return_url, deft_comments, 
			deft_status, cat_group, field_group');
		$this->db->from('exp_channels');
		if( is_numeric($this->settings["channel"]) ) {
			$this->db->where( 'channel_id', $channel );
		} else {
			$this->db->where( 'channel_name', $channel );
			$this->db->where( 'site_id', $this->config->item('site_id') );
		}
		$query = $this->db->get();
		$channel_defaults = $query->row_array();

		return $channel_defaults;
	}

	/**
	 * Check to see if the current user is logged in with the privileges to perform import, 
	 * if not create a dummy user (used when import is not run from the Control Panel)
	 *
	 */
	function _check_member_status() {

		// If not currently logged in, create a dummy session
		// @todo: currently hard-coded, need to search db for admin user?
		if( $this->session->userdata['member_id'] == 0) {
			$this->session->create_new_session(1, TRUE);
			//$this->session->userdata['username']  = "dummy";
			$this->session->userdata['group_id']  = 1;
			$this->session->userdata['can_edit_other_entries'] = 'y';
			$this->session->userdata['can_delete_self_entries'] = 'y';
			$this->session->userdata['can_delete_all_entries'] = 'y';
		}

	}

	/**
	 * Find which author to assign to this entry
	 *
	 * @param array $item current row of data from data source
	 * @return integer $author_id the id of the author to assign to this entry
	 */
	function _fetch_author( $item ) {
		
		// Default author
		$author_id = $this->settings["author"]; 
		
		// Data field that contains author information
		$author_field = isset( $this->settings["author_field"] ) ?  $this->settings["author_field"] : ''; 

		// Which field to check: screen name, username, email?		
		$author_check = isset( $this->settings["author_check"] ) ?  $this->settings["author_check"] : ''; 

		// Get author id from data if specified
		if ( $author_field != "" && $author_check != "" ) {
			$this->db->select( 'member_id' );
			$this->db->where( $author_check, $this->datatype->get_item( $item, $author_field ) );
			$query = $this->db->get( 'exp_members' );
			if( $query->num_rows() > 0 ) {
				$row = $query->row_array();
				$author_id = $row["member_id"];
			}
		}
		
		return $author_id;
	}

	/**
	 * Find status to assign to this entry
	 *
	 * @param array $item current row of data from data source
	 * @return string $status status to assign to entry
	 */
	function _fetch_status( $item ) {
		// @todo: fetch valid settings from db (currently hard-coding open and closed)
		$status = $this->channel_defaults["deft_status"];
		if( isset( $this->settings[ "status" ] ) ) {
			switch( $this->settings["status"] ) {
				case "default":
				$status = $this->channel_defaults["deft_status"];
				break;
				case "open":
				case "closed":
				$status = $this->settings["status"];
				break;
				default:
				$status = $this->datatype->get_item( $item, $this->settings["status"] );
			}
		}
		return $status;
	}

	/**
	 * Find a list of categories to assign to this entry and create any that don't exist
	 *
	 * @param array $item current row of data from data source
	 * @return array $entry_categories list of category ids
	 */
	function _setup_categories( $item, $entry_id = FALSE ) {
		
		// Find categories from custom field and create if necessary
		$cat_field = '';
		if( isset( $this->settings[ "cat_field" ] ) && $this->settings[ "cat_field" ] != "" ) {
			$cat_field = $this->datatype->get_item( $item, $this->settings[ "cat_field" ] );
		}

		$cat_group = '';
		if( isset( $this->settings[ "cat_group" ] ) && $this->settings[ "cat_group" ] != "" ) {
			$cat_group = $this->settings[ "cat_group" ];
		}

		$entry_categories = $this->_find_and_create_categories( 
			isset( $this->settings[ "category_value" ] ) ? $this->settings[ "category_value" ] : '',
			$cat_field,
			$this->settings[ "cat_delimiter" ],
			$cat_group,
			$this->channel_defaults["site_id"]
		);
		
		if( $entry_id !== FALSE ) {
			// Doing an update, so find existing categories
			$this->db->select( "exp_category_posts.cat_id" );
			$this->db->where( "entry_id", $entry_id );
			$this->db->where( "group_id !=", $cat_group );
			$this->db->join("exp_categories", "exp_category_posts.cat_id = exp_categories.cat_id");
			$query = $this->db->get( "exp_category_posts" );
			foreach( $query->result_array() as $row ) {
				$entry_categories[] = $row["cat_id"];
			}

		}
		
		return $entry_categories;
	}

	/**
	 * Import comments
	 *
	 * @param integer $entry_id id of the new entry
	 * @param array $item current row of data from data source
	 * @return integer the number of comments added
	 */
	function _import_comments( $entry_id, $item ) {
		
		// @note: xml only at the moment?
		// @todo: add more error checking here, eg, missing/empty fields
		// @todo: only works for new imports, not updates at the moment

		// Are there any comments for this entry?
		$no_comments = $this->datatype->get_item( $item, $this->settings["comment_body"] . "#" );
		
		if( $no_comments > 0 ) {
		
			// If so, loop over the XML and insert as new comments
			for( $i=0; $i<$no_comments; $i++ ) {
				$field = $this->settings["comment_body"];
				if ( $i > 0 ) {
					$suffix = '#' . ($i+1);
				} else {
					$suffix = '';
				}
				$data = array(
					"site_id" => $this->channel_defaults["site_id"],
					"entry_id" => $entry_id,
					"channel_id" => $this->channel_defaults["channel_id"],
					"author_id" => 0,
					"status" => "o",
					"name" => $this->datatype->get_item( $item, $this->settings["comment_author"] . $suffix ),
					"email" => $this->datatype->get_item( $item, $this->settings["comment_email"] . $suffix ),
					"url" => $this->datatype->get_item( $item, $this->settings["comment_url"] . $suffix ),
					"location" => "",
					"ip_address" => "127.0.0.1",
					"comment_date" => $this->_parse_date( 
						$this->datatype->get_item( $item, $this->settings["comment_date"] . $suffix )
					),
					"comment" => $this->datatype->get_item( $item, $this->settings["comment_body"] . $suffix )
				);
				$sql = $this->db->insert_string('exp_comments', $data);
				$this->db->query($sql);
			}
			
			// Do stats
			
			$this->db->select( "COUNT(comment_id) as count" );
			$this->db->where( "status", "o" );
			$this->db->where( "entry_id", $entry_id );
			$channel_comments_count = $this->db->get( "exp_comments" );
			
			$this->db->select( "MAX(comment_date) as date" );
			$this->db->where( "status", "o" );
			$this->db->where( "entry_id", $entry_id );
			$this->db->order_by( "comment_date", "desc" );
			$channel_comments_recent = $this->db->get( "exp_comments" );
			
			$data = array();
			if ($channel_comments_count->num_rows() > 0) {
				$row = $channel_comments_count->row_array();
				$data["comment_total"] = $row["count"];
			}
			if ($channel_comments_recent->num_rows() > 0) {
				$row = $channel_comments_recent->row_array();
				$data["recent_comment_date"] = $row["date"];
			}
			if( count( $data ) > 0 ) {
				$this->db->where('entry_id', $entry_id );
				$this->db->update('exp_channel_titles', $data );
			}
			
		}
		
		return $no_comments;
	}

	/**
	 * Delete any old entries
	 *
	 * @param array $entries a list of entries to keep (ie, have just been added)
	 * @return integer the number of deleted entries
	 */
	function _delete_old_entries( $entries ) {
		
		$this->db->select( "entry_id" );
		$this->db->where_not_in( "entry_id", $entries ); 
		$this->db->where( 'channel_id = ', $this->channel_defaults["channel_id"] ); 
		$query = $this->db->get( "exp_channel_titles" );
	
		$delete_ids = array();
		foreach ($query->result() as $row)
		{
		    $delete_ids[] = $row->entry_id;
		}
	
		if( count( $delete_ids ) ) {
			$this->api->instantiate('channel_entries');
			$ret = $this->api_channel_entries->delete_entry( $delete_ids );
			if( $ret == FALSE ) {
				foreach( $this->api_channel_entries->errors as $eid => $error ) {
					$this->return_data .= "<p>Error: " . $error . " " . $eid . "</p>";
				}
			}
		}
		
		return count( $delete_ids );
	}

	/**
	 * Try to read the date and return as timestamp
	 *
	 * @param string $datestr 
	 * @return int the date
	 */
	function _parse_date( $datestr ) {
		
		// $datestr = preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{2,4})/", "\\2/\\1/\\3", $datestr);
		
		if( is_numeric($datestr) ) {
			return $datestr;
		}
		$date = strtotime( $datestr );
		if ( $date == -1 ) {
			$date = parse_w3cdtf( $datestr );
		}
		if ( $date == -1 || $date == "" ) {
			$date = time();
		}
		return( $date );
	}

	/**
	 * Test whether an entry is unique
	 *
	 * @param array $post 
	 * @param string $unique 
	 * @param array $weblog_to_feed 
	 * @return entry id or 0 if there is no match
	 */
	function _is_entry_unique( $data, $unique, $weblog_to_feed ) {
		
		if ( $unique == "" ) {

			return 0;

		} elseif ( $unique == "title,date" ) {

			$sql = "SELECT * FROM exp_channel_titles 
			WHERE LEFT(title,100) = LEFT('".$this->db->escape_str($data[ "title" ])."',100) AND entry_date = '".$this->db->escape_str($data[ "entry_date" ])."'";
			$query = $this->db->query($sql);

		} else {

			// Build custom query
			$sql = "SELECT * FROM exp_channel_titles t, exp_channel_data d WHERE t.entry_id = d.entry_id";

			$uniqueArray = explode(",", $unique);
			foreach ( $uniqueArray as $value ) {
				switch ( $value ) {
					case 'title': {
						$sql .= " AND " . $value . "=\"" . $this->db->escape_str( $data[ $value ] ) . "\"";
						break;
					}
					case 'date': {
						$sql .= " AND entry_date=\"" . $this->db->escape_str( $data[ "entry_date" ] ) . "\"";
						break;
					}
					default: {
						$name = "field_id_" . $weblog_to_feed[ $value ][ "id" ];
						$sql .= " AND " . $name . "=\"" . $this->db->escape_str( $data[ "field_id_" . $weblog_to_feed[ $value ][ "id" ] ] ) . "\"";
					}
				}
			}

			$query = $this->db->query( $sql );

		}

		// Return matching entry id or zero if no match
		$return_id = 0;
		if ( $query->num_rows > 0) {
			$row = $query->row();
			$return_id = $row->entry_id;
		}
		$query->free_result();

		return $return_id;
	}

	/**
	 * Create a list of categories for an entry
	 *
	 * @param string $item 
	 * @return void
	 */
	function _find_and_create_categories( $category_value, $cat_field, $cat_delimiter="", $cat_group, $site_id ) {

		$entry_categories = array();
		
		if ( $category_value != "" ) {
			if( is_numeric( $category_value ) ) {
				$entry_categories[] = $category_value;
			} else {
				$entry_categories[] = $this->_create_category( $category_value, $cat_group, $site_id );
			}
		}
		
		if ( $cat_field != '' ) {

			if ( $cat_delimiter != "" ) {
				$cats = explode( $cat_delimiter, $cat_field );
			} else {
				$cats = array( $cat_field );
			}
			
			// Remove duplicates (after trimming whitespace)
			foreach( $cats as $idx => $cat ) {
				$cats[ $idx ] = trim( $cat );
			}
			$cats = array_unique( $cats );
			
			// Add category to database
			foreach($cats as $cat ) {
				$entry_categories[] = $this->_create_category( $cat, $cat_group, $site_id );
			}
		}
		
		return $entry_categories;
	}
	
	/**
	 * Create a category
	 *
	 * @param string $category_name 
	 * @param string $category_group 
	 * @return void
	 */
	function _create_category( $category_name, $category_group="", $site_id=1 ) {
		$category_name = trim($category_name);
		$sql = "SELECT * FROM exp_categories WHERE cat_name = '".$this->db->escape_str($category_name)."' AND group_id = ". $category_group;
		$query = $this->db->query( $sql );
		if ( $query->num_rows == 0) {
			
			$insert_array = array(
				'group_id'  	=> $category_group,
				'site_id' => $site_id,
				'cat_name' 	=> $category_name,
				'cat_url_title' => url_title( $category_name, $this->config->item('word_separator'), TRUE ),
				'cat_image' 	=> '',
				'parent_id'   => '0'
				);
			$this->db->query($this->db->insert_string('exp_categories', $insert_array));
			$category_id = $this->db->insert_id();
			
			 $insert_array = array(
				'cat_id'  	=> $category_id,
				'site_id' 	=> $site_id,
				'group_id' 	=> $category_group
			);
			$this->db->query($this->db->insert_string('exp_category_field_data', $insert_array));
			
			$this->return_data .= "<p>Add category: " . $category_name . " to group " . $category_group . "</p>\n";
			
			return $category_id;
		} else {
			$row = $query->row();
			return $row->cat_id;
		}
	}

	/**
	 * Add categories to an entry
	 *
	 * @param string $entry_id 
	 * @param string $cat_id 
	 * @return void
	 */
	function _add_entry_to_category( $entry_id, $cat_id ) {
		$this->db->query("INSERT IGNORE INTO exp_category_posts (entry_id, cat_id) VALUES ('".$entry_id."', '".$cat_id."')");
		if ($this->config->item('auto_assign_cat_parents') == 'y')
		{	
			$query = $this->db->query("SELECT parent_id FROM exp_categories WHERE cat_id = " . $cat_id);
			$row = $query->row();
			if( $row->parent_id != 0 ) {
				$this->_add_entry_to_category( $entry_id, $row->parent_id );
			}
		}
	}
	
	/**
	 * Fetch a field's fieldtype settings
	 *
	 * @param string $field_id 
	 * @return void
	 * @author Andrew Weaver
	 */
	function _get_channel_fields_settings( $field_id ) {

		$this->db->where( 'field_id', $field_id );
		$field_query = $this->db->get('exp_channel_fields');

		foreach ($field_query->result_array() as $row) {

			$field_data = '';
			$field_fmt = '';

			$field_fmt	= $row['field_fmt'];

			$settings = array(
				'field_instructions' => trim($row['field_instructions']),
				'field_text_direction' => ($row['field_text_direction'] == 'rtl') ? 'rtl' : 'ltr',
				'field_fmt' => $field_fmt,
				'field_data' => $field_data,
				'field_name' => 'field_id_'.$field_id,
			);

			$ft_settings = array();
			
			if (isset($row['field_settings']) && strlen($row['field_settings'])) {
				$ft_settings = unserialize(base64_decode($row['field_settings']));
			}

			$settings = array_merge($row, $settings, $ft_settings);

			$this->api_channel_fields->set_settings($field_id, $settings);
			
		}
	}

	function _prepare_update_data( $entry_id, &$data ) {

		/* EE channel api blanks any fields that don't have a value set 
			
			"as part of the data normalization, custom data with a value of NULL is transformed to 
			an empty string before database insertion."
			
			From: http://expressionengine.com/user_guide/development/api/api_channel_entries.html
			
			Api_channel_entries.php fills the empty fields in 2 places: _base_prep() and _update_entry()
			apparently to obey mysql strict mode (see: http://dev.mysql.com/doc/refman/5.0/en/server-sql-mode.html)

			Options:
			
			1) Don't allow partial updates (or rather use default EE behaviour of clearing data)
			2) Load data array with old data (requires knowledge of 3rd party fieldtypes and is
			   liable to change between fieldtype versions)
			3) Do some tricks with extensions (may not be possible)
			4) Overide update routine with DataGrab's own function (likely to be EE version specific)
			
		*/

		// print_r( $data );
		
		$this->db->select( "title, status, author_id" );
		$this->db->where( "entry_id", $entry_id );
		$query = $this->db->get( "exp_channel_titles" );
		$row = $query->row_array();

		if( !isset( $data["title"] ) || $data["title"] == "" ) {
			$data["title"] = $row["title"];
		}

		if( $this->settings["status"] == "default" ) {
			$data["status"] = $row["status"];
		}

		if( !isset( $this->settings["author_field"] ) || $this->settings["author_field"] == "" ) {
			$data["author_id"] = $row["author_id"];
		}

		/* 
		
		What else?
		
		Retain existing categories or not? If different category group is used...

		*/
		
	}
	
	/*
		OVERRIDE CHANNEL ENTRIES UPDATE
	*/	
	
	/**
	 * Update entry
	 *
	 * Handles updating of existing entries from arbitrary, authenticated source
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	mixed
	 */
	function _ajw_datagrab_update_entry($entry_id, $data, $autosave = FALSE)
	{
		$this->api_channel_entries->data =& $data;
		$mod_data = array();
		$this->_initialize(array('entry_id' => $entry_id, 'autosave' => $autosave));
		
		// AJW - added
		$original_data = $data;

		if ( ! $this->api_channel_entries->entry_exists($this->api_channel_entries->entry_id))
		{
			return $this->api_channel_entries->_set_error('no_entry_to_update');
		}

		if ( ! $this->api_channel_entries->_base_prep($data))
		{
			return FALSE;
		}

		if ($this->api_channel_entries->trigger_hook('entry_submission_start') === TRUE)
		{
			return TRUE;
		}
			
		$this->api_channel_entries->_fetch_channel_preferences();
		$this->api_channel_entries->_do_channel_switch($data);

		// We break out the third party data here
		$this->api_channel_entries->_fetch_module_data($data, $mod_data);
	
		$this->api_channel_entries->_check_for_data_errors($data);

		// Lets make sure those went smoothly
	
		if (count($this->api_channel_entries->errors) > 0)
		{
			return ($this->api_channel_entries->autosave) ? $this->api_channel_entries->errors : FALSE;
		}
	
		$this->api_channel_entries->_prepare_data($data, $mod_data);

		$this->api_channel_entries->_build_relationships($data);
	
		$meta = array(
						'channel_id'				=> $this->api_channel_entries->channel_id,
						'author_id'					=> $data['author_id'],
						'site_id'					=> $this->config->item('site_id'),
						'ip_address'				=> $this->input->ip_address(),
						'title'						=> ($this->config->item('auto_convert_high_ascii') == 'y') ? ascii_to_entities($data['title']) : $data['title'],
						'url_title'					=> $data['url_title'],
						'entry_date'				=> $data['entry_date'],
						'edit_date'					=> date("YmdHis"),
						'versioning_enabled'		=> $data['versioning_enabled'],
						'year'						=> date('Y', $data['entry_date']),
						'month'						=> date('m', $data['entry_date']),
						'day'						=> date('d', $data['entry_date']),
						'expiration_date'			=> $data['expiration_date'],
						'comment_expiration_date'	=> $data['comment_expiration_date'],
						'recent_comment_date'		=> (isset($data['recent_comment_date']) && $data['recent_comment_date']) ? $data['recent_comment_date'] : 0,
						'sticky'					=> (isset($data['sticky']) && $data['sticky'] == 'y') ? 'y' : 'n',
						'status'					=> $data['status'],
						'allow_comments'			=> $data['allow_comments'],
					 );

		$this->api_channel_entries->meta =& $meta;
	
		$meta_keys = array_keys($meta);
		$meta_keys = array_diff($meta_keys, array('channel_id', 'entry_id', 'site_id'));

		foreach($meta_keys as $k)
		{
			unset($data[$k]);
		}

		if ($this->api_channel_entries->trigger_hook('entry_submission_ready') === TRUE)
		{
			return TRUE;
		}
			
	
		if ($this->api_channel_entries->autosave)
		{
			// autosave is done at this point, title and custom field insertion.
			// no revisions, stat updating or cache clearing needed.
			return $this->_update_entry($meta, $data, $mod_data);
		}

		// AJW - remove any data we don't need
		foreach( $data as $key => $value ) {
			if( !isset( $original_data[ $key ] ) ) {
				unset( $data[ $key ] );
			}
		}

		$this->_update_entry($meta, $data, $mod_data);

		if (count($mod_data) > 0)
		{
			$this->api_channel_entries->_set_mod_data($meta, $data, $mod_data);
		}		
	
		$this->api_channel_entries->_sync_related($meta, $data);

		if (isset($data['save_revision']) && $data['save_revision'])
		{
			return TRUE;
		}
	
		if (isset($data['ping_servers']) && count($data['ping_servers']) > 0)
		{
			$this->api_channel_entries->send_pings($data['ping_servers'], $this->api_channel_entries->channel_id, $entry_id);
		}

		$this->stats->update_channel_stats($this->api_channel_entries->channel_id);

		if (isset($data['old_channel']))
		{
			$this->stats->update_channel_stats($data['old_channel']);
		}

		if ($this->config->item('new_posts_clear_caches') == 'y')
		{
			$this->functions->clear_caching('all');
		}
		else
		{
			$this->functions->clear_caching('sql');
		}
	
		// I know this looks redundant in July of 2009, but if the code moves
		// around, putting this return here now will ensure it doesn't get
		// forgotten in the future. -dj
		if ($this->api_channel_entries->trigger_hook('entry_submission_end') === TRUE)
		{
			return TRUE;
		}

		return TRUE;
	}

	function _initialize($params = array())
	{
		$this->api_channel_entries->errors = array();
	
		foreach ($params as $param => $val)
		{
			$this->api_channel_entries->{$param} = $val;
		}
	}
	
	/**
	 * Update Entry
	 *
	 * Updates primary data for an entry
	 *
	 * @access	private
	 * @param	mixed
	 * @param	mixed
	 * @return	void
	 */
	function _update_entry($meta, &$data, &$mod_data)
	{
		$meta['dst_enabled'] =  $this->api_channel_entries->_cache['dst_enabled'];
	
		// Check if the author changed
		$this->db->select('author_id');
		$query = $this->db->get_where('channel_titles', array('entry_id' => $this->api_channel_entries->entry_id));
		$old_author = $query->row('author_id') ;

		// autosave doesn't impact these stats
	
		if ( ! $this->api_channel_entries->autosave && $old_author != $meta['author_id'])
		{
			// Decremenet the counter on the old author

			$this->db->where('member_id', $old_author);
			$this->db->set('total_entries', 'total_entries-1', FALSE);
			$this->db->update('members');


			$this->db->where('member_id', $meta['author_id']);
			$this->db->set('total_entries', 'total_entries+1', FALSE);
			$this->db->update('members');
		}

		// Update the entry data
	
		unset($meta['entry_id']);
	
		if ($this->api_channel_entries->autosave)
		{
			$this->db->delete('channel_entries_autosave', array('original_entry_id' => $this->api_channel_entries->entry_id)); // remove all entries for this
			$meta['original_entry_id'] = $this->api_channel_entries->entry_id;
			$this->db->insert('channel_entries_autosave', $meta); // reinsert
		}
		else
		{
			$this->db->where('entry_id', $this->api_channel_entries->entry_id);
			$this->db->update('channel_titles', $meta);
		}
	
		// Update Custom fields
		$cust_fields = array('channel_id' =>  $this->api_channel_entries->channel_id);

		foreach ($data as $key => $val)
		{
			if (strncmp($key, 'field_offset_', 13) == 0)
			{
				unset($data[$key]);
				continue;
			}

			if (strncmp($key, 'field', 5) == 0) 
			{
				if (strncmp($key, 'field_id_', 9) == 0 && ! is_numeric($val))
				{
					if ($this->config->item('auto_convert_high_ascii') == 'y')
					{
						$cust_fields[$key] = (is_array($val)) ? $this->api_channel_entries->_recursive_ascii_to_entities($val) : $val;
					}
					else
					{
						$cust_fields[$key] = $val;
					}
				}
				else
				{
					$cust_fields[$key] = $val;
				}
			}
		}

		if (count($cust_fields) > 0)
		{
			if ($this->api_channel_entries->autosave)
			{
				// Need to add to our custom fields array
			
				$this->api_channel_entries->instantiate('channel_categories');
	
				if ($this->api_channel_categories->cat_parents > 0)
				{
					$this->api_channel_categories->cat_parents = array_unique($this->api_channel_categories->cat_parents);
				
					sort($this->api_channel_categories->cat_parents);

					foreach($this->api_channel_categories->cat_parents as $val)
					{
						if ($val != '')
						{
							$mod_data['category'][] = $val;
						}
					}
				}

				// Entry for this was made earlier, now its an update not an insert
				$cust_fields['entry_id'] = $this->api_channel_entries->entry_id;
				$cust_fields['original_entry_id'] = $this->api_channel_entries->entry_id;
				$this->db->where('original_entry_id', $this->api_channel_entries->entry_id);
				$this->db->set('entry_data', serialize(array_merge($cust_fields, $mod_data))); 
				$this->db->update('channel_entries_autosave'); // reinsert
			}
			else
			{
				// Check that data complies with mysql strict mode rules
				$all_fields = $this->db->field_data('channel_data');

				foreach ($all_fields as $field)
				{
					if (strncmp($field->name, 'field_id_', 9) == 0)
					{
						if ($field->type == 'text' OR $field->type == 'blob')
						{
							if ( ! isset($cust_fields[$field->name]) OR is_null($cust_fields[$field->name]))
							{	
								// AJW - leave this unset, and not empty string
								// $cust_fields[$field->name] = '';
							}
						}
						elseif ($field->type == 'int' && isset($cust_fields[$field->name]) && $cust_fields[$field->name] === '')
						{
							//$cust_fields[$field->name] = 0;
							unset($cust_fields[$field->name]);
						}
					}
				} 
				
				$this->db->where('entry_id', $this->api_channel_entries->entry_id);
				$this->db->update('channel_data', $cust_fields);
			}
		}

		if ($this->api_channel_entries->autosave)
		{
			return $this->api_channel_entries->entry_id;
		}

		// Remove any autosaved data
		$this->db->delete('channel_entries_autosave', array('original_entry_id' => $this->api_channel_entries->entry_id));

		// Delete Categories - resubmitted in the next step
		$this->db->delete('category_posts', array('entry_id' => $this->api_channel_entries->entry_id));		
	}
	
	/*
		HELPER FUNCTIONS
	*/

	function _check_mem_usage( $label ) {
		$mem_usage = memory_get_usage();
		print "<p>" . $label . ": " . $mem_usage . " (" . number_format( $mem_usage - $this->mem_usage, 0, '.', ',' ) . ")" . "</p>";
		$this->mem_usage = $mem_usage;
	}

}

?>