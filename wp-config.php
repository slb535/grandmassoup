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
define('DB_NAME', 'grandmassoup');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'grandmassoup.local');

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
define('AUTH_KEY',         'Yvitj?`/:=t!`?DSGbSWY Rtl*eRl[$H)&]/[]P:,+y;rb7HTNb.=ny, kBL[W^k');
define('SECURE_AUTH_KEY',  '7_Oe>%ul|2L9p4TSG92jb=F{nfLp {!BLyfYPomQT|6huF-SzK~PU/l0Z{QU[N(P');
define('LOGGED_IN_KEY',    'bx2}:Sbxxz1d+f8RFNC2,HW+fRuU;-,ptr!LM=v^] #Gf_/iiVtL-le*SRZv<YHs');
define('NONCE_KEY',        'Vsf?P0Sf<O|Yykr89/N*Jg! H]Ffy-o6,--g-&G`^h}3mvw5G6(|3asR/b/#q64o');
define('AUTH_SALT',        'S#u:IUT@WNk_:U5!H!6(f xdl9w>PP1[TJA{U-D7-[ydVf6sT-YQwS9D,K$^}h&}');
define('SECURE_AUTH_SALT', 'C#B<Hq-/2S2j[BV?5W4)(|Z1GH:R>-}#]g#m{$x.o2{,8nCBO`jR?99;BX#Bny?d');
define('LOGGED_IN_SALT',   '7{5+Elfa$hRi/76c&JaJB+*iUB+~=9o!OtfbdBZ/m>+KlTU ${[5oGHd}aP,c4M$');
define('NONCE_SALT',       'Gy-@4/b<R@@)vDR$p#ItO`H^xJ:[_U8L6YX~NPYQ22R&U^9qihV2XD7K>NNq+oUU');

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
