<?php 

if (!defined('BASEPATH')) exit('Invalid file request');
require_once PATH_THIRD.'zoo_triggers/config.php';
require_once PATH_THIRD.'zoo_triggers/helper.php';

/**
 * Zoo Triggers Extension Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@eezoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://eezoo.com)
 */
class Zoo_triggers_ext 
{
	var $base;
	var $form_base;
	var $name = ZOO_TRIGGERS_NAME;
	var $class_name = ZOO_TRIGGERS_CLASS;
	var $settings_exist = 'n';
	var $docs_url = ZOO_TRIGGERS_DOCS;
	var $version = ZOO_TRIGGERS_VER;
	var $tagger_version = null;
	
	var $settings_default = array(
								'triggers' => array(
									'tag' => array('tag'),
									'category' => array('category'),
									'archive' => array('archive')
								),
								'settings' => array(
									'entries_operator' => '|',
									'entries_title_categories_prefix' => ' in categories ',
									'entries_title_categories_postfix' => '',
									'entries_title_categories_separator' => ', ',
									'entries_title_categories_separator_last' => ' and ',
									'entries_title_archives_first' => 'month',
									'entries_title_archives_prefix' => ' in ',
									'entries_title_archives_postfix' => '.',
									'entries_title_archives_separator' => ' ',
									'entries_title_archives_year' => 'Y',
									'entries_title_archives_month' => 'F',
									'entries_title_tag_prefix' => ' in tags ',
									'entries_title_tag_postfix' => '',
									'entries_title_tag_separator' => ', ',
									'entries_title_tag_separator_last' => ' and ',
								)
							);

	/**
	 * Extension Constructor
	 */
	function Zoo_triggers_ext()
	{
		$this->EE =& get_instance();
		
		// Load settings
		$extension_settings = $this->EE->db->get_where('extensions', array('class' => $this->class_name .'_ext', 'hook' => 'sessions_start'), 1)->row();
		$this->settings = (isset($extension_settings->settings)) ? unserialize($extension_settings->settings) : "";
		
		// Variables
		$this->helper = new Zoo_triggers_helper();
		$this->uri = explode('/', $this->EE->uri->uri_string);
		$this->page = null;
		
		// Define some global vars
		$this->set_segments();
		$this->set_globals();
	}

	// --------------------------------------------------------------------
	
	function hook_sessions_start($session)
	{
		if ($this->EE->extensions->last_call !== FALSE)
		{
			$session = $this->EE->extensions->last_call;
		}
		
		// Should I stay or should I go to …
		if($this->sessions_start_init())
		{
			// Look for soldiers
			foreach($this->settings['triggers'] as $type => $triggers)
			{
				// … with the skills you've set …
				foreach($triggers as $trigger)
				{
					// … if you found a good soldier …
					if(array_search(trim($trigger), $this->uri) !== FALSE)
					{
						// … add it to your troops.
						$this->settings['trigger_segments'][array_search(trim($trigger), $this->uri)] = $type;
					}
				}
			}
			
			// Sort the soldiers
			if(isset($this->settings['trigger_segments']))
				ksort($this->settings['trigger_segments']);
			
			// Divide & conquer
			$current_type = "";
			foreach($this->uri as $key => $type)
			{
				if(isset($this->settings['trigger_segments'][$key]))
				{
					$this->settings['trigger_parameters'][$this->settings['trigger_segments'][$key]] = array();
					$current_type = $this->settings['trigger_segments'][$key];
				}
				else if($key)
				{
					$this->settings['trigger_parameters'][$current_type][$key] = $type;
				}
			}
			
			// Change URI
			$this->sessions_start_rewrite_categories();
			$this->sessions_start_rewrite_archive();
			$this->sessions_start_rewrite_tags();
			$this->sessions_start_reparse();
			$this->set_globals();
		}
		
		return $session;
	}
	
	function hook_sessions_end($session)
	{
		if ($this->EE->extensions->last_call !== FALSE)
		{
			$session = $this->EE->extensions->last_call;
		}
		
		return $session;
	}
	
	function hook_channel_module_create_pagination($channel)
	{
		$channel->p_page = $this->page;
		$channel->basepath = $this->EE->config->slash_item('site_url') . $this->global_vars['original_uri']; 
		
		return $channel;
	}
	
	function hook_cp_css_end($style)
	{
		if ($this->EE->extensions->last_call !== FALSE)
		{
			$script = $this->EE->extensions->last_call;
		}
		
		// Load css
		$style .= $this->get_include_contents(PATH_THIRD . "zoo_triggers/cp/css/zoo_triggers.css");
		
		return $style;
	}
	
