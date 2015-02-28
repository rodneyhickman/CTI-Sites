<?php

/**
 * Config file for NSM Categories
 *
 * @package			NsmCategories
 * @version			1.0.0
 * @author			Leevi Graham <http://leevigraham.com>
 * @copyright 		Copyright (c) 2007-2012 Newism <http://newism.com.au>
 * @license 		Commercial - please see LICENSE file included with this distribution
 * @link			http://expressionengine-addons.com/nsm-categories
 */

if(!defined('NSM_CATEGORIES_VERSION')) {
	define('NSM_CATEGORIES_VERSION', '1.0.0');
	define('NSM_CATEGORIES_NAME', 'NSM Categories');
	define('NSM_CATEGORIES_ADDON_ID', 'nsm_categories');
}

$config['name'] 	= NSM_CATEGORIES_NAME;
$config["version"] 	= NSM_CATEGORIES_VERSION;

$config['nsm_addon_updater']['versions_xml'] = 'http://ee-garage.com/nsm-categories/release-notes/feed';