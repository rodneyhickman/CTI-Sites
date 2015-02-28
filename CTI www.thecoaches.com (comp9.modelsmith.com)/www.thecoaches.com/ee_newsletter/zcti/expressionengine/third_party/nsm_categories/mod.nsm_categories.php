<?php if (! defined('BASEPATH')) die('No direct script access allowed');

require PATH_THIRD.'nsm_categories/config.php';

/**
 * NSM Categories Module
 *
 * @package			NsmCategories
 * @version			1.0.0
 * @author			Leevi Graham <http://leevigraham.com>
 * @copyright 		Copyright (c) 2007-2012 Newism <http://newism.com.au>
 * @license 		Commercial - please see LICENSE file included with this distribution
 * @link			http://expressionengine-addons.com/nsm-categories
 * @see				http://expressionengine.com/public_beta/docs/development/modules.html#control_panel_file
 */

class Nsm_categories {

	/**
	 * The entry count for the tag
	 */
	protected $_entryCount = 0;

	/*
	 * The entry count for a group in the tag. Nested categories have the group reset
	 */
	protected $_categoryEntryCount = 0;

	/**
	 * The group count for the tag
	 */
	protected $_categoryCount = 0;
	
	/**
	 * The relative count for the tag within a branch
	 */
	protected $_categoryBranchCount = 0;
	
	protected $addon_id = NSM_CATEGORIES_ADDON_ID;

	/**
	 * PHP5 constructor function.
	 *
	 * @access public
	 * @return void
	 **/
	function __construct()
	{
		// set the addon id
		$this->addon_id = NSM_CATEGORIES_ADDON_ID;
	
		// Create a singleton reference
		$EE =& get_instance();

		// define a constant for the current site_id rather than calling $PREFS->ini() all the time
		if (defined('SITE_ID') == FALSE) {
			define('SITE_ID', $EE->config->item('site_id'));
		}

		// Init the cache
		// If the cache doesn't exist create it
		if (! isset($EE->session->cache[$this->addon_id])) {
			$EE->session->cache[$this->addon_id] = array();
		}

		// Assig the cache to a local class variable
		$this->cache =& $EE->session->cache[$this->addon_id];
	}


