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
define( 'DB_NAME', 'spiretest' );

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
define( 'AUTH_KEY',         '@IxW1qsb#=)Wn.QnMa^CD*4(uK=j}M|}[Pw9W{r]3A<$4A3rQ]$3%c/T3XH>>YGw' );
define( 'SECURE_AUTH_KEY',  'qZVC@Q];c!_);Rg6%Be$yIY&iXXq6:LSN-Qg[I%.C-{|}e?oe_pZffEerb2B+q;9' );
define( 'LOGGED_IN_KEY',    'AZ!Idl H#hrMje/we74DYS.B?=K1 )n8n2}2 h}@$K)fd$IX.1e)#`<bcRNkY,b~' );
define( 'NONCE_KEY',        '.tgF*c#MNVc.Gou+}O40m]3?~x4l[ ?;[f}2|$@.-qiyA`~ qE|AJ|UW*0H/j6SL' );
define( 'AUTH_SALT',        'OiTo@|q3N.1*I}pJNP77GUq{1mJW,z]>>! 9c/?xCij!Q5i$ Nuoq2/AQ~fys({}' );
define( 'SECURE_AUTH_SALT', 'mbpNbmWZFQmyezt8Dt9}QQw+Jsx_urMnNi?}EO!cW4>1iVzv3WYA{l9uC|+T<tBd' );
define( 'LOGGED_IN_SALT',   'sM3a7x;Mj uoVlO:O[G&MBeMYsDmB065@-~>P$xpEJRI]@JOm[B=WxLK|U^aa6M<' );
define( 'NONCE_SALT',       ' zY#<Xp1s9ujKK@78xJo`k<j#4aC4fq;O^[BJhBBwg^g7!i&_JX`d&1lGqQD:c=!' );

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