	function hook_cp_js_end($script)
	{
		if ($this->EE->extensions->last_call !== FALSE)
		{
			$script = $this->EE->extensions->last_call;
		}
		
		// Load javascript
		$script .= $this->get_include_contents(PATH_THIRD . "zoo_triggers/cp/javascript/scripts.js");
		$script .= $this->get_include_contents(PATH_THIRD . "zoo_triggers/cp/javascript/zoo_triggers.js");
		
		return $script;
	}
	
	// --------------------------------------------------------------------
	
	function sessions_start_init()
	{
		return isset($this->EE->uri->uri_string) && $this->EE->uri->uri_string != '';
	}
	
	function sessions_start_rewrite_categories()
	{
		// Check if category is available
		if( !empty($this->settings['trigger_parameters']['category']) )
		{
			// Variabels
			$cat_ids = array();
			$cat_names = array();
			
			// Remove the trigger and parameters from the URI
			unset($this->uri[array_search('category', $this->settings['trigger_segments'])]);
			foreach($this->settings['trigger_parameters']['category'] as $segment_key => $segment_value)
			{
				unset($this->uri[$segment_key]);
			}
			
			// Get categories
			$categories = $this->EE->db->select('cat_id, cat_name, cat_url_title, cat_description, cat_image, cat_order')
									   ->where_in('cat_url_title', $this->settings['trigger_parameters']['category'])
									   ->where('site_id', $this->EE->config->item('site_id'))
									   ->get('categories')
									   ->result_array();
			
			// Loop results
			for ($i = 1; $i <= count($categories); $i++)
			{
				// Assign specials
				array_push($cat_ids, $categories[$i - 1]['cat_id']);
				array_push($cat_names, $categories[$i - 1]['cat_name']);
				
				// Assign the globals
				$this->global_vars['cat_id_'.$i] = $categories[$i - 1]['cat_id'];
				$this->global_vars['cat_name_'.$i] = $categories[$i - 1]['cat_name'];
				$this->global_vars['cat_url_title_'.$i] = $categories[$i - 1]['cat_url_title'];
				$this->global_vars['cat_description_'.$i] = $categories[$i - 1]['cat_description'];
				$this->global_vars['cat_image_'.$i] = $categories[$i - 1]['cat_image'];
				$this->global_vars['cat_order_'.$i] = $categories[$i - 1]['cat_order'];
			}
			// Create the entries code
			$this->global_vars['entries'] .= ' category="' . implode($this->settings['settings']['entries_operator'], $cat_ids) . '"';
			
			// Create the title
			$cat_names = array_unique($cat_names);
			if(count($cat_names) > 1)
			{
				$this->global_vars['entries_title'] .= $this->settings['settings']['entries_title_categories_prefix'] . implode($this->settings['settings']['entries_title_categories_separator'], array_slice($cat_names, 0, count($cat_names) - 1 )) . ((count($cat_names) > 1) ? $this->settings['settings']['entries_title_categories_separator_last'] . end($cat_names) : ''). $this->settings['settings']['entries_title_categories_postfix'];
				$this->global_vars['entries_title_category'] = $this->global_vars['entries_title'];
			}
			elseif(isset($cat_names[0]))
			{
				$this->global_vars['entries_title'] .= $this->settings['settings']['entries_title_categories_prefix'] . $cat_names[0] . $this->settings['settings']['entries_title_categories_postfix'];
				$this->global_vars['entries_title_category'] = $this->global_vars['entries_title'];
			}
			else
			{
				$this->global_vars['entries_title'] .= "";
			}   $this->global_vars['entries_title_category'] = "";
		}
	}
	