	/**
	 * Outputs category archives in linear or nested fashion with or without entries.
	 * Entries are not loaded by default for performance
	 *
	 * @access public
	 * @return string
	 **/
	public function archive()
	{
		$EE =& get_instance();
		$EE->load->model('category_model');
		$EE->category_model->get_categories()->result();

		$tag_params = array(
			'channel' => $EE->TMPL->fetch_param('channel'),
			'enable' => $EE->TMPL->fetch_param('enable', 'entries|category_fields'),
			'category_group' => $EE->TMPL->fetch_param('category_group'),
			'category' => $EE->TMPL->fetch_param('category'),
			'show_empty'=> $EE->TMPL->fetch_param('show_empty', 'yes'),
			'parent_only'=> $EE->TMPL->fetch_param('parent_only', 'no'),
			'style' => $EE->TMPL->fetch_param('style', 'linear'),
			'depth' => $EE->TMPL->fetch_param('depth'),
			'target_category' => $EE->TMPL->fetch_param('target_category'),
			'category_sort' => $EE->TMPL->fetch_param('category_sort', false),
			'category_channel_entry_limit' => $EE->TMPL->fetch_param('category_channel_entry_limit', 200),
			'site_id' => $EE->TMPL->fetch_param('site_id', SITE_ID)
		);

		$EE->TMPL->tagparams['dynamic'] = $EE->TMPL->fetch_param('dynamic', "no");
		$EE->TMPL->tagparams['limit'] = $EE->TMPL->fetch_param('limit', 200);

		if (is_string($tag_params['enable'])) {
			$tag_params['enable'] = explode("|", $tag_params['enable']);
		}

		if (is_string($tag_params['category'])) {
			$tag_params['category'] = explode("|", $tag_params['category']);
		}

		if (is_string($tag_params['site_id'])) {
			$tag_params['site_id'] = explode("|", $tag_params['site_id']);
		}

		// Filter by channel
		// Get the channels category groups and update the 
		$channel_category_groups = false;
		if ($tag_params['channel']) {
			$EE->db->select('channels.cat_group');
			$EE->db->distinct();
			$EE->db->from('channels');
			$EE->db->where_in('channels.channel_name', explode("|", $tag_params['channel']));
			$channel_categories_result = $EE->db->get()->result_array();
			foreach ($channel_categories_result as $channel) {
				if (empty($channel['cat_group'])) {
					continue;
				}
				$channel_category_groups.= "|" . $channel['cat_group'];
			}
			$channel_category_groups = array_unique(explode("|", substr($channel_category_groups, 1)));
			unset($channel_categories_result);
		}

		// filter by category group or set the category_group param to the channel category groups ifset
		if ($tag_params['category_group']) {
			// make them an array
			$tag_params['category_group'] = explode("|", $tag_params['category_group']);
			// if channel category groups are defined
			// find the matching ones
			if (!empty($channel_category_groups)) {
				$tag_params['category_group'] = array_intersect($tag_params['category_group'], $channel_category_groups);
			}
		// set the category group to the channel group
		} else {
			$tag_params['category_group'] = $channel_category_groups;
		}
		unset($channel_category_groups);

		$category_fields = array();
		if (in_array('category_fields', $tag_params['enable'])) {
			$get_category_fields = $EE->db->select('`field_id`, `group_id`, `field_name`')
									->where_in('site_id', $tag_params['site_id'])
									->get('category_fields');
			$category_fields = $get_category_fields->result_array();
			
			$EE->db->select('DISTINCT (exp_categories.cat_id)', false);
			
		
			$search_fields = array_keys($EE->TMPL->search_fields);
			for ($i=0, $m=count($category_fields); $i<$m; $i+=1) {
				$EE->db->select("category_field_data.`field_id_{$category_fields[$i]['field_id']}` AS `{$category_fields[$i]['field_name']}`", false);
				if (in_array($category_fields[$i]['field_name'], $search_fields)) {
					$search_column_name = 'field_id_'.$category_fields[$i]['field_id'];
					$search_column_value = $EE->TMPL->search_fields[ $category_fields[$i]['field_name'] ];
					if (strpos($search_column_value, '%') === false) {
						$EE->db->where($search_column_name, $search_column_value);
					} else {
						$search_column_like = (strpos($search_column_value, '%') > 0 ? 'after' : 'before');
						$search_column_value = str_replace('%', '', $search_column_value);
						$EE->db->like($search_column_name, $search_column_value, $search_column_like);
					}
					unset($EE->TMPL->search_fields[ $category_fields[$i]['field_name'] ]);
				}
			}
			$EE->db->join('category_field_data', 'category_field_data.cat_id = categories.cat_id', 'left');
			unset($get_category_fields, $category_fields, $search_fields);
			unset($search_column_name, $search_column_value, $search_column_like);
		}
		// Get the categories
		$EE->db->select('
			categories.`cat_id` as `category_id`, 
			categories.`group_id` as `category_group_id`, 
			categories.`parent_id` as `category_parent_id`, 
			categories.`cat_name` as `category_name`, 
			categories.`cat_url_title` as `category_url_title`, 
			categories.`cat_description` as `category_description`, 
			categories.`cat_image` as `category_image`,
			categories.`cat_order` as `category_order`
		', false);

		$EE->db->from('categories');
		$EE->db->where_in('categories.site_id', $tag_params['site_id']);

		// Parents only please
		if ($tag_params['parent_only'] == 'yes') {
			$EE->db->where('categories.parent_id', '0');
		}

		// Filter by category
		if ($tag_params['category']) {
			$EE->db->where_in('categories.cat_id ', $tag_params['category']);
		}

		// Filter by category group
		if ($tag_params['category_group']) {
			$EE->db->where_in('categories.group_id', $tag_params['category_group']);
		}

		// order by group id then parent id then sort id. This returns the categories in the right order
		$EE->db->order_by('categories.group_id, categories.parent_id, categories.cat_order');

		// set the default data for the categories
		$categories = array();
		$required_category_ids = array();
		$category_query = $EE->db->get()->result_array();
		foreach ($category_query as $category) {
			$categories[$category['category_id']] = $category;
			$categories[$category['category_id']]['category_channel_entries'] = '';
			$categories[$category['category_id']]['category_channel_entries_total_results'] = 0;
			$required_category_ids[] = $category['category_id'];
		}
		unset($category_query);

		// grab the tagdata
		$tagdata = $EE->TMPL->tagdata;

		// This is where we'll store the channel entries tagdata
		$channel_entries_tagdata = false;

		// This is where things get cool
		// Is there a channel entries tag? This is a quick check before performing the preg_replace
		if (strpos($tagdata, LD."/category_channel_entries".RD) !== false) {
			// Get the channel_entries tagdata
			if (preg_match("#".LD."category_channel_entries".RD."(.*?)".LD."/category_channel_entries".RD."#s", $tagdata, $matches)) {

				// store the tagdata
				// replace count with a placeholder count variable
				// we do this so we can replace it later
				// should make it easier for the user
				// they only need to remember one tag
				// also prepend and append an [entry_*] delimiter which we'll use later to identify individual entries
				$channel_entries_tagdata = '[entry_start]'.str_replace(LD."count".RD, LD."_count".RD, $matches[1]).'[entry_end]';

				// remove the tagpair and replace with a single tag
				$tagdata = str_replace($matches[0], "{category_channel_entries}", $tagdata);
				$EE->TMPL->var_single['category_channel_entries'] = 'category_channel_entries';
				unset($EE->TMPL->var_pair['category_channel_entries']);
			}
		}

		// Store the channel entries total results.
		// This is the total count of entries in all categories
		$channel_entries_total_results = 0;

		// Create an array to store our entries
		$entry_matches = array();

		if (in_array("entries", $tag_params['enable'])) {

			// Create a snippet of tagdata just for the channel:entries parsing
			// tell the TMPL object that we've added a new tag pair
			// tell the TMPL object there is an {entry_id} tag
			// force entries from the categories we want
			$EE->TMPL->var_pair['categories'] = true;
			$EE->TMPL->var_single['entry_id'] = 'entry_id';
			$EE->TMPL->tagparams['category'] = implode("|", $required_category_ids);

			// No tagdata? In this case we only need to get the category and entry count
			// Disable the shiz we don't need for performance
			if ($channel_entries_tagdata == false) {
				$EE->TMPL->tagparams['disable'] = $EE->TMPL->fetch_param('disable', "custom_fields|category_fields|member_data|pagination");
			}

			// Create a custom tagdata string for the channel module to parse
			$EE->TMPL->tagdata = "START:{entry_id}|".
									"CATEGORIES:{categories}{category_id}|{/categories}|".
									"TAGDATA:".$channel_entries_tagdata."|".
									"END\n";

			// if no weblog class exists
			if (class_exists('Channel') === FALSE) {
				require PATH_MOD.'channel/mod.channel'.EXT;
			}

			// create a new weblog object and parse the tagdata saving the output
			$channelInstance = new Channel;
			$channelOutput = $channelInstance->entries();

			// pregmatch the output capturing the rendered tagdata, entry id and entry categories
			preg_match_all('#'.
								'START:(\d+)\|'.
								'CATEGORIES:(.*?)\|+'.
								'TAGDATA:(.*?)\|'.
								'END'.
							'#s', $channelOutput, $entry_matches, PREG_SET_ORDER);

			unset($channelInstance, $channelOutput);
			
			$new_tagdata = '';
			// process the parsed data
			foreach ($entry_matches as $count => $match) {
				// get the entries categories
				foreach ($entry_cats = explode("|", $match[2]) as $cat_id) {

					// this category isn't in the required categories
					// or the category has reached it's entry limit
					if (
						in_array($cat_id, $required_category_ids) == false
						|| ($categories[$cat_id]['category_channel_entries_total_results'] >= $tag_params['category_channel_entry_limit'])
					) {
						continue;
					}
					$categories[$cat_id]['category_channel_entries_total_results']++;
					$categories[$cat_id]['category_children_tagdata'] = false;
					// process custom category fields here
					$new_tagdata = $EE->TMPL->parse_variables_row($match[3], $categories[$cat_id]);
					$categories[$cat_id]['category_channel_entries'] .= $new_tagdata;
					$channel_entries_total_results++;
				}
			}

			unset($entry_matches, $new_tagdata);

			// Now we have category entry totals remove empty categories if required and if including entries
			if ($tag_params['show_empty'] == "no") {
				$tmp = array_keys($categories);
				foreach ($tmp as $key) {
					if ($categories[$key]['category_channel_entries_total_results'] == 0) {
						unset($categories[$key]);
					}
				}
				unset($tmp);
			}
		}
		// No categories?
		if (count($categories) == 0) {
			return $EE->TMPL->no_results();
		}

        if ($tag_params['category_sort']) {
            $this->deep_ksort($categories, $tag_params['category_sort']);
        }

		// Loop over the categories preparing as much tag data as possible
		$category_count = 0;
		$category_total_results = count($categories);

		// Build the nested categories array
		// even tho categories might be rendered as a liner list. This ensures linear categories are in the right order
		$cat0 = reset($categories);

		$nested_categories = $this->_build_array_from_nodes($categories, array(
			'parent' => $cat0['category_parent_id'],
			'depth' => $tag_params['depth'],
			'target' => $tag_params['target_category']
		));

		$output = ($tag_params['style'] == 'nested')
						// Nested category tree
						? $this->_renderNestedTree($nested_categories['nodes'], $tagdata)
						// Linear category tree
						: $this->_renderLinearTree($nested_categories['nodes'], $tagdata);

		unset($nested_categories);
		
		$output = $EE->TMPL->parse_variables_row($output, array(
						'category_total_results' => $category_total_results,
						'category_absolute_total_results' => $category_total_results,
						'channel_entries_total_results' => $channel_entries_total_results
					));
		
		return $output;
	}

    private function deep_ksort(&$arr, $sort = 'asc')
	{ 
        ($sort = 'desc')
            ? ksort($arr)
            : krsort($arr);

        foreach ($arr as &$a) { 
            if (is_array($a) && !empty($a)) { 
                $this->deep_ksort($a); 
            } 
        } 
    }

	/**
	 * Renders a linear category tree
	 *
	 * If the category has children they are rendered immediately after the parent
	 *
	 * @access private
	 * @param array $categories nested array
	 * @param string $tagdata
	 * @return string The rendered tagdata
	 **/
	private function _renderLinearTree($categories, $tagdata)
	{
		// create a tmp array to fill with data
		$EE =& get_instance();
		$output = false;

		if (!$categories) {
			return $output;
		}

		foreach ($categories as $category) {

			// reset the category entry count
			$this->_categoryEntryCount = 0;

			$category['category_channel_entries'] = preg_replace_callback(array(
				"/\[entry_start\](.*?)\[entry_end\]/ims",
			), array($this, '_parseEntryTags'), $category['category_channel_entries']);

			$category['category_count'] = ++$this->_categoryCount;

			$output .= $EE->TMPL->parse_variables_row($tagdata, $category);
			// going down
			if ($category['category_is_parent'] == true) {
				$output .= $this->_renderLinearTree($category['category_children'], $tagdata);
			}
			unset($category['category_children']);
		}
		return $output;
	}

	/**
	 * Renders nested tagdata
	 *
	 * @access private
	 * @param array $categories nested array
	 * @param string $tagdata
	 * @return string The rendered tagdata
	 **/
	private function _renderNestedTree($categories, $tagdata)
	{
		$EE =& get_instance();
		$output = false;

		if (!$categories) {
			return $output;
		}
		
		$categoryBranchCount = 0;
		$categoryBranchTotalResults = count($categories);
		foreach ($categories as $category) {

			$this->_categoryEntryCount = 0;
			$category['category_count'] = ++$this->_categoryCount;
			$category['category_branch_count'] = ++$categoryBranchCount;
			$category['category_branch_total_results'] = $categoryBranchTotalResults;
			$category['category_channel_entries'] = preg_replace_callback(array(
				"/\[entry_start\](.*?)\[entry_end\]/ims",
			), array($this, '_parseEntryTags'), $category['category_channel_entries']);

			if ($category['category_is_parent'] == true) {
				$category['category_children_tagdata'] = $this->_renderNestedTree($category['category_children'], $tagdata);
			}

			unset($category['category_children']);
			$output .= $EE->TMPL->parse_variables_row($tagdata, $category);
		}
		return $output;
	}

	private function _parseEntryTags($matches)
	{

		return str_replace(
			array(
				LD."category_channel_entry_count".RD,
				LD."_count".RD
			),
			array(
				++$this->_categoryEntryCount,
				++$this->_entryCount
			),
			$matches[1]
		);
	}

	/**
	 * Take a flat array and nest it
	 *
	 * @param array $nodes nested array
	 * @param array $opts
	 * @param int $level The current rendering level
	 * @return array Nested node tree
	 **/
	private function _build_array_from_nodes($nodes, $opts = array(), $level = 1)
	{

		$return = false;
		$children = false;
		$target_found = false;
		

		// "parent"
		// "depth"
		// "target"
		// "target_found"
		extract($opts);

		if ($depth != false AND $level > $depth) {
			return $return;
		}
		$return = array();
		foreach ($nodes as $node) {
			if ($node['category_parent_id'] == $parent) {
				$node_id = $node['category_id'];
				$return[$node_id] = $node;
				$return[$node_id]['category_depth'] = $level;
				$return[$node_id]['category_parent_id'] = $parent;
				$return[$node_id]['category_is_target_parent'] = false;

				# If this node is the one we're looking for
				if ($node_id == $target) {
					$return[$node_id]['category_is_target'] = $target_found = true;
				} else {
					$return[$node_id]['category_is_target'] = false;
				}

				$options = array(
					"parent" 			=> $node_id,  
					"depth" 			=> $depth, 
					"target"  			=> $target, 
					"target_found" 		=> $target_found
				);

				$children = $this->_build_array_from_nodes($nodes, $options, $level + 1);
				
				if (!empty($children['nodes'])) {	
					if ($children['category_target_found'] === true) {
						$return[$node_id]['category_is_target_parent'] = $target_found = true;
					}
					$return[$node_id]['category_is_parent'] = true;
					$return[$node_id]['category_children_total_results'] = count($children['nodes']);
					$return[$node_id]['category_children'] = $children['nodes'];
				} else {
					$return[$node_id]['category_is_parent'] = false;
					$return[$node_id]['category_children_total_results'] = 0;
					$return[$node_id]['category_children'] = array();
				}
			}
		}

		return array(
			'category_target_found' => $target_found,
			'nodes' => $return
		);
	}

}