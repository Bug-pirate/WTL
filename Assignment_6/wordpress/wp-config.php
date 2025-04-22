<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
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
define( 'AUTH_KEY',         'A7{Kn5l)>B/+RQ6cPkPK`F: <BeJ_>e&F-nw~[6f{>D~4i=(vi7] vC4H)nwy4Ah' );
define( 'SECURE_AUTH_KEY',  '0RaIT.fnkt_F@81T(bq0V46`j==$ENl.Aoqb|Harg?i|#c&z.;:*00/KO`:h3Vi}' );
define( 'LOGGED_IN_KEY',    'Lq>qw%]IQF,1--D`jmw/g}xB`!|kj&v{qBuZ%Iife3mQhF%}?t%/BV<M(wv:QBqx' );
define( 'NONCE_KEY',        '+J^rZ<$rS(F< 4V}S8wj%Ca~6P3`]j9tmN~~yr;#SS?0uDKLnl<Uf*rXT(@8:tpw' );
define( 'AUTH_SALT',        '46=!:OBF`YI2mIX^SSl4WgTs024t0^Y|_g8.8s1vxX*PP bT/;zA9hH+L[Z<=c<z' );
define( 'SECURE_AUTH_SALT', 'B%,WFb1Kyf;#}!4AefS *R[I)Q*>E_S89ey~iHkNV@JF@{&~_tawuKz,yD/-2=j2' );
define( 'LOGGED_IN_SALT',   '=J//*=bYfw0eKrp5L<M*!;crjrp_FV[x!^j=b<4Z$~6{1*BY)y_a>$[kS7j@dq>C' );
define( 'NONCE_SALT',       '$P-Po!|46(wvUSw$po<}MYu8kTxlA=+~_}aMZ~z+-B)g9L6c51,FwIgs5.*j7.8&' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