	function sessions_start_rewrite_archive()
	{
		// Load the default language
		$this->EE->lang->load('core', $this->EE->config->config['deft_lang']);
		
		// Check if category is available
		if( !empty($this->settings['trigger_parameters']['archive']) )
		{
			$count = 1;
			$valid = true;
			$year = null;
			$month = null;
			$segmentdate = (strlen(implode("-", $this->settings['trigger_parameters']['archive'])) > 4) ? strtotime(implode("-", $this->settings['trigger_parameters']['archive'])) : strtotime(implode("-", $this->settings['trigger_parameters']['archive']) . "-01");
			
			foreach($this->settings['trigger_parameters']['archive'] as $key => $segment)
			{
				// Year
				if($count == 1)
				{
					if(is_numeric($segment))
					{
						// Assign the globals
						$this->global_vars['year'] = $segment;
						
						// Create the entries code
						$this->global_vars['entries'] .= ' year="' . $segment . '"';
						
						// Create the title var
						$year = lang(date($this->settings['settings']['entries_title_archives_year'], $segmentdate));
					}
					else
					{
						$valid = false;
					}
				}
				
				// Month
				if($count == 2)
				{
					if(is_numeric($segment))
					{
						// Assign the globals
						$this->global_vars['month'] = ltrim($segment, "0");
						
						// Create the entries code
						$this->global_vars['entries'] .= ' month="' . ltrim($segment, "0") . '"';
						
						// Create the title var
						$month = lang(date($this->settings['settings']['entries_title_archives_month'], $segmentdate));
					}
					else
					{
						$valid = false;
					}
				}
				
				// Count
				$count++;
			}
			
			// Add title
			if($year || $month)
			{
				$this->global_vars['entries_title_archive'] .= $this->settings['settings']['entries_title_archives_prefix'];
				if($this->settings['settings']['entries_title_archives_first'] == "year")
				{
					$this->global_vars['entries_title_archive'] .= $year . $this->settings['settings']['entries_title_archives_separator'] . $month;
				}
				else
				{
					$this->global_vars['entries_title_archive'] .= $month . $this->settings['settings']['entries_title_archives_separator'] . $year;
				}
				$this->global_vars['entries_title_archive'] .= $this->settings['settings']['entries_title_archives_postfix'];
				
				
				$this->global_vars['entries_title'] .= $this->global_vars['entries_title_archive'];
			}
			
			// Remove the trigger and parameters from the URI
			if($valid)
			{
				unset($this->uri[array_search('archive', $this->settings['trigger_segments'])]);
				foreach($this->settings['trigger_parameters']['archive'] as $segment_key => $segment_value)
				{
					unset($this->uri[$segment_key]);
				}
			}
		}
	}
	
	function sessions_start_rewrite_tags()
	{
		// Check if category is available
		if(($this->helper->is_installed('Tag') || $this->helper->is_installed('Tagger')) && !empty($this->settings['trigger_parameters']['tag']))
		{
			// Variabels
			$tag_ids = array();
			$tag_names = array();
			
			// Remove the trigger and parameters from the URI and perpare the tag
			unset($this->uri[array_search('tag', $this->settings['trigger_segments'])]);
			foreach($this->settings['trigger_parameters']['tag'] as $segment_key => $segment_value)
			{
				$this->settings['trigger_parameters']['tag'][$segment_key] = str_replace("+", " ", $segment_value);
				unset($this->uri[$segment_key]);
			}
			
			// Tagger (DevDeamon)
			if($this->helper->is_installed('Tagger'))
			{
				$this->tagger_version = $this->EE->db->get_where('modules', array('module_name' => 'Tagger'), 1)->row('module_version');
				
				// Get tags
				if(version_compare($this->tagger_version, '3.0.0') >= 0)
				{
					$tags = $this->EE->db->select('tag_name, GROUP_CONCAT(entry_id SEPARATOR "|") as tag_ids')
									 ->join('tagger_links', 'tagger.tag_id = tagger_links.tag_id', 'left')
									 ->where_in('tag_name', $this->settings['trigger_parameters']['tag'])
									 ->where('tagger_links.site_id', $this->EE->config->item('site_id'))
									 ->group_by('tag_name')
									 ->get('tagger')
									 ->result_array();
				}
				else
				{
					$tags = $this->EE->db->select('tag_name, GROUP_CONCAT(item_id SEPARATOR "|") as tag_ids')
									 ->join('tagger_links', 'tagger.tag_id = tagger_links.tag_id', 'left')
									 ->where_in('tag_name', $this->settings['trigger_parameters']['tag'])
									 ->where('tagger_links.site_id', $this->EE->config->item('site_id'))
									 ->group_by('tag_name')
									 ->get('tagger')
									 ->result_array();
				}
			}
			// Tag (Solspace)
			elseif($this->helper->is_installed('Tag'))
			{
				$tags = $this->EE->db->select('tag_tags.tag_name, GROUP_CONCAT(exp_tag_entries.entry_id SEPARATOR "|") as tag_ids')
									 ->join('tag_entries', 'tag_tags.tag_id = tag_entries.tag_id', 'left')
									 ->where_in('tag_name', $this->settings['trigger_parameters']['tag'])
									 ->where('tag_entries.site_id', $this->EE->config->item('site_id'))
									 ->group_by('tag_tags.tag_name')
									 ->get('tag_tags')
									 ->result_array();
			}
			
			// Loop results
			for ($i = 1; $i <= count($tags); $i++)
			{
				// Assign specials
				array_push($tag_ids, $tags[$i - 1]['tag_ids']);
				array_push($tag_names, $tags[$i - 1]['tag_name']);
				
				// Assign the globals
				$this->global_vars['tag_id_'.$i] = $tags[$i - 1]['tag_ids'];
				$this->global_vars['tag_name_'.$i] = $tags[$i - 1]['tag_name'];
			}
			
			// Create the entries code
			if(empty($tag_ids))
				$this->global_vars['entries'] .= ' entry_id="zoo_triggers:no_entries_found_for_tags"';
			else
				$this->global_vars['entries'] .= ' entry_id="' . implode('|', $tag_ids) . '"';
			
			// Create the title
			$tag_names = array_unique($tag_names);
			if(count($tag_names) > 1)
			{
				$this->global_vars['entries_title'] .= $this->settings['settings']['entries_title_tag_prefix'] . implode($this->settings['settings']['entries_title_tag_separator'], array_slice($tag_names, 0, count($tag_names) - 1 )) . ((count($tag_names) > 1) ? $this->settings['settings']['entries_title_tag_separator_last'] . end($tag_names) : ''). $this->settings['settings']['entries_title_tag_postfix'];
			}
			else if(isset($tag_names[0]))
			{
				$this->global_vars['entries_title'] .= $this->settings['settings']['entries_title_tag_prefix'] . $tag_names[0] . $this->settings['settings']['entries_title_tag_postfix'];
			}
			else
			{
				$this->global_vars['entries_title'] .= "";
			}
		}
	}
	
