<?php
/*
Plugin Name: WordPress phpinfo()
Plugin URI: http://thisismyurl.com/plugins/wordpress-phpinfo/
Description:  This simple plugin adds an option to an adminstrator's Tools menu which displays standard phpinfo() feedback details to the user.
Author: Christopher Ross
Version: 3.5.2
Author URI: http://thisismyurl.com/
*/


/**
 * WordPress phpinfo() core file
 *
 * This file contains all the logic required for the plugin
 *
 * @link		http://wordpress.org/extend/plugins/wordpress-phpinfo/
 *
 * @package 		WordPress phpinfo()
 * @copyright		Copyright (c) 2008, Chrsitopher Ross
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		WordPress phpinfo() 1.0
 */


// add menu to WP admin
function thisismyurl_php_info_wordpress_menu() {
	$thisismyurl_php_info_settings = add_management_page( 'phpinfo()', 'phpinfo()', 'edit_posts', 'thisismyurl_php_info', 'thisismyurl_php_info_wordpress_options' );
	add_action( 'load-'.$thisismyurl_php_info_settings, 'thisismyurl_php_info_wordpress_scripts' );
}
add_action( 'admin_menu', 'thisismyurl_php_info_wordpress_menu' );


function thisismyurl_php_info_wordpress_scripts() {
	wp_enqueue_style( 'dashboard' );
	wp_enqueue_script( 'postbox' );
	wp_enqueue_script( 'dashboard' );
	?>
	    <style>
			.thisismyurl_php_info_key {width: 30%; float: left; padding-bottom: 10px; clear:left;}
			.thisismyurl_php_info_value {width: 70%; float: left; padding-bottom: 10px; clear:right;}
	   </style>
	<?php

}

function thisismyurl_php_info_wordpress_options() {

	if ( $_POST ) {
		$setting = array( $_POST['setting1'], $_POST['setting2'], $_POST['setting3'] );
		update_option( 'thisismyurl_php_info', json_encode( $setting ) );
	}

	if ( empty( $setting ) )
		$setting = json_decode( get_option( 'thisismyurl_php_info' ) );


	$settingcount = 0;
	if ( $setting ) {
		foreach ( $setting as $settingitem ) {

			if ( $setting[$settingcount] )
				$cb[$settingcount] = 'checked="checked"';

			$settingcount++;
		}
	}


	echo '<div class="wrap">
			<div class="thisismyurl icon32"><br /></div>
			<h2>'.__( 'PHPinfo() for WordPress by Christopher Ross','thisismyurl_php_info' ).'</h2>
			<div class="postbox-container" style="width:70%">
			<div class="metabox-holder">
					<div class="meta-box-sortables">';
	$php_info = ( thisismyurl_php_info_phpinfo_array() );

	if ( $php_info ) {
		foreach ( $php_info as $php_info_section_key => $php_info_section ) {

			echo '
				<div id="edit-pages" class="postbox">
				<div class="handlediv" title="' . __( 'Click to toggle','thisismyurl_php_info' ) . '"><br /></div>
				<h3 class="hndle"><span>' . __( $php_info_section_key,'thisismyurl_php_info' ) . '</span></h3>
				<div class="inside">';

				if ( $php_info_section ) {
				foreach ( $php_info_section as $key => $value )  {

					if ( !is_string( $value ) )
						$value  = strval( $value );

					echo "<div class='thisismyurl_php_info_key'>" . $key . "</div>";
					echo "<div class='thisismyurl_php_info_value'>" . wordwrap( $value, 50, "<br />\n", true ) . "</div>";
				}
		}

			echo'<div style="clear:both;"></div></div><!-- .inside --></div><!-- #edit-pages -->';
		}
	}

	echo '	</div><!-- .meta-box-sortables -->
					</div><!-- .metabox-holder -->

			</div><!-- .postbox-container -->

			<div class="postbox-container" style="width:20%">

				<div class="metabox-holder">
				<div class="meta-box-sortables">

					<div id="edit-pages" class="postbox">
					<div class="handlediv" title="'.__( 'Click to toggle','thisismyurl_php_info' ).'"><br /></div>
					<h3 class="hndle"><span>'.__( 'Plugin Information','thisismyurl_php_info' ).'</span></h3>
					<div class="inside">
						<p>'.__( 'phpinfo() by Christopher Ross is a free WordPress plugin. If you\'ve enjoyed the plugin please give the plugin 5 stars on WordPress.org.','thisismyurl_php_info' ).'</p>
						<p>'.__( 'Want to help? Please consider translating this pluginto your local language, or offering a hand in the support forums.','thisismyurl_php_info' ).'</p>
						<p><a href="http://wordpress.org/extend/plugins/wordpress-php-info/">WordPress.org</a> | <a href="http://thisismyurl.com">'.__( 'Plugin Author','thisismyurl_php_info' ).'</a></p>
					</div><!-- .inside -->
					</div><!-- #edit-pages -->

				</div><!-- .meta-box-sortables -->
				</div><!-- .metabox-holder -->

			</div><!-- .postbox-container -->
	</div><!-- .wrap -->

	';
}

function thisismyurl_php_info_phpinfo_array( $return=false ){

	ob_start();
	phpinfo(-1);

	$pi = preg_replace(
	array('#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
	'#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
	"#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
	'#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
	.'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
	'#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
	'#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
	"# +#", '#<tr>#', '#</tr>#'),
	array('$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
	'<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
	"\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
	'<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
	'<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" .
	'<tr><td>Zend Egg</td><td>$1</td></tr>', ' ', '%S%', '%E%'),
	ob_get_clean() );

	$sections = explode( '<h2>', strip_tags( $pi, '<h2><th><td>' ) );
	unset( $sections[0] );

	$pi = array();
	foreach( $sections as $section ) {
		$n = substr( $section, 0, strpos( $section, '</h2>' ) );
		preg_match_all( '#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',$section, $askapache, PREG_SET_ORDER );
		foreach( $askapache as $m )
			$pi[$n][$m[1]]=( !isset( $m[3] )||$m[2]==$m[3] )?$m[2]:array_slice( $m,2 );
	}

	return $pi;
}
