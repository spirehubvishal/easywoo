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
define( 'DB_NAME', 'easywoo' );

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
define( 'AUTH_KEY',         'bM;hfg6>5.gHrV>{FOF<%lh$Fslqa7@j#BDu*cu>[=9C%62|{7a|9)$6t))ZuNjU' );
define( 'SECURE_AUTH_KEY',  '.*HLacz%)83G(#ZYR8#^tRbs7Uj!3~-`5m{1[Iq8T>ee2|:,9T3<7,w-.v1IK`MV' );
define( 'LOGGED_IN_KEY',    'BT)*c69G7dvqhCVs5}$57YDBOrUP,~}#8iLRJmot#D@&Sp_#^kV|.%<cr?sGW)-5' );
define( 'NONCE_KEY',        'p%ta;siFFwg[:/T63j-U8$aXTb)!Awghz>-3D`~*c={MhbWI66]_ nu7UZ(~]3*9' );
define( 'AUTH_SALT',        '91v1xQK6[ZmMl5$dSwH$OoL@S]t]FX+^G*:1)QWS~ _Ub1v=_UYH?-B+1]<<+[r|' );
define( 'SECURE_AUTH_SALT', '3Akk$*)by&H*7MiLgaOkw8um9FD1~2j1d{(8-U[3NA_-]KcFj>)H<#^DO7?/YeHu' );
define( 'LOGGED_IN_SALT',   'A AjLv~WvT<E- *GO.rM;3mKZ~tkl?xflmial*Gm#Wh3Y%iB3-akfjMRh7BSH -_' );
define( 'NONCE_SALT',       'Y2k}u{T><awTlI:O:[D^TXkA@8&,ZNe*{^,83Jl.a7v/~Zf0(#{,fE9Rptj*@<7g' );

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
