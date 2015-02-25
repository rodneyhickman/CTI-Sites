<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ctiblog');

/** MySQL database username */
define('DB_USER', 'ctiblogger');

/** MySQL database password */
define('DB_PASSWORD', 'co@ctive');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',        'gTBYT[y&p9(kVkWnWnij^j$4p`z)|AE3g,r+F@vu;!+BjGQ`QwB*^KxhhUqG?O<l');
define('SECURE_AUTH_KEY', 'X)^*F|X(>tv#Eds+KPQ(-G+<2GnSU[mC2+bG_Xceo< #L$S #fwG-EC<p+~4Qi4B');
define('LOGGED_IN_KEY',   'n@RB{E5{`~LKn#uxKT>A4si+U6GEjbnkW[v`]7v%@=u] hp:O5Uf{uPKW+:(HZ3x');
define('NONCE_KEY',       'GpqV^}6O8s0}^jLl*sm+yT(mRa0>^+k2:L*wl2+>o{nVK,Yl`Rm`K$.26-dwi?0T');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
