<?php
/*
Plugin Name: SEO - Remove H1
Plugin URI: http://boborchard.com/plugins/seo-remove-h1-wordpress-editor/
Description: Easily remove the H1 tag from the editor within the WordPress admin for SEO purposes.
Version: 1.0.1
Author: Bob Orchard
Author URI: http://boborchard.com
*/

function tp_remove_h1($init) {
  // Add block format elements you want to show in dropdown
  $init['theme_advanced_blockformats'] = 'p,h1,h2';
  return $init;
}

// Modify Tiny_MCE init
add_filter('tiny_mce_before_init', 'tp_remove_h1' );