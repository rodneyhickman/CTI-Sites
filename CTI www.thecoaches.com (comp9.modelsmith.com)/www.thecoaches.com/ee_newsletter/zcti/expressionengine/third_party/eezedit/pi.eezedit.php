<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/**
====================================================================================================
 Author: Rob Davidson @ Custom Mojo
 http://custommojo.com
====================================================================================================
 This file must be placed in the /system/expressionengine/third_party/easy_edit folder in your ExpressionEngine installation.
 package:		EE-z Edit (EE2 Version)
 copyright:		Copyright (c) 2012 Rob Davidson.  All Rights Reserved.
----------------------------------------------------------------------------------------------------
 Purpose: To provide easy edit capibility for ExpressionEngine. 
====================================================================================================

License:
	This software is licensed under version 2 (two) of the GPL (General Public Licence).
	See included LICENSE.txt file for additional details.
	 
**/
 
$plugin_info = array(
	'pi_name'		=> 'EE-z Edit',
	'pi_version'	=> '2.0.6',
	'pi_author'		=> 'Rob Davidson',
	'pi_author_url'	=> 'http://custommojo.com',
	'pi_description'=> 'Provide easy edit and creation capability for ExpressionEngine entries.',
	'pi_usage'		=> eezedit::usage()
);

class eezedit {
	
	public $return_data;
	
	public function __construct() {
		
		$this->EE =& get_instance();
		
		// if ($this->EE->session->userdata('group_id') >= 6) {
		// 	return NULL;			
		// }
		
		/** Get the plugin parameters. **/
	 	$channel_name	= $this->get_param('channel_name', FALSE, FALSE, false);
	 	$class			= $this->get_param('class', FALSE, FALSE, FALSE);
		$entry_id 		= $this->get_param('entry_id', FALSE, FALSE, FALSE);
		$is_list		= $this->get_param('list', FALSE, TRUE, FALSE);
	 	$sb_width 		= $this->get_param('box_width', 1360, FALSE, FALSE);
	 	$sb_height 		= $this->get_param('box_height', 768, FALSE, FALSE);
	 	$shadowbox 		= $this->get_param('shadowbox', 'yes', TRUE, FALSE);
		$show_add		= $this->get_param('add', FALSE, TRUE, FALSE);
		$show_edit		= $this->get_param('edit', TRUE, TRUE, FALSE);
	 	$size			= $this->get_param('size', 24, FALSE, FALSE);
	 	
		if (!$channel_name && !$entry_id && !$show_edit) {
			show_error(lang('You must define a <strong>channel_name</strong> or <strong>entry_id</strong> when using the <strong>edit="no"</strong> action.'));
		}

		if (!$channel_name && (!$entry_id || !is_numeric($entry_id)) && $show_edit) {
			show_error(lang('You must define a numerical <strong>entry_id</strong> when using the <strong>"edit"</strong> action.'));
		}
		
	 	if (!$channel_name) {
			$channel = $this->get_channel_by_entry_id($entry_id);
			if (!$channel) {
				show_error(lang('The <strong>entry_id</strong> <em>"' . $entry_id . '"</em> is not a valid entry id.'));
			}
	 	}
	 	else {
	 		$channel = $this->get_channel_by_name($channel_name);
			if (!$channel) {
				show_error(lang('The <strong>channel_name</strong> <em>"' . $channel_name . '"</em> is not a valid channel name.'));
			}
	 	}
		/** Initialize link variables **/
		$edit_link 		= NULL;
		$add_link 		= NULL;
		$shadowbox_rel 	= NULL;
		
		if ($shadowbox) {
			$shadowbox_rel = ' rel="shadowbox;width=' . $sb_width . ';height=' . $sb_height . ';" ';
		}		
		
		$link_style = ' display: block; padding: 3px; float: right; font-size: 11px; height: ' . $size . 'px; overflow: hidden; text-indent: 200%; white-space: nowrap; width: ' . ($size - 4) . 'px;';
		
		if ($show_edit) {
			
			if ($is_list) {
				$edit_link = '<a class="edit-entry ' . $class . '" style="background: url(\'/themes/third_party/eezedit/img/img_edit-page-' . $size . '.png\') no-repeat scroll center center transparent; ' . $link_style . '" class="' . $class . '" ' . $shadowbox_rel . ' href="/admin/index.php?S=0&D=cp&C=content_edit&channel_id=' . $channel->channel_id . '" target="_blank" title="View all ' . $channel->channel_title. ' items.">View all ' . $channel->channel_title. ' items.</a>';
			}
			else {
				$edit_link = '<a class="edit-entry ' . $class . '" style="background: url(\'/themes/third_party/eezedit/img/img_edit-page-' . $size . '.png\') no-repeat scroll center center transparent; ' . $link_style . '" class="' . $class . '" ' . $shadowbox_rel . ' href="/admin/index.php?S=0&D=cp&C=content_publish&M=entry_form&entry_id=' . $entry_id . '" target="_blank" title="Edit this entry.">Edit this entry.</a>';
			}
			
		}

		if ($show_add) {
			$add_link = '<a class="add-entry ' . $class . '" style="background: url(\'/themes/third_party/eezedit/img/img_add-page-' . $size . '.png\') no-repeat scroll center center transparent; ' . $link_style . '" class="' . $class . '" ' . $shadowbox_rel . ' href="/admin/index.php?S=0&D=cp&C=content_publish&M=entry_form&channel_id=' . $channel->channel_id . '" target="_blank" title="Add new ' . $channel->channel_title . ' item.">Add new ' . $channel->channel_title . ' item.</a>';
		}
		
		$div_style = 'display: block;';	 		 	
	 	$markup_output = '
	 	<div style="position: absolute; right: 10px; z-index: 99;" class="edit-links ' . $class . '">
	 		<div style="' . $div_style . '" class="' . $class . '">
			 	' . $add_link . '
				' . $edit_link . '	 			
	 		</div>
			<div class="clear"></div>
 		</div>
	 	';
	 	
	 	$this->return_data = $markup_output;
	 	return $this->return_data;
	 	
	}
	
