<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^P?H^w2,WI{F2Jpt|S_+j0/A!NOF/}kQadfJlfc^w0dK&a_Yg*C6c+1kc5R<lCVm' );
define( 'SECURE_AUTH_KEY',  ' (!U:S$le&>@,)diY*nr<Xj($Ms3Drrl|[Z:Q:4&U6K#9^[Si1Sx 55`uqc<<[oT' );
define( 'LOGGED_IN_KEY',    'BoIx#U ipYJ lWU77w%;t*jviV<{:Zxzn]jub<R[/1},jTbN,E]V!|#-F_H{#3u<' );
define( 'NONCE_KEY',        '<]CW1S6]ft(wSNLQOF~M;fvo6g?Jj/wIaT!MORig89YXA2)IRt8Vuq6ZYK~DqK_x' );
define( 'AUTH_SALT',        'F3e0A(,x93CSFQa5ki(x08O(-Uil/0~<j;hJGvJ17vq95g}$ ]i7};&VDw43/02r' );
define( 'SECURE_AUTH_SALT', ')=qG:Y9+y&d(3s`zGU+G3!Vcrc&76G $/H(Bu_@s(4l|l/kVd3K6PKyv_j3//&p;' );
define( 'LOGGED_IN_SALT',   'w2,:bu<i}aueiyHKEy_!2nG8LQm,XPQb2b?b-tn7-A.yMhF{98l|?7kkc:uH,>c+' );
define( 'NONCE_SALT',       'Z<!giOKRVz>lbuY>PxFS_9(y.CCz3|bBC9^Gy(cb1.b>@$Rfm+|oD!LuBamJ*R0G' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
