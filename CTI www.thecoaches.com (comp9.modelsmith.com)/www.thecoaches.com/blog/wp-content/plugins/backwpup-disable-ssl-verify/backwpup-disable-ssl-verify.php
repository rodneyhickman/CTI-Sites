<?php
/**
 * Plugin Name: BackWPup disable SSL connection verifying
 * Plugin URI: https://marketpress.com/
 * Description: Disables the verifying from SSL connections in backup destinations
 * Author: Inpsyde GmbH
 * Author URI: http://inpsyde.com
 * Version: 0.1
 * Network: true
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */

add_filter( 'backwpup_cacert_bundle', 'backwpup_disable_ssl_verify' );
function backwpup_disable_ssl_verify ( $file ) {

	return FALSE;
}
