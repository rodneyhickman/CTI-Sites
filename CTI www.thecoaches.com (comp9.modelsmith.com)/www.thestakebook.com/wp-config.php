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
define('DB_NAME', 'thestakebook');

/** MySQL database username */
define('DB_USER', 'stakeuser');

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
define('AUTH_KEY',         '%i?_wg(HB1-%-.A}&|I4Vp!X3gj~71;n+e=tH:)%R|N2y./LR)gVHu-d-8=^Fkz+');
define('SECURE_AUTH_KEY',  ',<Z{{>K-pT6^n%ct^g)+BNEt7vl%?1d-2wn0g=bMp`&@])lhq}ZZp3`Wi;Xd<E=/');
define('LOGGED_IN_KEY',    '/-1xB#]M-_kwXMBJ}4lDR`f248KnOQhn`ao_OAU_i,J1qYJB`Qp(J@3!b-)okEJ+');
define('NONCE_KEY',        'Y^(IG_GR6 q^]e15B8OF<a;U{iYaq<C^PPNj,Ll4C`z~hPt4gzmBO0U1|.th3aYy');
define('AUTH_SALT',        '>?R#0O)5hxh?2J+-=_ac7Q}T5h;MU$l$^-pYFO.!IfB9C[F-tio!K0(2FVB]I(YD');
define('SECURE_AUTH_SALT', 'i(-!U8@7hhFk+IK5tx<G:Ur+r;j~-Hkx;XS z,i{oNkh_GSMe<:S)tD[7zaC$9C!');
define('LOGGED_IN_SALT',   ')Y10W-+zlb+ 2|bNIGHt%E3eN0/bgY4U4_]]}(7mCL@TP>/<zyP}Fy7G~ <[gQRj');
define('NONCE_SALT',       'S%E7wIl>[3p(FR*@Yoyt%ih!c4?(vKo4JYuQh#MvpJyN(3wvdn{>1Z(?:g&BJ<Bz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp1_';

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
