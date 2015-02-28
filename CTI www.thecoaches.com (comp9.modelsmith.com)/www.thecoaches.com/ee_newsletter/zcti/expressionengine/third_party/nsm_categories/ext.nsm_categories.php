<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require PATH_THIRD.'nsm_categories/config.php';

/**
 * NSM Categories Extension
 *
 * @package			NsmCategories
 * @version			1.0.0
 * @author			Leevi Graham <http://leevigraham.com>
 * @copyright 		Copyright (c) 2007-2012 Newism <http://newism.com.au>
 * @license 		Commercial - please see LICENSE file included with this distribution
 * @link			http://expressionengine-addons.com/nsm-categories
 * @see 			http://expressionengine.com/public_beta/docs/development/extensions.html
 */

class Nsm_categories_ext
{
	public $addon_id		= NSM_CATEGORIES_ADDON_ID;
	public $version			= NSM_CATEGORIES_VERSION;
	public $name			= NSM_CATEGORIES_NAME;
	public $description		= 'NSM Categories';
	public $docs_url		= '';
	public $settings_exist	= FALSE;
	public $settings		= array();

	// At leaset one hook is needed to install an extension
	// In some cases you may want settings but not actually use any hooks
	// In those cases we just use a dummy hook
	public $hooks = array('channel_entries_query_end');

	public $default_site_settings = array(
		'enabled' => TRUE,
	);

	// ====================================
	// = Delegate & Constructor Functions =
	// ====================================

	/**
	 * PHP5 constructor function.
	 *
	 * @access public
	 * @return void
	 **/
	function __construct() {

		$EE =& get_instance();

		// define a constant for the current site_id rather than calling $PREFS->ini() all the time
		if (defined('SITE_ID') == FALSE) {
			define('SITE_ID', $EE->config->item('site_id'));
		}

		// Init the cache
		$this->_initCache();
	}

	/**
	 * Initialises a cache for the addon
	 * 
	 * @access private
	 * @return void
	 */
	private function _initCache() {

		$EE =& get_instance();

		// Sort out our cache
		// If the cache doesn't exist create it
		if (! isset($EE->session->cache[$this->addon_id])) {
			$EE->session->cache[$this->addon_id] = array();
		}

		// Assig the cache to a local class variable
		$this->cache =& $EE->session->cache[$this->addon_id];
	}






	// ===============================
	// = Hook Functions =
	// ===============================

    /**
     * Modify the channel query filtering the entry_ids
     *
     * This hook takes the existing channel query and removes entry_ids if they are not
     * in the top N number of records in a category
     * N is defined by the category_channel_entry_limit="" parameter
     * 
     * Requires the following hook added right at the bottom of mod.channel.php build_sql() method
     *
     * if ($this->EE->extensions->active_hook('channel_entries_query_end') === TRUE){
     *     $this->sql = $this->EE->extensions->call('channel_entries_query_end', $this, $this->sql);
     * }
     *
     * @param object $Channel The channel object
     * @param string $entry_query_sql The channel query result string
     * @return string The modified query result
     */
    