	function sessions_start_reparse()
	{
		// Add pagination for Structure
		if(isset($this->page))
		{
			array_push($this->uri, 'P' . $this->page);
		}
		
		// Set the new uri
		$this->EE->uri->uri_string = "/" . implode('/', $this->uri);
		
		// Clean up the mess
		$tmp_query_strings = $this->EE->config->config['enable_query_strings'];
		$this->EE->uri->segments = array();
		$this->EE->uri->rsegments = array();
		$this->EE->config->config['enable_query_strings'] = true;
		$this->EE->uri->_explode_segments();
		$this->EE->config->config['enable_query_strings'] = $tmp_query_strings;
		
		// Parse the URI again and reindex segments (EE->uri extends the CI URI class)
		$EERouting =& load_class('Router', 'core');
		$EERouting->_parse_routes();
		$this->EE->uri->_reindex_segments(); // Executes function from the CI core class to match uri and segments 1:1
	}
	
	// --------------------------------------------------------------------
	
	private function set_globals()
	{
		if(!isset($this->global_vars))
			$this->global_vars = array();
		
		$this->global_vars['original_uri'] = (!isset($this->EE->config->_global_vars['triggers:original_uri'])) ? $this->EE->uri->uri_string : $this->EE->config->_global_vars['triggers:original_uri'];
		$this->global_vars['entries'] = (!empty($this->global_vars['entries'])) ? $this->global_vars['entries'] : "";
		$this->global_vars['entries_title'] = (!empty($this->global_vars['entries_title'])) ? $this->global_vars['entries_title'] : "";
		$this->global_vars['entries_title_category'] = (!empty($this->global_vars['entries_title_category'])) ? $this->global_vars['entries_title_category'] : "";
		$this->global_vars['entries_title_archive'] = (!empty($this->global_vars['entries_title_archive'])) ? $this->global_vars['entries_title_archive'] : "";
		
		// Add all globals to the global vars
		foreach($this->global_vars as $global_key => $global_value)
		{
			$this->EE->config->_global_vars['triggers:' . $global_key] = $global_value;
		}
	}
	
