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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
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
define( 'AUTH_KEY',         '?U]vFT1vzt&@KjA21vyx *_,|?sFu_4&7.Doz8+S)Dq;w$y<P@Z.qYHQ&oWvY ~o' );
define( 'SECURE_AUTH_KEY',  'K-%6pbhk^4Daw-QcnH4GBley1^h:T$yBJMjjN<uXU`05p#5/NPy+<w6s^ZT}Y Z ' );
define( 'LOGGED_IN_KEY',    '}U{ddWU0sDT}yX(<bif)u?+zQ5,H}TPH)|~V;zi>*a>s&!/|:y(FFbK]6YtgXnob' );
define( 'NONCE_KEY',        ')QAFhZ^}(+rAP[4wJQvsMg_1@7 z:]WJt)+.:bJrmXmhG?P-Cb_GZsDF^`&1gFa@' );
define( 'AUTH_SALT',        'u:wpS1)fZD%|]X&+Y{S2j.Ij>Siv$5_Wye|$9n>.Sd}DjL:+W`X.gx8 YOn$TZz_' );
define( 'SECURE_AUTH_SALT', 'oJHRR,P *0gF_>k2d-[jPO^jz`?$a:W&UM@ys[&l8iy@N#RLDs_#rqt0EsZj:WBm' );
define( 'LOGGED_IN_SALT',   'swvOMk#T<*-95B/0JLU-u,cBamX:}jFGUeh-[.>Xr]/6EtjmQbfm[[j~l7ax^k>m' );
define( 'NONCE_SALT',       'S~zD95=&>|}&IcOoX`o[}~& KQ}t6@jsAi_^gdphVJo_bUU`l4%[X|IeK~j%W$0.' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
