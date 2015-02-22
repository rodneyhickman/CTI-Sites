<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'ctiambassador');

/** MySQL database username */
define('DB_USER', 'ambuser');

/** MySQL database password */
define('DB_PASSWORD', '4rFGt5');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'pl;LP4c2L@VGEB`6z<7f>c sN1!TL]~wI:b;];l*HYW49e~5YQvGUsp!54N2clm!');
define('SECURE_AUTH_KEY',  '20Rqx8$eC)8weDGtV@x6nU#:)^.bn|>Aa-VW:-ze,p)SabTG{n^2|k^eOvd PMK~');
define('LOGGED_IN_KEY',    'YLf$.DTaHIv(]JW&6<q/AP>W:E|0}$> ,kc+Tdhb_w{.6li+kfG7-Ik[vrk-7mMX');
define('NONCE_KEY',        'v`5-_:H +I/AD~n|Gq&5%_%hssRbx,IF?FPM(+6SFm:$fE-Q)I+rXzl.$=ZN2o)E');
define('AUTH_SALT',        'y!F +J GjhwFXrBP@%-6I}55}}v|2~tj70SB:8tHBk_wzn$:^bKu}zzxUmq_Vt8 ');
define('SECURE_AUTH_SALT', 'hK 8`X0FlS~Qs4(-!OcVR-L/}OP`O/Yh_z9H%Dh:*N!&{;w[uCO*&dZA,a389BI%');
define('LOGGED_IN_SALT',   '`f2bV5lgU$_[Q|Du K h(m/+%ANd:[F|#7u@?z!r;-C)PCDH&1q~QIl[LyRZ6J4R');
define('NONCE_SALT',       'EOAHUWFB$Lk=+SQDDpya4Ng;|APufy,,{PpRl_$)G[UQR~?W`&%)A-Q[*eNyq$|m');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_CalgaryDiary_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
