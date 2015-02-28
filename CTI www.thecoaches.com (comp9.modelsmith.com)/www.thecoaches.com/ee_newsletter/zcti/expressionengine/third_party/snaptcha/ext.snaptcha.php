<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine Snaptcha Extension
 *
 * @package		Snaptcha
 * @category	Extension
 * @description	Simple Non-obtrusive Automated Public Turing test to tell Computers and Humans Apart
 * @author		Ben Croker
 * @link		http://www.putyourlightson.net/snaptcha
 */
 
 
// get config
require_once PATH_THIRD.'snaptcha/config'.EXT;


class Snaptcha_ext
{
	var $name			= SNAPTCHA_NAME;
	var $version		= SNAPTCHA_VERSION;
	var $description	= SNAPTCHA_DESCRIPTION;
	var $settings_exist	= SNAPTCHA_SETTINGS_EXIST;
	var $docs_url		= SNAPTCHA_URL;
	
	var $settings		= array();
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 */
	function __construct($settings = '')
	{
		$this->EE =& get_instance();

		$this->settings = $settings;
	} 
	
	// --------------------------------------------------------------------
	
	/**
	 * Comment Form Field
	 */
	function comment_field($tagdata)
	{	
		// append field to tagdata
		$tagdata .= $this->_snaptcha_field();
		
		return $tagdata;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Comment Form Validation
	 */
	function comment_validate()
	{	
		if (!$this->_snaptcha_validate())
		{
			$this->EE->output->show_user_error('submission', $this->settings['error_message']);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Safecracker Field
	 */
	function safecracker_field($return)
	{	
		// append field to form
		$return = str_replace('</form>', $this->_snaptcha_field().NL.'</form>', $return);
		
		return $return;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Safecracker Validation
	 */
	function safecracker_validate(&$object)
	{	
		if (!$this->_snaptcha_validate())
		{
			$object->errors[] = $this->settings['error_message'];
		}
		
		return $object;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Freeform Field
	 */
	function freeform_field($r)
	{	
		// append field to form
		$r = str_replace('</form>', $this->_snaptcha_field().'</form>', $r);
		
		return $r;
	}
	// --------------------------------------------------------------------
	
	/**
	 * Freeform Validation
	 */
	function freeform_validate($errors)
	{	
		if (!$this->_snaptcha_validate())
		{
			$errors[] = $this->settings['error_message'];
		}
		
		return $errors;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Member Register Validation
	 */
	function member_register_validate()
	{	
		// if enabled
		if ($this->settings['member_registration_validation'])
		{
			// member register security level must be less than 3
			$member_register_security_level = ($this->settings['security_level'] < 3) ? $this->settings['security_level'] : 2;
			
			if (!$this->_snaptcha_validate($member_register_security_level))
			{
				$this->EE->output->show_user_error('submission', $this->settings['error_message']);
			}
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Forum Field
	 */
	function forum_field($obj, $str)
	{	
		// if submission form is in string or we are on view thread page
		if (substr_count($str, '{form_declaration:forum:submit_post}') OR $this->EE->uri->segment(2) == 'viewthread')
		{
			// get field
			$field = $this->_snaptcha_field();
			
			// extract input field name
			preg_match('/name="(.*?)"/', $field, $matches);
			$name = $matches[1];
			
			// append field
			$str .= $field;
			
			// append javascript that will move the field into the form
			$str .= '<script type="text/javascript">document.getElementById("submit_post").appendChild(document.getElementById("'.$name.'").parentNode);</script>'.NL;
		}
		
		return $str;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Forum Validation
	 */
	function forum_validate()
	{	
		if (!$this->_snaptcha_validate())
		{
			$this->EE->output->show_user_error('submission', $this->settings['error_message']);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Field
	 */
	private function _snaptcha_field($security_level='')
	{	
		$snaptcha_field = $this->settings['field_name'];
		
		// allow override of security level
		$security_level = $security_level ? $security_level : $this->settings['security_level'];
		
		
		// append random characters to field name
		$name = $snaptcha_field.'_'.$this->EE->functions->random('alpha', 5);
		
		// set value for high security level
		$value = ($security_level > 1) ? $this->EE->functions->random('alpha', 7) : '';
				
		// get field html
		$field = '<div style="position: absolute !important; top: -10000px !important; left: -10000px !important; "><input type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'" /></div>'.NL;
		
		
		// add javascript for medium and high security levels
		if ($security_level > 1)
		{
			$secret = $this->settings['unique_secret'];
			
			// create secret for high security level
			if ($security_level == 3)
			{
				$secret = $this->EE->functions->random('alpha', 7);
				
				// add secret to database
				$data = array(
					'name' => $name,
					'secret' => $secret,
					'timestamp' => time(),
					'ip_address' => $this->EE->input->ip_address()
				);
				
				$this->EE->db->insert('snaptcha', $data);
			}	
			
			$field .= '<script type="text/javascript">document.getElementById("'.$name.'").value = "'.$secret.'";</script>'.NL;
		} 
		
		
		return $field;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Validate
	 */
	private function _snaptcha_validate($security_level='')
	{
		$snaptcha_field = $this->settings['field_name'];
		
		// allow override of security level
		$security_level = $security_level ? $security_level : $this->settings['security_level'];
		
		
		// search for field in posted values
		$field = '';
		
		foreach ($_POST as $key => $value) 
		{
			if (strpos($key, $snaptcha_field.'_') === 0)
			{
				$field = $key;
			}	
		}
		
		
		// if field not found
		if (!$field)
		{
			$this->_log();
			return FALSE;
		}
		
			
		// low security level
		if ($security_level == 1)
		{
			// check if field is blank
			if ($this->EE->input->post($field) != '')
			{
				$this->_log();
				return FALSE;
			}
		}
		
		// medium security level
		else if ($security_level == 2)
		{
			// check if secret is correct
			if ($this->EE->input->post($field) != $this->settings['unique_secret'])
			{
				$this->_log();
				return FALSE;
			}
		}
		
		// high security level
		else 
		{
			// set expiry time to 1 hour
			$expiry = time() - 3600;
			
			// check if secret exists in database			
			$this->EE->db->where('name', $field);
			$this->EE->db->where('secret', $this->EE->input->post($field));
			$this->EE->db->where('timestamp > '.$expiry);
			$this->EE->db->where('ip_address', $this->EE->input->ip_address());
			$query = $this->EE->db->get('snaptcha');
			
			if (!$query OR !$query->num_rows())
			{
				$this->_log();
				return FALSE;
			}
			
			// delete and clean out old secrets from database
			$this->EE->db->where('name', $field);
			$this->EE->db->or_where('timestamp < '.$expiry);
			$this->EE->db->delete('snaptcha');
		}
		
		
		return TRUE;
	}

	// --------------------------------------------------------------------
	
	/**
	  *  Log a rejected submission
	  */
	private function _log()
	{
		// if logging is enabled
		if ($this->settings['logging'])
		{
			// create log string
			$log = date(DATE_ATOM).' Rejected form submission at '.$this->EE->functions->create_url($this->EE->session->tracker['1']).' from '.$this->EE->input->ip_address().NL;
			
			// write to log file (open in append mode)
			$fh = fopen(PATH_THIRD.'snaptcha/log.txt', 'a');	
			fwrite($fh, $log);
			fclose($fh);
		}
	}	
	
	// --------------------------------------------------------------------
	
	/**
	  *  Checks if is valid license
	  */
	private function _valid_license($string)
	{
		return preg_match("/^([a-z0-9]{8})-([a-z0-9]{4})-([a-z0-9]{4})-([a-z0-9]{4})-([a-z0-9]{12})$/", $string);
	}	
	
	// --------------------------------------------------------------------
	
	/**
	 * Settings Form
	 */
	function settings_form($settings)
	{
		$this->EE->load->helper('form');
		$this->EE->load->library('table');
	
		$this->settings = $settings;
		
		// member register security level must be less than 3
		$member_register_security_level = ($this->settings['security_level'] < 3) ? $this->settings['security_level'] : 2;
		
		$vars = array();		
		$vars['unique_secret'] = $settings['unique_secret'];			
		$vars['valid_license'] = $this->_valid_license($settings['license_number']);
		$vars['member_registration_html'] = $this->_snaptcha_field($member_register_security_level);
		$vars['log_file_not_writable'] = !is_writable(PATH_THIRD.'snaptcha/log.txt');
		
		$vars['settings'] = array
		(
			'license_number' => form_input(array(
						'name' => 'license_number', 
						'value' => $settings['license_number'],
						'style' => ($vars['valid_license'] ? '' : 'border-color: #CE0000; width: 70%;')
			)),
			'security_level' => form_dropdown(
						'security_level',
						array(3 => lang('high'), 2 => lang('medium'), 1 => lang('low')), 
						$settings['security_level']
			),
			'field_name' => form_input(
						'field_name', 
						$settings['field_name']
			),
			'member_registration_validation' => form_dropdown(
						'member_registration_validation',
						array(0 => lang('disabled'), 1 => lang('enabled')), 
						$settings['member_registration_validation']
			),
			'logging' => form_dropdown(
						'logging',
						array(0 => lang('disabled'), 1 => lang('enabled')), 
						$settings['logging']
			),
			'error_message' => form_textarea(array(
						'name' => 'error_message', 
						'value' => $settings['error_message'], 
						'rows' => '6'
			))
		);
	
		return $this->EE->load->view('settings', $vars, TRUE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Save Settings
	 */
	function save_settings()
	{
		if (empty($_POST))
		{
			show_error($this->EE->lang->line('unauthorized_access'));
		}
	
		unset($_POST['submit']);
			
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->update('extensions', array('settings' => serialize($_POST)));
	
		$this->EE->session->set_flashdata('message_success', $this->EE->lang->line('preferences_updated'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Update Extension
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		if ($current < 1.1)
		{
			// get current settings
			$this->EE->db->where('class', __CLASS__);
			$query = $this->EE->db->get('extensions');
			$settings = unserialize($query->row()->settings);
			
			// add unique_secret and member_registration_validation to settings
			$settings['unique_secret'] = $this->EE->functions->random('alpha', 7);
			$settings['member_registration_validation'] = 0;
			$this->EE->db->where('class', __CLASS__);
			$this->EE->db->update('extensions', array('settings' => serialize($settings)));
		
			// add member register hook
			$data = array(
				'class'	 	=> __CLASS__,
				'method'	=> 'member_register_validate',
				'hook'	  	=> 'member_member_register_start',
				'settings'  => serialize($this->settings),
				'priority'  => 10,
				'version'   => $this->version,
				'enabled'   => 'y'
			);	
			$this->EE->db->insert('extensions', $data);			
		}
		
		if ($current < 1.2)
		{
			// add forum hooks		
			$data = array(
				'class'	 	=> __CLASS__,
				'method'	=> 'forum_field',
				'hook'	  	=> 'forum_threads_template',
				'settings'  => serialize($this->settings),
				'priority'  => 10,
				'version'   => $this->version,
				'enabled'   => 'y'
			);	
			$this->EE->db->insert('extensions', $data);
								
			$data = array(
				'class'	 	=> __CLASS__,
				'method'	=> 'forum_validate',
				'hook'	  	=> 'forum_submit_post_start',
				'settings'  => serialize($this->settings),
				'priority'  => 10,
				'version'   => $this->version,
				'enabled'   => 'y'
			);	
			$this->EE->db->insert('extensions', $data);		
		}
		
		if (version_compare($current, '1.2.1', '<'))
		{
			// add forum hook for submission form
			$data = array(
				'class'	 	=> __CLASS__,
				'method'	=> 'forum_field',
				'hook'	  	=> 'forum_submission_form_end',
				'settings'  => serialize($this->settings),
				'priority'  => 10,
				'version'   => $this->version,
				'enabled'   => 'y'
			);	
			$this->EE->db->insert('extensions', $data);				
		}
		
		if (version_compare($current, '1.3', '<'))
		{
			// get current settings
			$this->EE->db->where('class', __CLASS__);
			$query = $this->EE->db->get('extensions');
			$settings = unserialize($query->row()->settings);
			
			// add logging to settings
			$settings['logging'] = 0;
			$this->EE->db->where('class', __CLASS__);
			$this->EE->db->update('extensions', array('settings' => serialize($settings)));
		}
	
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->update(
					'extensions',
					array('version' => $this->version)
		);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 */
	 function activate_extension()
	{
		$this->EE->lang->loadfile('snaptcha');
		
		
		// default settings
		$this->settings = array(
			'license_number' => '',
			'unique_secret' => $this->EE->functions->random('alpha', 7),
			'security_level' => 3,
			'field_name' => 'snap',
			'error_message' => lang('default_error_message'),
			'member_registration_validation' => 0,
			'logging' => 0
		);
		
		
		// comment form	hooks			
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'comment_field',
			'hook'	  	=> 'comment_form_tagdata',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
		
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'comment_validate',
			'hook'	  	=> 'insert_comment_start',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
		
		
		// safecracker hooks			
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'safecracker_field',
			'hook'	  	=> 'safecracker_entry_form_tagdata_end',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
		
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'safecracker_validate',
			'hook'	  	=> 'safecracker_submit_entry_end',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
		
		
		// freeform hooks
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'freeform_field',
			'hook'	  	=> 'freeform_module_form_end',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);
	
		$this->EE->db->insert('extensions', $data);
		
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'freeform_validate',
			'hook'	  	=> 'freeform_module_validate_end',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);
	
		$this->EE->db->insert('extensions', $data);
		
		
		// member register hooks			
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'member_register_validate',
			'hook'	  	=> 'member_member_register_start',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
		
		
		// forum hooks			
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'forum_field',
			'hook'	  	=> 'forum_threads_template',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
				
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'forum_field',
			'hook'	  	=> 'forum_submission_form_end',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);	
		
		$data = array(
			'class'	 	=> __CLASS__,
			'method'	=> 'forum_validate',
			'hook'	  	=> 'forum_submit_post_start',
			'settings'  => serialize($this->settings),
			'priority'  => 10,
			'version'   => $this->version,
			'enabled'   => 'y'
		);	
		$this->EE->db->insert('extensions', $data);
		

		// create snaptcha table
		$this->EE->load->dbforge();
		
		$fields = array(
						'id' 			=> array(
											'type'			=> 'int',
											'constraint'	=> 11,
											'unsigned'		=> TRUE,
											'null'			=> FALSE,
											'auto_increment'=> TRUE
										),
						'name'			=> array(
											'type' 			=> 'varchar',
											'constraint'	=> '100',
											'null'			=> FALSE,
											'default'		=> ''
										),
						'secret'  		=> array(
											'type' 			=> 'varchar',
											'constraint'	=> '100',
											'null'			=> FALSE,
											'default'		=> ''
										),
						'timestamp'  	=> array(
											'type' 			=> 'varchar',
											'constraint'	=> '16',
											'null'			=> FALSE,
											'default'		=> ''
										),
						'ip_address' 			 => array(
											'type' 			=> 'varchar',
											'constraint'	=> '16',
											'null'			=> FALSE,
											'default'		=> ''
										)
		);
		
		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('id', TRUE);
		$this->EE->dbforge->create_table('snaptcha', TRUE);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Disable Extension
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
		
		// delete snaptcha table
		$this->EE->load->dbforge();
		$this->EE->dbforge->drop_table('snaptcha');
	}
		
}
// END CLASS

/* End of file ext.snaptcha.php */
/* Location: ./system/expressionengine/third_party/snaptcha/ext.snaptcha.php */