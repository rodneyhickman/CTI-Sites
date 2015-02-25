<?php
/*
Plugin Name: Archives
Version: 1.1.3
Description: Using Archives you can easily add an Archives pages in your WordPress site using a shortcode. The Archives page is available in jQuery and HTML layout.
Author: Pritesh Gupta
Author URI: http://www.priteshgupta.com
Plugin URI: http://www.priteshgupta.com/plugins/archives
License: GPL
*/

/*  Copyright (C) 2011  Pritesh Gupta {http://www.priteshgupta.com/plugins/archives}

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
        add_action('activate_archives.php', 'archives');
		function archives(){
			add_option("archives", '30');
			add_option("archives_display", 'no');
		}
	add_action('wp_head', 'archives_session');
	function archives_session(){$_SESSION['archives_nri'] = 0;}
	
    add_action('admin_menu', 'archives_menu');
    function archives_menu() {
        if (function_exists('add_options_page')) {
            add_options_page('Archives', 'Archives', 9, 'archives', 'archives_display');
        }
    }
    function archives_display(){
		
        if($_POST['Submit']){
			$archives = $_POST['archives'];
			$archives2 = $_POST['archives2'];
			$archives3 = $_POST['archives3'];
			update_option("archives", $archives);
			update_option("archives2", $archives2);
			update_option("archives3", $archives3);
			update_option("archives_display", $_POST['archives_display']);
			
			echo '<div id="message" class="updated fade"><p>Update Successful!</p></div>';
		}
		$output = '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
		?>
	<style type="text/css">
	.author{
	text-decoration:none;
	}
		
	table{
	width:60%;
	border-collapse:collapse;
	table-layout:auto;
	vertical-align:top;
	margin-bottom:15px;
	border:1px solid #CCCCCC;
	}

	table thead th{
	color:#FFFFFF;
	background-color:#666666;
	border:1px solid #CCCCCC;
	border-collapse:collapse;
	text-align:center;
	table-layout:auto;
	vertical-align:middle;
	}

	table tbody td{
	vertical-align:top;
	border-collapse:collapse;
	border-left:1px solid #CCCCCC;
	border-right:1px solid #CCCCCC;
	}
	
	table thead th, table tbody td{
	padding:5px;
	border-collapse:collapse;
	}

	table tbody tr.light{
	color:#333333;
	background-color:#F7F7F7;
	}

	table tbody tr.dark{
	color:#333333;
	background-color:#E8E8E8;
	}
	
	input[type=text]{
	background: #cecdcd; /* Fallback */
	background: rgba(206, 205, 205, 0.6);
	border: 2px solid #666;
	padding: 6px 5px;
	line-height: 1em;
	-webkit-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-moz-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-webkit-border-radius: 8px !important; 
	-moz-border-radius: 8px !important;
	border-radius: 8px !important; 
	margin-bottom: 10px;
	width: 300px;
	}
	
	select{
	background: #cecdcd; /* Fallback */
	background: rgba(206, 205, 205, 0.6);
	border: 2px solid #666;
	padding: 6px 5px;
	height: 2.8em !important;
	-webkit-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-moz-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-webkit-border-radius: 8px !important; 
	-moz-border-radius: 8px !important;
	border-radius: 8px !important; 
	margin-bottom: 10px;
	width: 300px;
	text-align:center;
	}
	
	</style>
		<?php
		$output .= '<div class="wrap">'."\n";
		$output .= '	<h2>Archives Plugin Options</h2>'."\n";
		$output .= '	Plugin by <strong><a href="http://www.priteshgupta.com" target="_blank" class="author">Pritesh Gupta</a></strong> || <strong><a href="http://www.priteshgupta.com/plugins/archives" target="_blank" class="author">Visit Release Page</a></strong>'."\n";
		$output .= '	<br /> <br />'."\n";
		$output .= '	<table border="0" cellspacing="0" cellpadding="6">'."\n";
		
		$archives_display = get_option('archives_display', 'no');
		$output .= '		<tr class="light">'."\n";
		$output .= '			<td width="75%">Use jQuery Tabs for Archives Page?</td>'."\n";
		$output .= '			<td width="25%">';
		$output .= '				<select name="archives_display">'."\n";
		$output .= '					<option value="no"';if ($archives_display == 'no') $output .= 'selected="selected"';$output .= '>No</option>'."\n";
		$output .= '					<option value="yes"';if ($archives_display == 'yes') $output .= 'selected="selected"';$output .= '>Yes</option>'."\n";
		$output .= '				</select>'."\n";
		$output .= '			</td>';
		$output .= '		</tr>'."\n";
		$output .= '		<tr class="dark">'."\n";
		$output .= '			<td width="75%">Enter number of Recent Posts to display: </td>'."\n";
		$output .= '			<td width="25%"><input type="text" name="archives" value="'.get_option('archives', '30').'" /></td>';
		$output .= '		</tr>'."\n";
		$output .= '	</table>'."\n";
		$output .= "\n";
		$output .= '				<input type="submit" name="Submit" class="button-primary" style="float:left" value="Update Options &raquo;" /><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=doubleagentcreative%40gmail%2ecom&lc=US&item_name=Pritesh%20Gupta&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHostedGuest" title="PayPal Donate" style="float:left; margin-left: 7px"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" /></a>&nbsp;&nbsp;'."\n";
		$output .= '</form>';
		$output .= '</div>'."\n";
        echo $output;
    }

function Archives_Page($atts) {
if (get_option("archives_display") == 'yes'){ include 'jquery-archives.php'; } else { include 'html-archives.php'; }
}
add_shortcode('Archives' , 'Archives_Page' );
add_shortcode('archives' , 'Archives_Page' );
?>
