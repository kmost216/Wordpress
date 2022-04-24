<?php
define('WP_CACHE', true); // WP-Optimize Cache
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp7491899' );
/** MySQL database username */
define( 'DB_USER', 'wpuser58843' );
/** MySQL database password */
define( 'DB_PASSWORD', '20s92GIpK6DrYXz' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '_y*/xSnNNs!d;za}GT]kr*t>+?Wvb4kh(>yvuY>oUVPn/,%ecg$wob)%?o:aA,Hj' );
define( 'SECURE_AUTH_KEY',   'S<IHOULM ;f[f4 #-VCyK=OVC;$0f3O-DnPu&KF82xfcdTr3MOpAo(MWFAGLELIo' );
define( 'LOGGED_IN_KEY',     '4?h6LEi5pw- }MsM|gnkZZsngeYW<9-xSd;0,*pCS!IEB1V)PKTcEh5yO,oYw/;9' );
define( 'NONCE_KEY',         '#V%OL(X73%G8o@Y9jwSdKTC$teSE$A5@%:rk7k3sRLLlGnNj$6j=)[}LUocB2MUI' );
define( 'AUTH_SALT',         'unNhs]k5:.w,&FTO-z&)ig n48$h#;H`Y^EKIJ+#ya)($_GtYSxm%ir=Hg[ts/7%' );
define( 'SECURE_AUTH_SALT',  'UaG>-~SIm-F7nA`Pl`QB{KVuQB559gNikNVQkb{cc.)ft&QUup/NTDF}n4#vFA!F' );
define( 'LOGGED_IN_SALT',    'q3:;tgwor527jK$kTM9uGz+G`cgyB#<hlCg+1F~Xac!h~Q12|@O<?JtLJ|>rmqGn' );
define( 'NONCE_SALT',        'Z>v@L1I4stNJ9_0o^Mv>CV6~J w N+u]OZE,X4F&K2&ez,GCEkX1AWyy,)q|RGvS' );
define( 'WP_CACHE_KEY_SALT', 'Q!f!%um[WS2{iUKyAnPxz`^k|%8($$KxGKcy8&uVwQA;[7r~-M=Bus1`%NhxW1e+' );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define( 'FORCE_SSL_ADMIN', false );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';