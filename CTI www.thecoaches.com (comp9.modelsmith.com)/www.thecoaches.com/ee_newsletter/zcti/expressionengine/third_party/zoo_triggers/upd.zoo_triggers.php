<?php 

if (!defined('BASEPATH')) exit('Invalid file request');
if (!defined('PATH_THIRD')) define('PATH_THIRD', EE_APPPATH.'third_party/');
	require_once PATH_THIRD.'zoo_triggers/config.php';

/**
 * Zoo Triggers Update Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@eezoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://eezoo.com)
 */
class Zoo_triggers_upd
{
	var $version = ZOO_TRIGGERS_VER; 
	var $module_name = ZOO_TRIGGERS_CLASS;
	
	function Zoo_triggers_upd() 
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	} 
	
	function install() 
	{
		// Insert module data
		$data = array(
			'module_name' => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);
		
		$this->EE->db->insert('modules', $data);
		
		return TRUE;
	}
	
	function uninstall() 
	{
		// Delete module and his actions
		$this->EE->db->select('module_id');
		$query = $this->EE->db->get_where('modules', array('module_name' => $this->module_name));
		
		$this->EE->db->where('module_id', $query->row('module_id'));
		$this->EE->db->delete('module_member_groups');
		
		$this->EE->db->where('module_name', $this->module_name);
		$this->EE->db->delete('modules');
		
		$this->EE->db->where('class', $this->module_name);
		$this->EE->db->delete('actions');
		
		$this->EE->db->where('class', $this->module_name.'_mcp');
		$this->EE->db->delete('actions');
		
		return TRUE;
	}
	
	function update($current = '')
	{
		if (!$current || $current == $this->version)
		{
			return FALSE;
		}
		
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->update('extensions', array('version' => $this->version));
	}
}