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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'db:3306' );

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
define('AUTH_KEY',         '(|y4h@,OU*Z^mju0ZQ- IeqDE.+OU{^$`W*w`5of~RAd%,M`@}l-<WLb~ZZsU~}<');
define('SECURE_AUTH_KEY',  'C-eqwIfI#Oy!(~5jB9j?s%0mO jR%:dq3i7BpOqViKkRiqOu:p[wt+bL Q.3aCt4');
define('LOGGED_IN_KEY',    '{=l#t|+_Y9eP_e-Q-_i0d|J$E@&6o`2%cF5C x-|+:^-/t[Da3L%(n.+|GR9+-G6');
define('NONCE_KEY',        'xO_|@$7t(rhh)1r>rx.?oCH6gML|,=7{ebunBL:Mlpp}//PbJ=Dsa!0:5)lktF4q');
define('AUTH_SALT',        'S)*jhe%$*|a.@G+A:bipQx@gB^Bqa>IQLz1p0I0[qu1qp@rVGIu)m^22HtYCd}x]');
define('SECURE_AUTH_SALT', 'e^FhJl=rk1-|X.8]A|=-9Gk1=1s-T/}[L?XznW-|Nyh<0}p*6Q:1tT}a-4MxbvVZ');
define('LOGGED_IN_SALT',   '-Ikk| isPbXtdFUyu&wL=QOCvkUqm6tZ~&[U:*p~3=[Mo{5< o!#P-|.|YHpv4.y');
define('NONCE_SALT',       '{C:K AVHdR?+`tIu|hXb-SQm&;CMr]+58}#Avbtv:k5TBA+kwSSvPP~s;y0|@^$t');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


define('WP_DEBUG', true);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
