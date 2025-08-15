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
define( 'AUTH_KEY',         'l@VIUJ$S{Jb4#]n[c{w1De#iyR%Pv|};?Q% Ihs;qv}8WDQ8j)X{b{6d0.]]Uj-%' );
define( 'SECURE_AUTH_KEY',  'qz)F5i#6au)Q*J?h%8J_/ Px-*9__vv@;D9<R6!ZksEc[yTeuq428Z2lH;CpwB >' );
define( 'LOGGED_IN_KEY',    '4vYI(oc@Z{3v&a$.^D&?i]W}n(#3AVZ@oYr0[19b^HFPTvjVVCa&(EHe$#~5ER,f' );
define( 'NONCE_KEY',        'oAg0YIV,hZm>y`$6EhR-aDZ_Ce5m/?yK*`*Ylh1.@_o{W(/1<p&%TQa*VqUIg #w' );
define( 'AUTH_SALT',        'NKjkL`EXLnK$FEiabJ)UqyIz-a~4}*<8a6@Q%RW8@ah&EHTsg[*T3K~z9i)*Zn%6' );
define( 'SECURE_AUTH_SALT', '7atUjUc[Bro%~p65LVs7.R|%F[fSlZ7/P@EC^H>]/0y]P6gLMCS_z74cuBIc$v^m' );
define( 'LOGGED_IN_SALT',   '2&^eHV!|pZ22}+pH&biGkvCaAW?q6IPE?PN+l>g*|feBEX5=vdJ[.@r[v3D06hkN' );
define( 'NONCE_SALT',       'S%:]vqBw?(nNz=uN?Of&4[OV)*kt3C!]>HyNYj5F7p+wZ,OiI%{og04Xj=v(hP)M' );

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
