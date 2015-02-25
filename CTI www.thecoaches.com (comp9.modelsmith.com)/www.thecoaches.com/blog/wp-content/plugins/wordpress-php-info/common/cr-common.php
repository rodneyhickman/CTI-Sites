<?php

/*
	/--------------------------------------------------------------------\
	|                                                                    |
	| License: GPL                                                       |
	|                                                                    |
	| Copyright (C) 2010, Christopher Ross			  	     |
	| http://www.bad-neighborhood.com                                    |
	| All rights reserved.                                               |
	|                                                                    |
	| This program is free software; you can redistribute it and/or      |
	| modify it under the terms of the GNU General Public License        |
	| as published by the Free Software Foundation; either version 2     |
	| of the License, or (at your option) any later version.             |
	|                                                                    |
	| This program is distributed in the hope that it will be useful,    |
	| but WITHOUT ANY WARRANTY; without even the implied warranty of     |
	| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
	| GNU General Public License for more details.                       |
	|                                                                    |
	| You should have received a copy of the GNU General Public License  |
	| along with this program; if not, write to the                      |
	| Free Software Foundation, Inc.                                     |
	| 51 Franklin Street, Fifth Floor                                    |
	| Boston, MA  02110-1301, USA                                        |   
	|                                                                    |
	\--------------------------------------------------------------------/
*/


/*

	version: 0.0.1

*/




global $cr_wordpress_php_info_plugin_admin_level;
global $cr_wordpress_php_info_plugin_file_name;
global $cr_wordpress_php_info_plugin_slug_name;
global $cr_wordpress_php_info_plugin_admin_menu;

global $cr_common_wp_head;

add_filter( 'plugin_action_links', 'cr_wordpress_php_info_admin_action' , - $cr_wordpress_php_info_plugin_admin_level, 2 ); 
add_action('admin_menu', 'cr_wordpress_php_info_admin_menu');
add_action('admin_head', 'cr_wordpress_php_info_admin_header');
add_action('admin_head', 'cr_wordpress_php_info_activation');
add_action('wp_head', 'cr_wordpress_php_info_header_code');
add_action('wp_footer', 'cr_wordpress_php_info_footer_code');


if (get_option('cr_wordpress_php_info_dashboard_feed') == 'true') {add_action('wp_dashboard_setup', 'cr_wordpress_php_info_add_dashboard_widgets' );}







function cr_wordpress_php_info_admin_action($links, $file) {

	// constructs the admin plugin menu and adds links to the plugins page

	global $cr_wordpress_php_info_plugin_docs;
	global $cr_wordpress_php_info_plugin_forum;
	global $cr_wordpress_php_info_plugin_donate;
	global $cr_wordpress_php_info_plugin_file_name;


	$this_plugin = $cr_wordpress_php_info_plugin_file_name."/".$cr_wordpress_php_info_plugin_file_name.".php";

	if ($file == $this_plugin) {
	
		if ($cr_wordpress_php_info_plugin_docs) {$links [] = "<a href='".$cr_wordpress_php_info_plugin_docs ."?".get_bloginfo('url')."'>Docs</a>";}
		if ($cr_wordpress_php_info_plugin_forum) {$links [] = "<a href='".$cr_wordpress_php_info_plugin_forum ."?".get_bloginfo('url')."'>Forum</a>";}
		if ($cr_wordpress_php_info_plugin_donate) {$links [] = "<a href='".$cr_wordpress_php_info_plugin_donate ."?".get_bloginfo('url')."'>Donate</a>";}

	}
	return $links;
	
}









