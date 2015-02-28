<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * NSM Transplant
 * 
 * Move content around in templates.
 *
 * @package			NsmTransplant
 * @version			1.0.0
 * @author			Leevi Graham <http://leevigraham.com> - Technical Director, Newism
 * @copyright 		Copyright (c) 2007-2010 Newism <http://newism.com.au>
 * @license 		Commercial - please see LICENSE file included with this distribution
 * @link			http://ee-garage.com/nsm-transplant
 * @see 			http://expressionengine.com/public_beta/docs/development/plugins.html
 */

/**
 * Plugin Info
 *
 * @var array
 */
$plugin_info = array(
	'pi_name' => 'NSM Transplant',
	'pi_version' => '1.0.0',
	'pi_author' => 'Leevi Graham &mdash; Technical Director, <a href="http://newism.com.au/">Newism</a>',
	'pi_author_url' => 'http://leevigraham.com',
	'pi_description' => 'Cache and transplant tag output for multiple use elsewhere in your templates.',
	'pi_usage' => 'http://ee-garage.com/nsm-transplant'
);

class Nsm_transplant{

	/**
	 * Constructor
	 */
	function Nsm_transplant()
	{
		$this->EE =& get_instance();
		if(!isset($this->EE->session->cache[__CLASS__]))
			$this->EE->session->cache[__CLASS__] = array();
		
		$this->cache =& $this->EE->session->cache[__CLASS__];
	}

	/**
	 * Replace tags inside the body
	 * 
	 * The content of this tag will be parsed for tags. If any tags are found inside the body they will be replaced with the cached tag content.
	 * 
	 * @access public
	 * @return string The HTML with tags replaced
	 */
	function body()
	{
		$this->EE->TMPL->log_item("Begin body processing");
		$this->EE->TMPL->log_item("Replacing tags: " . implode(", ", array_keys($this->cache)));

		// get teh tag data
		$tagdata = $this->EE->TMPL->tagdata;

		// Parse the variables
		$ret = $this->EE->TMPL->parse_variables_row($tagdata, $this->cache);
		$this->EE->TMPL->log_item("End body processing");

		return $ret;
	}

	/**
	 * The tag content
	 * 
	 * Tag content wrapped in `{exp:nsm_transplant:content}` becomes the replacement for the corresponding tag. The tag name is defined by the id parameter.
	 * For example if the `id=` parameter is set to 'entry_links' then the plugin will replace `{entry_links}` with the `{exp:nsm_transplant:content}` tag content.
	 * This tag must be nested inside a `{exp:nsm_transplant:body}` tag.
	 * 
	 * This method stores the tag content in the cache
	 * 
	 * @access public
	 * @return void
	 */
	function content()
	{
		$this->EE->TMPL->log_item("Begin tag content processing");
		if($id = $this->EE->TMPL->fetch_param('id'))
		{
			extract($this->_getTagContentOrParam("value", array("return_all_tagdata" => true)));
			$this->EE->TMPL->log_item("Tag found: {$id} = {$value}");
			$this->cache[trim($id)] = $value;
		}
		else
		{
			$this->EE->TMPL->log_item("No tag id found");
		}
		$this->EE->TMPL->log_item("End tag content processing");
	}

	/**
	 * Explicitly render the output of a tag
	 * 
	 * Use this tag in _embedded templates_ to render tag content. This tag also requires a `id=` parameter which must match the `{exp:nsm_transplant:content}` `id=` parameter.
	 * Using our initial idea of embedded links as a base the code below renders the tag inside an embedded template.
	 * 
	 * @access public
	 * @return string The tag content
	 */
	function output()
	{
		$content = $this->EE->TMPL->no_results();

		$this->EE->TMPL->log_item("Begin embedded tag content processing");

		if(! $id = $this->EE->TMPL->fetch_param("id")){
			$this->EE->TMPL->log_item("No tag id found");
			$this->EE->TMPL->log_item("End embedded tag content processing");
			return $content;
		}

		if(isset($this->cache[trim($id)]))
		{
			$this->EE->TMPL->log_item("Needle content found for: {$id}");
			$content = $this->cache[trim($id)];
		}
		else
		{
			$this->EE->TMPL->log_item("No tag content found. Needle id: {$id}");
		}

		$this->EE->TMPL->log_item("End embedded tag content processing");
		return $content;
	}

	/**
	 * Get the tag pair content of the tag parameter based on the $param value.
	 * 
	 * @access private
	 * @param $id string The id we are searching for. This could be a tag parameter or a tag
	 * @param $tagdata string The tagdata if it exists
	 * @param $delete_tag boolean Are we deleteing the tag once the content is retrieved
	 * @return The data from the param or tag
	 */
	private function _getTagContentOrParam($id, array $options = array())
	{
		extract(array_merge(array(
			"delete_tag" => true,
			"tagdata" => false,
			"return_all_tagdata" => false
		), $options));

		// Is there a param? This takes precedence
		$value = $this->EE->TMPL->fetch_param($id);

		// If there's no tagdata get the tagdata
		if(!$value)
		{
			// Load the tag data
			if(!$tagdata)
				$tagdata = $this->EE->TMPL->tagdata;

			// Search for a tag pair
			$value = $this->EE->TMPL->fetch_data_between_var_pairs($tagdata, $id);

			// No tag pair?
			// Use the full tagdata
			if(!$value && $return_all_tagdata)
				$value = $tagdata;
		}

		if($delete_tag)
			$tagdata = $this->EE->TMPL->delete_var_pairs($id, $id, $tagdata);

		return array("value" => $value, "tagdata" => $tagdata);
	}
}