	public function channel_entries_query_end($Channel, $entry_query_sql)
	{
		$EE =& get_instance();

        // If this is a nsm_categories:archive tag
        // AND we're limiting the number of entries per category
        if(
            $EE->TMPL->tagparts[0] == 'nsm_categories'
            && $EE->TMPL->tagparts[1] == 'archive'
            && ($category_channel_entry_limit = $EE->TMPL->fetch_param('category_channel_entry_limit'))
        ) {
            // Create a new select query that only returns entry_ids
            // using the exact same select conditionals and join tables
            // That way we've let EE do it's sorting, filtering etc
            $sql = "SELECT t.entry_id FROM" . end(explode("FROM", $entry_query_sql));

            // fire the query and build a entry_id string
            $query = $EE->db->query($sql);
            $result = $query->result_array();
            $entry_ids = false;
            foreach ($result as $count => $row) {
                if($count > 0) {
                    $entry_ids .= ",";
                }
                $entry_ids .= $row['entry_id'];
            }

            // This query pulls the x top number of entries for every category
            // we make sure we're getting the right entries by using the result of the query above
            // we also limit the result based on the required categories
            $sql = "SELECT *
                    FROM
                    (
                        SELECT cp.cat_id, cp.entry_id, # ct.title,
                            @num := if(@group = cp.cat_id, @num + 1, 1) as row_number,
                            @group := cp.cat_id as group_key
                        FROM (SELECT @group:=null,@num:=0) n
                        CROSS JOIN exp_category_posts cp
                        # LEFT JOIN exp_channel_titles ct on cp.entry_id = ct.entry_id
                        WHERE cp.cat_id IN(".str_replace("|", ",", $EE->TMPL->tagparams['category']).")
                        AND cp.entry_id IN ({$entry_ids})
                        ORDER BY cp.cat_id, FIELD(`entry_id`, {$entry_ids})
                    ) temp_table
                    WHERE row_number <= {$category_channel_entry_limit}";

            $query = $EE->db->query($sql);
            $result = $query->result_array();
            // so now we have a subset of entry_ids to search for
            // create a string
            $entry_ids = false;
            foreach ($result as $count => $row) {
                if($count > 0) {
                    $entry_ids .= ",";
                }
                $entry_ids .= $row['entry_id'];
            }

            // now replace the old entry_ids with our more focused query;
            $entry_query_sql = preg_replace("#t.entry_id IN \(.*\)#", "t.entry_id IN ({$entry_ids})", $entry_query_sql);

            // unset the $query and $result even tho they are small
            unset($query, $result);
        }
        return $entry_query_sql;
	}









	// ===============================
	// = Class and Private Functions =
	// ===============================

	/**
	 * Called by ExpressionEngine when the user activates the extension.
	 *
	 * @access		public
	 * @return		void
	 **/
	public function activate_extension() {
		$this->_registerHooks();
	}

	/**
	 * Called by ExpressionEngine when the user disables the extension.
	 *
	 * @access		public
	 * @return		void
	 **/
	public function disable_extension() {
		$this->_unregisterHooks();
	}

	/**
	 * Called by ExpressionEngine updates the extension
	 *
	 * @access public
	 * @return void
	 **/
	public function update_extension($current=FALSE){}









	// ======================
	// = Hook Functions     =
	// ======================

	/**
	 * Sets up and subscribes to the hooks specified by the $hooks array.
	 *
	 * @access private
	 * @param array $hooks A flat array containing the names of any hooks that this extension subscribes to. By default, this parameter is set to FALSE.
	 * @return void
	 * @see http://expressionengine.com/public_beta/docs/development/extension_hooks/index.html
	 **/
	private function _registerHooks($hooks = FALSE) {

		$EE =& get_instance();

		if($hooks == FALSE && isset($this->hooks) == FALSE) {
			return;
		}

		if (!$hooks) {
			$hooks = $this->hooks;
		}

		$hook_template = array(
			'class'    => __CLASS__,
			'settings' => "a:0:{}",
			'version'  => $this->version,
		);

		foreach ($hooks as $key => $hook) {
			if (is_array($hook)) {
				$data['hook'] = $key;
				$data['method'] = (isset($hook['method']) === TRUE) ? $hook['method'] : $key;
				$data = array_merge($data, $hook);
			} else {
				$data['hook'] = $data['method'] = $hook;
			}

			$hook = array_merge($hook_template, $data);
			$EE->db->insert('exp_extensions', $hook);
		}
	}

	/**
	 * Removes all subscribed hooks for the current extension.
	 * 
	 * @access private
	 * @return void
	 * @see http://expressionengine.com/public_beta/docs/development/extension_hooks/index.html
	 **/
	private function _unregisterHooks() {
		$EE =& get_instance();
		$EE->db->where('class', __CLASS__);
		$EE->db->delete('exp_extensions'); 
	}
}