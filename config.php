<?php

/*----------------------------------------------------*/
// Directory separator
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);
/*----------------------------------------------------*/

$env = parse_ini_file(__DIR__.'/.env', TRUE);

foreach ($env as $k => $value) {
	if (getenv($k)) { continue; }
	putenv("$k=$value");
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_HOST'));

define('WP_HOME', getenv('WP_HOME'));

define('WP_SITEURL', getenv('WP_SITEURL'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '%}O%wv4ZUahcG1j4AK%mLj0X&!B=m8IGxee_iy(RV ==[i#`bOs{&-&vYTC&zFVz');
define('SECURE_AUTH_KEY',  'vHb@&>K)AS]FZgwz2l1Qpn{GE5j{BaeoG%vFof:5c(t^B$STFYke4Iu[0W>G,y.V');
define('LOGGED_IN_KEY',    ';qHK}U9U;`}?eFQe>7FTdP///k5f4*ky~gaJ}NL`EJf$Oh[-iS@6}OyS0:?S1Y$o');
define('NONCE_KEY',        'h;C3h{5t~>t)JNpXJet{[n.4t<j6vME/vNXFB*t>E[+5+:==B8t}v)l*We)ar9QB');
define('AUTH_SALT',        '.j,8:1VDLP|*ylQ@@Xf*=hETY(XtxyJsq`R4s/F=T,^`,CjQ^H/Z(;$?W)>,_E@o');
define('SECURE_AUTH_SALT', 's&:xfsaj_(404;PdgA%fsgx7F-g{c.@d4kR_w9!u]K7tiWMymYE-a=B@{|J(FT8Z');
define('LOGGED_IN_SALT',   '5Y|!HQE4iNjQ{F]/Y@,%O1JUv90lPzox%r?f~ZSNI.g-x,7eEPfhtt`KM*Z{. >g');
define('NONCE_SALT',       '@|G]H)xD{AFu2rOI4@mQI)mrEWU/uQ(H*z8R]lx#Q.aF$SWwS8%9l.,V Bu^Y|@t');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = getenv('WP_PREFIX');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', getenv('WP_DEBUG'));

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

// HTTPS setup
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS']='on';
}
