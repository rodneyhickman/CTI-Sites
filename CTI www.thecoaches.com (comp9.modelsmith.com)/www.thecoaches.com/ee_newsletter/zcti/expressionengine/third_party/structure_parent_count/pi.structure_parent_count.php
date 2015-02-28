<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Structure Parent Count Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Encaffeinated, Inc.
 * @link		http://encaffeinated.com
 */

$plugin_info = array(
	'pi_name'		=> 'Structure Parent Count',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Encaffeinated, Inc.',
	'pi_author_url'	=> 'http://encaffeinated.com',
	'pi_description'=> 'Return the number of Structure parent pages for the sitemap',
	'pi_usage'		=> Structure_parent_count::usage()
);


class Structure_parent_count {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();

		$home = ( $this->EE->TMPL->fetch_param('include_home') ) ? $this->EE->TMPL->fetch_param('include_home') : 'yes';
		$site = ( $this->EE->TMPL->fetch_param('site') ) ? $this->EE->TMPL->fetch_param('site') : '1';

		//module version
		$query = $this->EE->db->query("SELECT module_version from exp_modules where module_name = 'Structure'");
		
		    if ($query->num_rows() > 0) {
		    	
				foreach($query->result_array() as $row) {
		    		
					$ver = $row['module_version'];
					if ($ver < '3.1') {
						$hidden = '';
					} else {
						$hidden = " and hidden = 'n'";
					}
		
					$query = $this->EE->db->query("SELECT count(entry_id) as count from exp_structure where parent_id = '0' and site_id = '{$site}'".$hidden);
		
				    if ($query->num_rows() > 0) {
				    	
						foreach($query->result_array() as $row) {
				    		
							$count = $row['count'];
							if($home == 'no') {
								$count--;
							}
				
						}
					
					}

				}
			
			}

		$this->return_data = $count;

	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

 Since you did not provide instructions on the form, make sure to put plugin documentation here.
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.structure_parent_count.php */
/* Location: /system/expressionengine/third_party/structure_parent_count/pi.structure_parent_count.php */