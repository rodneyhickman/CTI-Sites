<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require PATH_THIRD.'nsm_categories/config.php';

/**
 * Install / Uninstall and updates the modules
 *
 * @package			NsmCategories
 * @version			1.0.0
 * @author			Leevi Graham <http://leevigraham.com>
 * @copyright 		Copyright (c) 2007-2012 Newism <http://newism.com.au>
 * @license 		Commercial - please see LICENSE file included with this distribution
 * @link			http://expressionengine-addons.com/nsm-categories
 * @see				http://expressionengine.com/public_beta/docs/development/modules.html#update_file
 */

class Nsm_categories_upd {
	
	public  $version = NSM_CATEGORIES_VERSION;
	public  $addon_id = NSM_CATEGORIES_ADDON_ID;
	private $has_cp_backend = false;
	private $has_publish_fields = false;
	private $has_tabs = false;

	private $actions = false;
	private $models = false;

	/**
	 * Constructor
	 *
	 * @access public
	 * @author Leevi Graham
	 */
	public function __construct() { 
	}    

	/**
	 * Installs the module
	 * 
	 * Installs the module, adding a record to the exp_modules table, creates and populates and necessary database tables, adds any necessary records to the exp_actions table, and if custom tabs are to be used, adds those fields to any saved publish layouts
	 *
	 * @access public
	 * @author Leevi Graham
	 * @return boolean
	 * @author Leevi Graham
	 **/
	public function install() {
		$EE =& get_instance();
		$data = array(
			'module_name' => ucwords(NSM_CATEGORIES_ADDON_ID),
			'module_version' => $this->version,
			'has_cp_backend' => ($this->has_cp_backend) ? "y" : "n",
			'has_publish_fields' => ($this->has_publish_fields) ? "y" : "n"
		);

		$EE->db->insert('modules', $data);

		// Add the actions
		if($this->actions) {
			foreach ($this->actions as $action) {
				$parts = explode("::", $action);
				$EE->db->insert('actions', array(
					"class" => $parts[0],
					"method" => $parts[1]
				));
			}
		}

		// Install the model tables
		if($this->models) {
			foreach($this->models as $model) {
				$EE->load->model($model);

				if(method_exists($EE->$model, "create_table")) {
					$EE->$model->create_table();
				}
			}
		}

		if($this->has_publish_fields) {
			$EE->load->library('layout');
			$EE->layout->add_layout_tabs($this->tabs(), strtolower($data['module_name']));
		}

		return TRUE;
	}

	/**
	 * Updates the module
	 * 
	 * This function is checked on any visit to the module's control panel, and compares the current version number in the file to the recorded version in the database. This allows you to easily make database or other changes as new versions of the module come out.
	 *
	 * @access public
	 * @author Leevi Graham
	 * @return Boolean FALSE if no update is necessary, TRUE if it is.
	 **/
	public function update($current = FALSE) {
		return FALSE;
	}

	/**
	 * Uninstalls the module
	 *
	 * @access public
	 * @author Leevi Graham
	 * @return Boolean FALSE if uninstall failed, TRUE if it was successful
	 **/
	public function uninstall() {

		$EE =& get_instance();
		$module_name = ucwords(NSM_CATEGORIES_ADDON_ID);

		$EE->db->select('module_id');
		$query = $EE->db->get_where('modules', array('module_name' => $module_name));

		$EE->db->where('module_id', $query->row('module_id'));
		$EE->db->delete('module_member_groups');

		$EE->db->where('module_name', $module_name);
		$EE->db->delete('modules');

		$EE->db->where('class', $module_name);
		$EE->db->delete('actions');

		$EE->db->where('class', $module_name . "_mcp");
		$EE->db->delete('actions');
		
		if($this->has_publish_fields) {
			$EE->load->library('layout');
			$EE->layout->delete_layout_tabs($this->tabs(), $module_name);
		}

		return TRUE;
	}

	
	private function tabs() {
		// The tab key must be the addon class name from what I can tell
		// I don't think it's possible to add more than one tab either
		$tab_key = ucwords(NSM_CATEGORIES_ADDON_ID);
		return array
		(
			$this->addon_id => array
			(
				"field_1" => array(
					'visible'		=> 'true',
					'collapse'		=> 'false',
					'htmlbuttons'	=> 'false',
					'width'			=> '100%'
				)
			)
		);
		
	}


}