	private function set_segments()
	{
		// Set global vars segments
		$this->global_vars['total_segments'] = (isset($this->EE->config->_global_vars['triggers:total_segments'])) ? $this->EE->config->_global_vars['triggers:total_segments'] : count($this->uri);
		for($segment_count = 1; $segment_count <= 9; $segment_count++)
		{
			$this->global_vars['segment_' . $segment_count] = (isset($this->EE->config->_global_vars['triggers:segment_' . $segment_count])) ? $this->EE->config->_global_vars['triggers:segment_' . $segment_count] : ((isset($this->uri[$segment_count - 1])) ? $this->uri[$segment_count - 1] : '');
		}
		
		// Set last and forlast segments
		if(preg_match('/^[P][0-9]+$/i', end($this->uri)))
		{
			// Remove the pagination
			$this->page = trim(end($this->uri), "P");
			
			// Set global vars
			$this->global_vars['last_segment'] = (isset($this->EE->config->_global_vars['triggers:last_segment'])) ? $this->EE->config->_global_vars['triggers:last_segment'] : $this->uri[(count($this->uri) - 2)];
			
			// Modify the uri
			array_pop($this->uri);
			$this->EE->uri->uri_string = implode('/', $this->uri);
		}
		else
		{
			// Set global vars
			$this->global_vars['last_segment'] = (isset($this->EE->config->_global_vars['triggers:last_segment'])) ? $this->EE->config->_global_vars['triggers:last_segment'] : $this->uri[(count($this->uri) - 1)];
		}
	}
	
	private function get_include_contents($filename)
	{
		if (is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return false;
	}
	
	// --------------------------------------------------------------------
	
	function activate_extension()
	{
		$this->EE->db->insert('extensions', array(
			'class'    => 'Zoo_triggers_ext',
			'hook'     => 'sessions_start',
			'method'   => 'hook_sessions_start',
			'settings' => serialize($this->settings_default),
			'priority' => 9,
			'version'  => $this->version,
			'enabled'  => 'y'
		));
		
		$this->EE->db->insert('extensions', array(
			'class'    => 'Zoo_triggers_ext',
			'hook'     => 'channel_module_create_pagination',
			'method'   => 'hook_channel_module_create_pagination',
			'settings' => '',
			'priority' => 10,
			'version'  => $this->version,
			'enabled'  => 'y'
		));
		
		$this->EE->db->insert('extensions', array(
			'class'    => 'Zoo_triggers_ext',
			'hook'     => 'cp_css_end',
			'method'   => 'hook_cp_css_end',
			'settings' => '',
			'priority' => 1,
			'version'  => $this->version,
			'enabled'  => 'y'
		));
		
		$this->EE->db->insert('extensions', array(
			'class'    => 'Zoo_triggers_ext',
			'hook'     => 'cp_js_end',
			'method'   => 'hook_cp_js_end',
			'settings' => '',
			'priority' => 1,
			'version'  => $this->version,
			'enabled'  => 'y'
		));
	}
	
	function update_extension($current = FALSE)
	{
		if (!$current || $current == $this->version)
		{
			return FALSE;
		}

		// add pagination and wygwam hooks
		if (version_compare($current, '1.0.1', '<'))
		{
			$this->EE->db->where(array('class' => __CLASS__, 'method' => 'hook_sessions_end', 'hook' => 'sessions_end'));
			$this->EE->db->update('extensions', array('method' => 'hook_sessions_start', 'hook' => 'sessions_start', 'priority' => 9));
		}
		
		// added tagger support
		if (version_compare($current, '1.0.4', '<'))
		{
			$extension_settings = $this->EE->db->get_where('extensions', array('class' => $this->class_name .'_ext', 'hook' => 'sessions_start'), 1)->row();
			if(isset($extension_settings->settings) && !empty($extension_settings->settings))
			{
				$this->settings = unserialize($extension_settings->settings);
				
				$this->settings['settings']['entries_title_tag_prefix'] = (!isset($this->settings['settings']['entries_title_tag_prefix'])) ? ' in tags ' : $this->settings['settings']['entries_title_tag_prefix'];
				$this->settings['settings']['entries_title_tag_postfix'] = (!isset($this->settings['settings']['entries_title_tag_postfix'])) ? '' : $this->settings['settings']['entries_title_tag_postfix'];
				$this->settings['settings']['entries_title_tag_separator'] = (!isset($this->settings['settings']['entries_title_tag_separator'])) ? ', ' : $this->settings['settings']['entries_title_tag_separator'];
				$this->settings['settings']['entries_title_tag_separator_last'] = (!isset($this->settings['settings']['entries_title_tag_separator_last'])) ? ' and ' : $this->settings['settings']['entries_title_tag_separator_last'];
				
				$this->EE->db->where(array('class' => $this->class_name .'_ext', 'hook' => 'sessions_start'))
							 ->update('extensions', array('settings' => serialize($this->settings)));
			}
		}
		
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->update('extensions', array('version' => $this->version));
	}

	function disable_extension()
	{
		$this->EE->db->query('DELETE FROM exp_extensions WHERE class = "Zoo_triggers_ext"');
	}

}
