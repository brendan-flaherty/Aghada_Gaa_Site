<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/** Enable W3 Total Cache */
 //Added by WP-Cache Manager


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

# define( 'CONCATENATE_SCRIPTS', false );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('DB_NAME', 'db1412066_aghada');
 //Added by WP-Cache Manager
# define( 'WPCACHEHOME', '/var/www/vhosts/36/471885/webspace/httpdocs/aghadagaa.com/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager   Moved from shared
define( 'WPCACHEHOME', '/var/www/vhosts/aghadagaa.com/httpdocs/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager

# define('DB_NAME', 'db1412066_aghada_'); Moved from shared
define('DB_NAME', 'admin_agha');

/** MySQL database username */
//define('DB_USER', 'u1412066_aghada');
# define('DB_USER', 'u1412066_aghada_'); Moved from shared
define('DB_USER', 'uSr_AgHa');

/** MySQL database password */
//define('DB_PASSWORD', 'w+WzmG>PQ9d7Mg');
# define('DB_PASSWORD', 'HkN2ENS146a4YfI'); Moved from shared
define('DB_PASSWORD', 'n!Z2j25Yn54*');

/** MySQL hostname */
//define('DB_HOST', 'mysql2643int.cp.blacknight.com');
# define('DB_HOST', 'mysql2775int.cp.blacknight.com'); Moved from Shared
define('DB_HOST', 'localhost');


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'Aj6|G][l`1tu3h3@[na^n`B)CFz85|l3s.BOsgoOofwhk{95ZkZ0#)vLl[OZEQt/');
define('SECURE_AUTH_KEY',  'h32nsu%~xPO3y-0(])9l0zR)-}+Wc SY<Z:|dSlq!KraxFc,.Q?%+p3*1Dlz-D^J');
define('LOGGED_IN_KEY',    'i,|R(CQ|a32i$oQfoZVa|S6b[,Ftt5{e:aHw4OC[``;|c*uu8wUK&5cp{*hEgCMD');
define('NONCE_KEY',        '|liT/@ZlvhSaMB=D{%?`=bd:(=0-8t]@| #~zJK+tI5[J0^[gj+1@W k-n:GzBh1');
define('AUTH_SALT',        '3hX0C}x=@&adu25@q^tqpYE:2-`R|K3j4G|#iU>GgCJdBzE[:F)+k:jX/%x@yE4$');
define('SECURE_AUTH_SALT', 'd4+D9|D|ik(JO+-EevpXpdx>L3v_;(|B2K$_`6]TYjdLPsb=BAB!dx*~G4Ah/Xgs');
define('LOGGED_IN_SALT',   '74[DCAs&s8M83.-zrLPQ;W`hT>1O^Bifh=90mL4e|pw+!Ds*0_KN-TQq&IS*kj2r');
define('NONCE_SALT',       '&1`OlBN-UO;sGC>j#NYYeUn}o[0m-17&D@:_8>HGvF`_1;DxbW4XuPanY~DG8<;_');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
