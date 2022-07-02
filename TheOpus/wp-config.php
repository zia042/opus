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
define( 'DB_NAME', 'theopus' );

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
define( 'AUTH_KEY',         'Zm+S+[3#9FU4]M$V<AGD/d:~*<wF3Q9=N:??QyT2;<<{ajxrwR@DBaQ8E8(_=|$U' );
define( 'SECURE_AUTH_KEY',  'd2U<=mp[W[Sa.vS^s4-|Lz/?7xGX>9EbepOhg}1,c9vZ/Yi6mXjFmA!ESeD2kriY' );
define( 'LOGGED_IN_KEY',    'Z`8$*. T4`%(Bbw%C]8ye#ctZ{~j8T=5@[8P)>9b^5)BJ<+&1mV+#?n$=rUx,.r#' );
define( 'NONCE_KEY',        'u>ZM:`|-VM2BlhF`5;<HAvP=cvX|g+rR]5wHu-AWQ6USsHPyr=@]l,?FY5Y@Nn3c' );
define( 'AUTH_SALT',        '<g467%i%fggBj<*BE1G eD9y+Qr+>1:&tf*Z+r6(.c`THGlg-ZU]J{}zz,emMT2c' );
define( 'SECURE_AUTH_SALT', ',lO;K.KGHjml%f5_m> unO{6=K3W<RoDImJ.-|}yaS29ahvMk0zRnH]Ny[wDn$y~' );
define( 'LOGGED_IN_SALT',   '#f/Z47f=j{VEubVS_:.fLaWMZr0Ld4y6es8@.16nDN&OC>~,Xx*PgR*JN_2<R9nL' );
define( 'NONCE_SALT',       'B6L7OfKb At3 :@S1VD`x@2|%W4~%Mxw3!ZwE*M>{MAFI-lfztu+_$Ia!mPA&/fw' );

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
