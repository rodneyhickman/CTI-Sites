<?php 

if (!defined('BASEPATH')) exit('Invalid file request');
require_once PATH_THIRD.'zoo_triggers/config.php';
require_once PATH_THIRD.'zoo_triggers/helper.php';

/**
 * Zoo Triggers Class
 *
 * @package   Zoo Triggers
 * @author    ExpressionEngine Zoo <info@eezoo.com>
 * @copyright Copyright (c) 2011 ExpressionEngine Zoo (http://eezoo.com)
 */
class Zoo_triggers 
{
	var $return_data;

	/**
	 * Module Constructor
	 */
	function Zoo_triggers()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
		
		$this->helper = new Zoo_triggers_helper();
		
		return false;
	}
	
	function archive()
	{
		// Get tag attributes and vars
		$this->archive->results = null;
		$this->archive->results_nested = array();
		$this->archive->output = null;
		$this->archive->attrChannel = ($this->EE->TMPL->fetch_param('channel')) ? explode('|', $this->EE->TMPL->fetch_param('channel')) : $this->EE->TMPL->fetch_param('channel');
		$this->archive->attrCssId = $this->EE->TMPL->fetch_param('css_id', "list-archive");
		$this->archive->attrCssYears = $this->EE->TMPL->fetch_param('css_years', "item-year");
		$this->archive->attrCssMonths = $this->EE->TMPL->fetch_param('css_months', "item-month");
		$this->archive->attrCssActive = $this->EE->TMPL->fetch_param('css_active', "active");
		$this->archive->attrMonth = $this->EE->TMPL->fetch_param('month', "long"); // Options: long, short
		$this->archive->attrPath = $this->EE->TMPL->fetch_param('path', $this->EE->uri->uri_string . '/archive');
		$this->archive->attrShowCounter = $this->EE->TMPL->fetch_param('show_counter', "yes"); // Options: yes, no
		$this->archive->attrShowLink = $this->EE->TMPL->fetch_param('show_link', "yes"); // Options: yes, no
		$this->archive->attrStatus = explode('|', $this->EE->TMPL->fetch_param('status', 'open'));
		$this->archive->attrStyle = $this->EE->TMPL->fetch_param('style', 'nested'); // Options: list, nested
		$this->archive->attrYear = $this->EE->TMPL->fetch_param('year', "long"); // Options: long, short
		$this->archive->attrShowFutureEntries = $this->EE->TMPL->fetch_param('show_future_entries', "yes"); // Options: yes, no
		$this->archive->attrType = $this->EE->TMPL->fetch_param('type', "monthly"); // Options: monthly, yearly
		
		// Build Query
		$this->EE->db->select('ct.year, ct.month, COUNT(title) as count')
					 ->from('exp_channel_titles ct');
					
			// Filter channels
			if($this->archive->attrChannel)
			{
				$this->EE->db->join('exp_channels ch', 'ch.channel_id = ct.channel_id', 'left')
							 ->where_in('ch.channel_name', $this->archive->attrChannel);
			}
			
			if($this->archive->attrShowFutureEntries != "yes")
			{
				$timestamp = ($this->EE->TMPL->cache_timestamp != '') ? $this->EE->localize->set_gmt($this->EE->TMPL->cache_timestamp) : $this->EE->localize->now;
				$this->EE->db->where('ct.entry_date <', $timestamp);
			}
			
			// Filter status
			$this->EE->db->where_in('ct.status', $this->archive->attrStatus);
			
			//group-> monthly - yearly
			
			if($this->archive->attrType == "yearly")
			{
				$this->EE->db->group_by('year')->order_by('year desc');
			}
			else
			{
				$this->EE->db->group_by('month, year')->order_by('year desc, month desc');
			}
			// Execute Query
			$this->archive->results = $this->EE->db->get()->result();
		
		// Check for style and build output
		if($this->archive->attrStyle == "nested" && $this->archive->attrType == "monthly")
		{
			$years = array_values(array_unique($this->helper->simplify_array($this->archive->results, "year")));
			
			$this->archive->output .= '<ul' . (empty($this->archive->attrCssId) ? '' : ' id="' . $this->archive->attrCssId . '"') . '>';
			foreach($years as $year_key => $yearitem)
			{
				$link_text = lang(date(($this->archive->attrYear == "long" ? "Y" : "'y"), mktime(0, 0, 0, 1, 1, $yearitem)));
				$link = $yearitem;
				
				// Get months for this year
				$year_total = 0;
				$months = array();
				foreach($this->archive->results as $result)
				{
					if($result->year == $yearitem)
					{
						$year_total += $result->count;
						array_push($months, $result);
					}
				}
				
				// Print it
				if(!empty($months))
				{
					$class = ($year_key == 0 ? 'first ' : '') . ($year_key == count($years) - 1 ? 'last ' : '') . ($this->helper->in_url($yearitem) ? $this->archive->attrCssActive . ' ' : '') . (empty($this->archive->attrCssYears) ? '' : $this->archive->attrCssYears . ' ');
					$this->archive->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->archive->attrShowLink == "yes") ? '<a href="/' . $this->archive->attrPath . '/' . $link . '">' : '') . $link_text . (($this->archive->attrShowLink == "yes") ? '</a>' : '') . (($this->archive->attrShowCounter == "yes") ? ' (' . $year_total . ')' : '');
						
						$this->archive->output .= '<ul>';
						foreach($months as $month_key => $monthitem)
						{
							$link_text = lang(date(($this->archive->attrMonth == "long" ? "F" : "M"), mktime(0, 0, 0, $monthitem->month, 1, $yearitem)));
							$link = $yearitem . '/' . $monthitem->month;
							
							$class = ($month_key == 0 ? 'first ' : '') . ($month_key == count($months) - 1 ? 'last ' : '') . (($this->helper->in_url($monthitem->month) && $this->helper->in_url($yearitem)) ? $this->archive->attrCssActive . ' ' : '') . (empty($this->archive->attrCssMonths) ? '' : $this->archive->attrCssMonths . ' ');
							$this->archive->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->archive->attrShowLink == "yes") ? '<a href="/' . $this->archive->attrPath . '/' . $link . '">' : '') . $link_text . (($this->archive->attrShowLink == "yes") ? '</a>' : '') . (($this->archive->attrShowCounter == "yes") ? ' (' . $monthitem->count . ')' : '');
						}
						$this->archive->output .= '</ul>';
					
					$this->archive->output .= '</li>';
				}
			}
			$this->archive->output .= '</ul>';
		}
		else // List
		{
			$this->archive->output .= '<ul>';
			foreach($this->archive->results as $key => $archive)
			{
				$month = lang(date(($this->archive->attrMonth == "long" ? "F" : "M"), mktime(0, 0, 0, $archive->month, 1, $archive->year)));
				$year = lang(date(($this->archive->attrYear == "long" ? "Y" : "'y"), mktime(0, 0, 0, 1, 1, $archive->year)));

				$link_text = ($this->archive->attrType == "yearly") ? $year : $month . ' ' . $year;
				$link = ($this->archive->attrType == "yearly") ? $archive->year : $archive->year . '/' . $archive->month ;

				$class = ($key == 0 ? 'first ' : '') . ($key == count($this->archive->results) - 1 ? 'last ' : '') . (($this->helper->in_url($archive->month) && $this->helper->in_url($archive->year)) ? $this->archive->attrCssActive . ' ' : '');
				$this->archive->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->archive->attrShowLink == "yes") ? '<a href="/' . $this->archive->attrPath . '/' . $link . '">' : '') . $link_text . (($this->archive->attrShowLink == "yes") ? '</a>' : '') . (($this->archive->attrShowCounter == "yes") ? ' (' . $archive->count . ')' : '');
				$this->archive->output .= '</li>';
			}
			$this->archive->output .= '</ul>';
		}
		
		return $this->archive->output;
	}
	
	function categories()
	{
		// Get tag attributes and vars
		$this->categories->results = null;
		$this->categories->results_nested = array();
		$this->categories->output = null;
		$this->categories->attrChannel = ($this->EE->TMPL->fetch_param('channel')) ? explode('|', $this->EE->TMPL->fetch_param('channel')) : $this->EE->TMPL->fetch_param('channel');
		$this->categories->attrCatGroupId = $this->EE->TMPL->fetch_param('cat_group_id', "all");
		$this->categories->attrCssActive = $this->EE->TMPL->fetch_param('css_active', "active");
		$this->categories->attrCssActiveTrail = $this->EE->TMPL->fetch_param('css_active_trail', "active-trail");
		$this->categories->attrPath = $this->EE->TMPL->fetch_param('path', $this->EE->uri->uri_string . '/category');
		$this->categories->attrShowChildren = $this->EE->TMPL->fetch_param('show_children', "yes");
		$this->categories->attrShowCounter = $this->EE->TMPL->fetch_param('show_counter', "yes");
		$this->categories->attrShowEmpty = $this->EE->TMPL->fetch_param('show_empty', "no");
		$this->categories->attrShowLink = $this->EE->TMPL->fetch_param('show_link', "yes");
		$this->categories->attrStatus = explode('|', $this->EE->TMPL->fetch_param('status', 'open'));
		$this->categories->attrStyle = $this->EE->TMPL->fetch_param('style', 'nested');
		$this->categories->attrStartOn = $this->EE->TMPL->fetch_param('start_on', "");
		$this->categories->attrShowFutureEntries = $this->EE->TMPL->fetch_param('show_future_entries', "no"); // Options: yes, no
		
		if($this->categories->attrCatGroupId != "all")
		{
			if(!strpos($this->categories->attrCatGroupId, '|'))
			{
				$this->categories->catgroups = $this->categories->attrCatGroupId;
			}
			else
			{
				$this->categories->catgroups = implode("','", explode('|', $this->categories->attrCatGroupId));
			}
		}
		else
		{
			//get all category groups
			$this->categories->catgroup_results = $this->EE->db->select('cat_group')->where_in('channel_name', $this->categories->attrChannel)->get('channels')->result();
			$this->categories->catgroups = '';
			foreach($this->categories->catgroup_results as $key => $cat_group)
			{
				if(!strpos($cat_group->cat_group,'|'))
				{
					$this->categories->catgroups .= $cat_group->cat_group."','";
				}
				else
				{
					$this->categories->catgroups .= implode("','", explode('|', $cat_group->cat_group));
				}
				
			}
			
		}
		
		$this->categories->catgroups = rtrim($this->categories->catgroups, ",'");
		
		// Build Query
		$this->EE->db->select('c.cat_id, count(DISTINCT cp.entry_id) as cat_count, c.cat_name, c.cat_url_title, c.parent_id')
					 ->from('exp_categories c, exp_channels ch')
					 ->join('exp_category_posts cp', 'cp.cat_id = c.cat_id', 'left')
					 ->join('exp_channel_titles ct', 'ct.entry_id = cp.entry_id', 'left')
					 //->join('exp_channels ch', 'ch.cat_group = c.group_id', 'left')
					 ->where("(c.group_id IN ('".$this->categories->catgroups."'))");
		if($this->categories->attrStartOn != '') $this->EE->db->where('ct.entry_date >=', $this->EE->localize->convert_human_date_to_gmt($this->categories->attrStartOn));
		$this->EE->db->order_by("cat_order");
		
			
			if($this->categories->attrShowFutureEntries != "yes")
			{
				$timestamp = ($this->EE->TMPL->cache_timestamp != '') ? $this->EE->localize->set_gmt($this->EE->TMPL->cache_timestamp) : $this->EE->localize->now;
				$this->EE->db->where('(ct.entry_date < ' . $timestamp . ' OR ct.entry_date IS NULL)');
			}
			
			// Filter children
			if($this->categories->attrShowChildren == "no")
			{
				$this->EE->db->where('c.parent_id', 0);
			}
			
			// Filter status
			if($this->categories->attrStatus && $this->categories->attrShowEmpty != "yes")
			{
				$this->EE->db->where_in('ct.status', $this->categories->attrStatus);
				
			}
			elseif($this->categories->attrStatus && $this->categories->attrShowEmpty == "yes")
			{
				$this->EE->db->where('(ct.status IN ("' . implode('","', $this->categories->attrStatus) . '") OR ct.status IS NULL)');
			}
			
			// Filter channels
			if($this->categories->attrChannel)
			{
				$this->EE->db->where_in('ch.channel_name', $this->categories->attrChannel);
			}
			
			// Execute Query
			$this->categories->results = $this->EE->db->group_by("c.cat_id")->get()->result();
			
			
		// Check for style
		if($this->categories->attrStyle == "nested")
		{
			foreach($this->categories->results as $key => $category)
			{
				if(!empty($category->parent_id))
				{
					if(!isset($this->categories->results_nested[$category->parent_id]))
						$this->categories->results_nested[$category->parent_id] = array();
					array_push($this->categories->results_nested[$category->parent_id], $category);
					unset($this->categories->results[$key]);
				}
			}
		}
		
		// Build Output
		$this->categories->output .= '<ul>';
		foreach($this->categories->results as $key => $category)
		{
			$class = ($key == 0 ? 'first ' : '') . ($key == count($this->categories->results) - 1 ? 'last ' : '') . (($this->helper->in_url($category->cat_url_title)) ? $this->categories->attrCssActive . ' ' : '') . (($this->helper->in_url($this->helper->get_child_categories($category->cat_id))) ? $this->categories->attrCssActiveTrail . ' ' : '');
			$this->categories->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->categories->attrShowLink == "yes") ? '<a href="/' . $this->categories->attrPath . '/' . $category->cat_url_title . '">' : '') . $category->cat_name . (($this->categories->attrShowLink == "yes") ? '</a>' : '') . (($this->categories->attrShowCounter == "yes") ? ' (' . $category->cat_count . ')' : '');
			$this->categories_nested($category->cat_id);
			$this->categories->output .= '</li>';
		}
		$this->categories->output .= '</ul>';
		
		return $this->categories->output;
	}
	
	private function categories_nested($parent_id)
	{
		if(!empty($this->categories->results_nested[$parent_id]))
		{
			$this->categories->output .= '<ul>';
			foreach($this->categories->results_nested[$parent_id] as $key => $category)
			{
				$class = ($key == 0 ? 'first ' : '') . ($key == count($this->categories->results) - 1 ? 'last ' : '') . (($this->helper->in_url($category->cat_url_title)) ? $this->categories->attrCssActive . ' ' : '') . (($this->helper->in_url($this->helper->get_child_categories($category->cat_id))) ? $this->categories->attrCssActiveTrail . ' ' : '');
				$this->categories->output .= '<li' . ((empty($class)) ? '' : ' class="' . trim($class) . '"') . '>' . (($this->categories->attrShowLink == "yes") ? '<a href="/' . $this->categories->attrPath . '/' . $category->cat_url_title . '">' : '') . $category->cat_name . (($this->categories->attrShowLink == "yes") ? '</a>' : '') . (($this->categories->attrShowCounter == "yes") ? ' (' . $category->cat_count . ')' : '');
				$this->categories_nested($category->cat_id);
				$this->categories->output .= '</li>';
			}
			$this->categories->output .= '</ul>';
		}
	}
}