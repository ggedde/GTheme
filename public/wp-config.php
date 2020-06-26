<?php
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

if (file_exists(dirname(__DIR__).'/.env')) {
	foreach(parse_ini_file(dirname(__DIR__).'/.env') as $envVarKey => $envVarValue) {
		putenv($envVarKey.'='.$envVarValue);
	}
}

define('WP_HOME', (getenv('FORCE_HTTPS') ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST']);
define('WP_SITEURL', WP_HOME);

// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_PASS'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'QWs{`%g%-.i@f);8LYSC[W$lR^w]9ht] $/JyfG=nR/!!]y(*d-126IGvfB7ATtr' );
define( 'SECURE_AUTH_KEY',   '*pM@D_lS~^1`i8-n?pQ-u~G}j3lz&/>@qhSas5ti(uEH^*$^9@=N`6=5w07&VI,!' );
define( 'LOGGED_IN_KEY',     'H0$X?r]m$2%ck;g}1?t),Udt8y+YhC#1K0UqFa6^cKFgm=~bdrL1L`ZG}>4.aEX-' );
define( 'NONCE_KEY',         'qO$dnw9[6:paCUe2l5_.iC/G:UHWsd&ed{F5{iw<u[nXC 76A#!q~b0lb$8g)V+x' );
define( 'AUTH_SALT',         '/!u:vdT~m4S^EW:Vxj+LH,+c6,?nYiswxS{F?/Z7kgE)!g[VL.Y&EWxWNg37ZxeB' );
define( 'SECURE_AUTH_SALT',  '$0?J5_SXChhR_UGWbj,-`X_woH;b)STg{=#Ud#d*lqZp^W=5e1d(+;WjXQvXr);W' );
define( 'LOGGED_IN_SALT',    'Z[YIX`yJ.E:ug7t&c%;<x8AL)R{YzF_Ynwi?t4M$k|cB2kmT|V&&V< HpycMmr=X' );
define( 'NONCE_SALT',        '[upFZS{L?_xuQKHI&.~[~1wM!Ri>0r@4,_+~P6`*W8[p(cIi=Ms =PxrGJOFy9=?' );
define( 'WP_CACHE_KEY_SALT', 'v&SPLrM6NX)ReASCDMKdI_>n,IxH2,k2(dxiz7M$H%zM]~e+h5&SU(RD2?#6!8F]' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_tst_';

define( 'WP_DEBUG', true );




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