function cr_wordpress_php_info_admin_menu() {
	
	// adds the plugin menu to WordPress

	global $cr_wordpress_php_info_plugin_name;
	global $cr_wordpress_php_info_plugin_slug_name;
	global $cr_wordpress_php_info_plugin_admin_level;
	global $cr_wordpress_php_info_plugin_admin_menu;
	
	
	if (strlen(get_option($cr_wordpress_php_info_plugin_slug_name.'_menu_location'))>0) {$cr_wordpress_php_info_plugin_admin_menu = get_option($cr_wordpress_php_info_plugin_slug_name.'_menu_location');}
	$cr_wordpress_php_info_plugin_function = $cr_wordpress_php_info_plugin_slug_name."_option";
	if ($cr_wordpress_php_info_plugin_admin_menu == 'dashboard') 	{add_dashboard_page		($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'posts') 		{add_posts_page			($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'media') 		{add_media_page			($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'links') 		{add_links_page			($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'comments') 	{add_comments_page		($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'theme') 		{add_theme_page			($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'plugins') 	{add_plugins_page		($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'users') 		{add_users_page			($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'tools') 		{add_management_page	($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	if ($cr_wordpress_php_info_plugin_admin_menu == 'options') 	{add_options_page		($cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_name, $cr_wordpress_php_info_plugin_admin_level,$cr_wordpress_php_info_plugin_slug_name, $cr_wordpress_php_info_plugin_function);}
	
}












function cr_wordpress_php_info_dashboard_widget_function() {

	global $cr_wordpress_php_info_plugin_slug_name;
	
	echo "<ul>";
	echo cr_wordpress_php_info_fetch_rss($link = "http://feeds.feedburner.com/thisismyurl?format=xml",$max=5,$format='list');
	echo "</ul>";
} 







function cr_wordpress_php_info_add_dashboard_widgets() {
	global $cr_wordpress_php_info_plugin_name;
	wp_add_dashboard_widget('cr_wordpress_php_info_dashboard_widget', $cr_wordpress_php_info_plugin_name.' Plugin Updates', 'cr_wordpress_php_info_dashboard_widget_function');
}








function cr_wordpress_php_info_activation() {
	// test to see if the plugin has alreasy set the settings
	global $cr_wordpress_php_info_plugin_slug_name;
	global $cr_wordpress_php_info_plugin_admin_level;
	global $cr_wordpress_php_info_plugin_admin_menu;
	
    $testoptions = get_option($cr_wordpress_php_info_plugin_slug_name.'_menu_location');
    if (strlen($testoptions) == 0 ) {
        // Install plugin
		
		update_option($cr_wordpress_php_info_plugin_slug_name.'_promos', 			'true');
		update_option($cr_wordpress_php_info_plugin_slug_name.'_credit', 			'false');
		update_option($cr_wordpress_php_info_plugin_slug_name.'_dashboard_feed', 	'false');
		update_option($cr_wordpress_php_info_plugin_slug_name.'_access', 			$cr_wordpress_php_info_plugin_admin_level);
		update_option($cr_wordpress_php_info_plugin_slug_name.'_menu_location', 	$cr_wordpress_php_info_plugin_admin_menu);
		
    }
}






function cr_wordpress_php_info_footer_code($options='') {

	// run this check in the footer of the website
	
	global $cr_wordpress_php_info_plugin_slug_name;
	global $cr_wordpress_php_info_plugin_name;
	
	// add credit link
	if (get_option($cr_wordpress_php_info_plugin_slug_name.'_credit') == 'true') {
		echo "<p><a href='".cr_wordpress_php_info_fetch_rss('http://feeds.feedburner.com/thisismyurl?format=xml',1,'url')."'>$cr_wordpress_php_info_plugin_name by Christopher Ross</a></p>";
	} else {
		echo "<!--  $cr_wordpress_php_info_plugin_name by Christopher Ross - ".cr_wordpress_php_info_fetch_rss('http://feeds.feedburner.com/thisismyurl?format=xml',1,'url')." -->";
	}
}

function cr_wordpress_php_info_header_code($options='') {

}










function cr_wordpress_php_info_fetch_rss($link = "http://feeds.feedburner.com/thisismyurl?format=xml",$max=10,$format='url') {

	// RSS feed for plugins

	$rss = fetch_feed($link);
	$rss_items = $rss->get_items(0, $max); 
	if ($maxitems > 0) {
		foreach ( $rss_items as $item ) {
			if ($format == 'url') {$rsslinks .= $item->get_permalink().", ";}
			if ($format == 'list') {$rsslinks .= "<li><a href='".$item->get_permalink()."'>".$item->get_title()."</a></li>";}
		}
	}
	
	
	if ($format == 'url') {
		$rsslinks =  substr($rsslinks, 0, strlen($rsslinks)-2);
		if (substr_count($color,",")>0) {
			$lastcomma = strrpos($rsslinks,","); 
			$rsslinks = substr_replace($rsslinks," and",$lastcomma,1); 
		}
	}
	
	return $rsslinks;
}








function cr_wordpress_php_info_option_top() {



	// admin page for plugin
	
	global $cr_wordpress_php_info_plugin_name;
	global $cr_wordpress_php_info_plugin_url;
	global $cr_wordpress_php_info_plugin_donate;
	global $cr_wordpress_php_info_plugin_forum;
	global $cr_wordpress_php_info_plugin_slug_name;	
	global $updatefields;
	global $cr_wordpress_php_info_plugin_admin_thankyou;

	// admin page top
	echo "<div class='wrap ' id='wrapper'><div id='icon-options-general' class='icon32'><br /></div>";
	echo "<h2>$cr_wordpress_php_info_plugin_name Settings</h2>";
	echo "<form method='post' action='options.php'>";
	wp_nonce_field('update-options');
	
	echo "<div id='cr_admin_top'>";
	
	if (get_option($cr_wordpress_php_info_plugin_slug_name.'_promos') != 'false') {
		echo "<h3>Please Support $cr_wordpress_php_info_plugin_name</h3>";
		echo "<p><a href='".$cr_wordpress_php_info_plugin_url."'>".$cr_wordpress_php_info_plugin_name."</a> is a free software package developed to help you make the most of WordPress. You can help support development of $cr_wordpress_php_info_plugin_name and other great WordPress plugins by <a href='".$cr_wordpress_php_info_plugin_donate."'>making a donation</a> or supporting our sponsors.</p>";
	}
	
	echo "</div>";

	// admin page main
	
	echo "<div id='cr_admin_main'>";
	
	

}



function cr_wordpress_php_info_option_bottom() {

	global $cr_wordpress_php_info_plugin_file_name;
	global $cr_wordpress_php_info_plugin_slug_name;
	global $cr_wordpress_php_info_plugin_name;
	global $cr_wordpress_php_info_plugin_admin_credits;
	global $updatefields;




	
	// display readme.txt
	echo "<div class='accordionButton'><strong>Instructions &amp; readme.txt</strong></div>";
	echo "<div class='accordionContent'><p>";
		$readme = ABSPATH ."/wp-content/plugins/".$cr_wordpress_php_info_plugin_file_name."/readme.txt";
		$fh = fopen($readme, 'r');
		$theData = fread($fh, 50000);
		fclose($fh);
		echo "<pre style='width: 780px;'>".wordwrap($theData,80,"<br />")."</pre>";
	echo "</p></div>";







	// display general settings
	echo "<div class='accordionButton'><strong>Plugin System Settings</strong></div>";
	echo "<div class='accordionContent'>";
	echo "<table class='form-table'>";
	

		// which menu should the plugin appear under?
		echo cr_wordpress_php_info_admin_build_option("Menu Location", "_menu_location", "Settings menu location within WordPress menu structure.", "select", "dashboard|Dashboard,posts|Posts,media|Media,links|Links,comments|Comments,theme|Theme,plugins|Plugins,users|Users,tools|Tools,options|Options");
	
		// security level for plugin
		echo cr_wordpress_php_info_admin_build_option("Access Level", "_access", "Minimum access level for users to access this plugin settings screen.", "select", "1|1,2|2,3|3,4|4,5|5,6|6,7|7,8|8,9|9,10|Admin");
	
		// include credit line
		echo cr_wordpress_php_info_admin_build_option("Include Credit", "_credit", "Include a link in the footer of your website as a thank you for this plugin.", "select", "true|Yes,false|No");
			
		// include promos
		echo cr_wordpress_php_info_admin_build_option("Include Promotions", "_promos", "Include promotions and links in the admin settings panel.", "select", "true|Yes,false|No");
	
		// include dashboard
		echo cr_wordpress_php_info_admin_build_option("Include Dashbaord Feed", "_dashboard_feed", "Include a feed of updates on the dashboard.", "select", "true|Yes,false|No");





	echo "</table>";
	echo "</div>";




	
	// show thank you and credits	
	
	if (strlen($cr_wordpress_php_info_plugin_admin_credits) > 0) {
		echo "<div class='accordionButton'><strong>Plugin Credits</strong></div>";
		echo "<div class='accordionContent'>";
	
		echo $cr_wordpress_php_info_plugin_admin_credits;	
	
		echo "</div>";
	}





	
	
	// admin page bottom
	
	echo "<p class='submit'>";
	
	echo "<input type='hidden' name='action' value='update' />";
	
	$updatefields = substr($updatefields, 0, strlen($updatefields)-2);

    echo "<input type='hidden' name='page_options' value='$updatefields' />  ";
    echo "<input type='submit' class='button-primary' value='Save Changes' />";

    echo "</p>";
    echo "</form>";
	
	
	echo "</div>"; // close wrap




}






function cr_wordpress_php_info_admin_build_option($title, $slug, $desc, $type, $data) {
	global $updatefields;
	global $cr_wordpress_php_info_plugin_slug_name;
	

	if ($type == "text") {
		$options  = "<input name='".$cr_wp_ab_slug_name.$slug."' id='".$cr_wp_ab_slug_name.$slug."' class='regular-text' value='$data'>";
	}





	if ($type == "select") {
		$options  = "<select name='".$cr_wordpress_php_info_plugin_slug_name.$slug."' id='".$cr_wordpress_php_info_plugin_slug_name.$slug."' class='postform' >";
		
		$data = explode(",",$data);
		foreach ($data as $line) {
			$linedata = explode("|",$line);
			$options .= "<option class='level-0' value='".$linedata[0]."' ";
			
			$current = get_option($cr_wordpress_php_info_plugin_slug_name.$slug);
			
			if ($current == $linedata[0]) {$options .= "selected";}
			
			$options .=">".$linedata[1]."</option>";
		}
		
		$options .= "</select>";	
	}

	$updatefields .= $cr_wordpress_php_info_plugin_slug_name.$slug.", ";


	return "<tr valign='top'>
			<th scope='row'><label for='".$cr_wordpress_php_info_plugin_slug_name.$slug."'>$title</label></th>
			<td>
			$options
			<p>$desc</p>
			</td>
			</tr>";
}



function cr_wordpress_php_info_admin_header() {

	// admin header css & js for the plugin
	global $cr_wordpress_php_info_plugin_slug_name;
	global $cr_wordpress_php_info_plugin_file_name;
		global $cr_common_wp_head;

	
	if ($cr_common_wp_head != true) {
		$cr_common_wp_head = true;

	
		$url = get_option('siteurl');
		$cssurl = $url . "/wp-content/plugins/".$cr_wordpress_php_info_plugin_file_name."/common/wp-admin.css";
		$jsurl = $url . "/wp-content/plugins/".$cr_wordpress_php_info_plugin_file_name."/common/wp-admin.js";
		
		echo "<link rel='stylesheet' type='text/css' href='". $cssurl ."' />";
		
		// google ads
		echo "	<script type='text/javascript' src='http://partner.googleadservices.com/gampad/google_service.js'></script>
				<script type='text/javascript'>GS_googleAddAdSenseService('ca-pub-9144171931162286'); GS_googleEnableAllServices();</script>
				<script type='text/javascript'>GA_googleAddSlot('ca-pub-9144171931162286', '300x250');</script>
				<script type='text/javascript'>GA_googleFetchAds();</script>";
				
		// add menus		
		echo "	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js'></script>
				<script type='text/javascript' src='".$jsurl."'></script>
		";
	}
}








function cr_wordpress_php_info_update() {

}


?>