	/** Get the specified plugin parameter. **/
	private function get_param($param_name, $default_value = NULL, $is_boolean = FALSE, $is_required = FALSE) {
		
		/** Get the value of the current parameter **/
		$param_value = $this->EE->TMPL->fetch_param($param_name);
		
		/** If the plugin is required and no value is assigned then throw an error. **/
		if($is_required && !$param_value) {
			show_error(lang('You must define the <strong>' . $param_name . '</strong> parameter in the <strong>' . __CLASS__ . '</strong> tag.'));
		}
		
		/** Assign the default value if necessary **/
		if($param_value === FALSE && $default_value !== FALSE) {
			$param_value = $default_value;
		}
		else {
			/** If the parameter is boolean then handle some user friendly goodness.
			Otherwise, perform additional parameter validation. **/ 
			if($is_boolean) {
				$param_value = strtolower($param_value);
				$param_value = ($param_value == 'true' || $param_value == 'yes') ? TRUE : FALSE;
			}
			else {
				
				switch ($param_name) {
					case 'action':
						/** Make sure a valid action is returned **/
						if ($param_value != 'edit' && $param_value != 'add') {
							$param_value = 'edit';
						}
						break;
						
					case 'size':
						/** Make sure a valid size is returned **/
						if($param_value != 24 && $param_value != 16) {
							$param_value = 32;
						}
						break;
				}
			}
		}
		
		return $param_value;
	}
		
 	/** Get a channel object by an entry_id that belongs to the channel. **/  
	function get_channel_by_entry_id($entry_id) {
		return $this->EE->db->query("
			SELECT * FROM exp_channels WHERE channel_id = " . $this->EE->db->query("
				SELECT channel_id FROM exp_channel_data WHERE entry_id = {$entry_id} LIMIT 0,1")->row('channel_id') . " LIMIT 0,1")->row('0');
	}

 	/** Get a channel object by its channel_id. **/  
	function get_channel_by_id($channel_id) {
		return $this->EE->db->query("SELECT * FROM exp_channels WHERE channel_id = " . $channel_id . " LIMIT 0,1")->row('0');
	}

 	/** Get a channel object by its channel_name. **/  
	function get_channel_by_name($channel_name) {
		return $this->EE->db->query("SELECT * FROM exp_channels WHERE channel_name = '" . $channel_name . "' LIMIT 0,1")->row('0');
	}

	/** Display the plugin instructions. **/
	public static function usage()
	{
		ob_start();
?>

--------------------------
 USAGE
--------------------------

Place inside a channel entry loop to add an edit link for that entry.
Place inside a listing page channel entry and use the 'add' action to add a link for creating new pages in that listing.

{exp:channel:entries}
	
	{exp:eezedit edit="yes|no" add="yes|no" entry_id="1234" channel_name="my_channel" shadowbox="yes|no" sb_width="800" sb_height="600" class="class-name"}
	
{/exp:channel:entries}

Override inline styles using !important

--------------------------
 PARAMETERS
--------------------------

edit: (yes/no) Show/hide the edit link.

add:  (yes/no) Show/hide the add link.

entry_id: The numeric entry_id of the current entry. (Required if edit="yes")

channel_name: The short name of the channel in which to add a new entry. (Required if no entry_id is supplied)

size: The default icon size to use. (Valid values are: 16, 24, and 32.  Default is 16)

shadowbox: (yes/no) Open the edit page in a modal Shadowbox popup. Defaults to yes. (Setting this to no will cause the edit page to open in a new window/tab.) 

box_width: The numerical value of the Shadowbox width in pixels. Defaults to 1360px.

box_height: The numerical value of the Shadowbox height in pixels. Defaults to 768px.

class: Apply a custom class to the edit/add link for further customization.

--------------------------
 REQUIREMENTS
--------------------------

Requires the Shadowbox.js library ( http://www.shadowbox-js.com/ )to be enabled for shadowbox="yes" to function properly.

--------------------------
 RECOMENDATIONS
--------------------------

It is recomended that you copy and paste the following styles into your sites css file as a base for styling.
  
.edit-links {
	right: 5px !important;
}
.edit-links a {
	margin-right: 0 !important;
}
a.add-entry,
a.edit-entry {
	border: 1px solid transparent !important;
	border-radius: 5px;
	display: block;
	font-size: 11px;
	font-weight: bold;
	float: right;
	overflow: hidden;
	margin: 5px;
	padding: 0 !important;
	text-indent: 200%;
	white-space: nowrap;
}
a.add-entry,
a.edit-entry.filled {
    background-color: #FFFFFF !important;
    margin: 5px 0;
}
a.add-entry:hover,
a.edit-entry:hover {
	background-color: #0f0 !important;
	box-shadow: 0 0 10px #0f0;
}
.edit-links.min,
a.add-entry.min {
	margin: 0 !important;
	right: 0 !important;
}

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	
	private function dpm($obj, $title) {
		return $title . ' =><br /><pre>' . print_r($obj, true) . '</pre>';
	}
}

/* End of file pi.eezedit.php */
