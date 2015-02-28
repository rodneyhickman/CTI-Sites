<?php 

if (!defined('BASEPATH')) exit('Invalid file request');
require_once PATH_THIRD.'zoo_triggers/config.php';

/**
 * Zoo Triggers Helper Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@ee-zoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://ee-zoo.com)
 */
class Zoo_triggers_helper
{
	var $module_name = ZOO_TRIGGERS_NAME;
	var $module_class = ZOO_TRIGGERS_CLASS;
	
	function Zoo_triggers_helper()
	{
	    // Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	}
	
	// --------------------------------------------------------------------	
	
	function is_installed($addon, $type = "all") // Possible types are: module, extension, fieldtype, accessory or all
	{
		// Variables
		$installed = false;
		
		// Module
		if(($type == "all" || $type == "module") && $this->EE->db->where_in('module_name', $addon)->get('modules')->num_rows())
			$installed = true;
			
		// Extension
		if(($type == "all" || $type == "extension") && $this->EE->db->where_in('class', $addon . '_ext')->get('extensions')->num_rows())
			$installed = true;
			
		// Fieldtype
		if(($type == "all" || $type == "fieldtype") && $this->EE->db->where_in('name', $addon)->get('fieldtypes')->num_rows())
			$installed = true;
		
		// Accessories
		if(($type == "all" || $type == "accessory") && $this->EE->db->where_in('class', $addon . '_acc')->get('accessories')->num_rows())
			$installed = true;
		
		return $installed;
    }
	
	function in_url($input)
	{
		$uri = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
		$return = null;
		
		if(is_array($input))
		{
			$return = false;
			foreach($input as $category)
			{
				if(is_object($category) && in_array($category->cat_url_title, $uri))
				{
					$return = true;
				}
				elseif(in_array($category, $uri))
				{
					$return = true;
				}
			}
		}
		else
		{
			$return = in_array($input, $uri);
		}
		
		return $return;
	}
	
	function get_child_categories($category)
	{
		$categories = $this->EE->db->get_where('categories', array('parent_id' => $category))->result();
		$return = $categories;
		
		foreach($categories as $category)
		{
			$return = array_merge($return, $this->get_child_categories($category->cat_id));
		}
		
		return $return;
	}
	
	function simplify_array($array, $field = "")
	{
		$return = array();
		
		if(is_array($array) && !empty($array))
		{
			if(is_object($array[0]) || is_array($array[0]))
			{
				if(count($array) > 1 && !empty($field))
				{
					foreach($array as $key => $value)
					{
						if(is_object($value))
							array_push($return, $value->$field);
						else
							array_push($return, $value[$field]);
					}
				}
				else
				{
					foreach($array as $key => $value)
					{
						array_push($return, current($value));
					}
				}
				
				return $return;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}