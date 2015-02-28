<?php if (!defined('BASEPATH')) die('No direct script access allowed');

/**
 * Channel Forms MULTISELECT field
 *
 * @package			DevDemon_Forms
 * @author			DevDemon <http://www.devdemon.com> - Lead Developer @ Parscale Media
 * @copyright 		Copyright (c) 2007-2011 Parscale Media <http://www.parscale.com>
 * @license 		http://www.devdemon.com/license/
 * @link			http://www.devdemon.com/forms/
 * @see				http://expressionengine.com/user_guide/development/fieldtypes.html
 */
class CF_Field_multiselect extends CF_Field
{

	/**
	 * Field info - Required
	 *
	 * @access public
	 * @var array
	 */
	public $info = array(
		'title'		=>	'Multi Select',
		'name' 		=>	'multiselect',
		'category'	=>	'form_tools',
		'version'	=>	'1.0',
	);

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * Calls the parent constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// ********************************************************************************* //

	public function render_field($field=array(), $template=TRUE, $data)
	{
		$out  = '';

		// -----------------------------------------
		// Default values
		// -----------------------------------------
		if (isset($field['settings']['choices']) == FALSE OR is_array($field['settings']['choices']) == FALSE)
		{
			$field['settings']['choices'][]  = array('label' => 'First', 'value' => 'First');
			$field['settings']['choices'][]  = array('label' => 'Second', 'value' => 'Second');
			$field['settings']['choices'][]  = array('label' => 'Third', 'value' => 'Third');
			$field['settings']['values_enabled'] = 'no';
			$field['settings']['enhanced_ui'] = 'no';
		}

		// Use Values?
		$use_values = ($field['settings']['values_enabled'] == 'yes') ? TRUE : FALSE;

		// Default Choice (always INT)
		if (isset($field['settings']['default_choice']) == FALSE) $field['settings']['default_choice'] = '';
		else $field['settings']['default_choice'] = (int) $field['settings']['default_choice'];

		// -----------------------------------------
		// Do we have any previous submits!
		// -----------------------------------------
		$check_submit = FALSE;
		if (is_array($data) == TRUE && empty($data) == FALSE)
		{
			$check_submit = TRUE;
		}

		// -----------------------------------------
		// Loop over all items!
		// -----------------------------------------
		$items = array();
		foreach ($field['settings']['choices'] as $number => $choice)
		{
			// What Value are we going to use?
			$value = ($use_values ? $choice['value'] : $choice['label']);
			$items[$value] = $choice['label'];

			if ($check_submit == FALSE && $field['settings']['default_choice'] === $number) $data = array($value);
		}

		// Select CLass
		$class = '';
		if (isset($field['settings']['enhanced_ui']) == TRUE && $field['settings']['enhanced_ui'] == 'yes')
		{
			$class .= ' chzn-select ';
		}

		// -----------------------------------------
		// Render
		// -----------------------------------------
		$out =	form_multiselect($field['form_name'].'[]', $items, $data, ' class="'.$class.'" ');

		// -----------------------------------------
		// Add Chosen!
		// -----------------------------------------
		if (isset($field['settings']['enhanced_ui']) == TRUE && $field['settings']['enhanced_ui'] == 'yes')
		{
			if ( isset($this->EE->session->cache['DevDemon']['JS']['jquery.chosen']) == FALSE )
			{
				$url = $this->EE->forms_helper->define_theme_url();

				$out .= '<script src="' . $url . 'chosen/jquery.chosen.js" type="text/javascript"></script>';
				$out .= '<link rel="stylesheet" href="' . FORMS_THEME_URL . 'chosen/chosen.css" type="text/css" media="print, projection, screen" />';

			}

			if ($template == FALSE) $out .= '<script type="text/javascript">jQuery("select.chzn-select").css({width:"80%"}).chosen();</script>';
			else $out .= '<script type="text/javascript">jQuery("select.chzn-select").chosen();</script>';
		}

		return $out;
	}

	// ********************************************************************************* //

	public function save($field=array(), $data)
	{
		return serialize($data);
	}

	// ********************************************************************************* //

	public function output_data($field=array(), $data, $type='template')
	{
		$data = unserialize($data);

		if ($data == FALSE OR is_array($data) == FALSE) return '';

		return implode(', ', $data);
	}

	// ********************************************************************************* //

	public function field_settings($settings=array(), $template=TRUE)
	{
		$vData = $settings;

		if (isset($vData['choices']) == FALSE OR is_array($vData['choices']) == FALSE)
		{
			$vData['choices'][]  = array('label' => 'First', 'value' => 'First');
			$vData['choices'][]  = array('label' => 'Second', 'value' => 'Second');
			$vData['choices'][]  = array('label' => 'Third', 'value' => 'Third');
		}

		// Default Choice (always INT)
		if (isset($vData['default_choice']) == FALSE) $vData['default_choice'] = '';
		else $vData['default_choice'] = (int) $vData['default_choice'];

		// Default Choice
		if (isset($vData['enhanced_ui']) == FALSE) $vData['enhanced_ui'] = 'yes';

		return $this->EE->load->view('settings', $vData, TRUE);
	}

	// ********************************************************************************* //

	public function save_settings($settings=array())
	{
		foreach($settings['choices'] as $number => &$choice)
		{
			$choice['label'] = trim($choice['label']);
			$choice['value'] = trim($choice['value']);

			if ($choice['label'] == FALSE) unset ($settings['choices'][$number]);
			if ($choice['value'] == FALSE) $choice['value'] = $choice['label'];
		}

		return $settings;
	}

	// ********************************************************************************* //

}

/* End of file multiselect.php */
/* Location: ./system/expressionengine/third_party/forms/fields/multiselect/multiselect.php */