<?php

/*----------------------------------------------------*/
// Directory separator
/*----------------------------------------------------*/
defined('DS') ? DS : define('DS', DIRECTORY_SEPARATOR);
/*----------------------------------------------------*/

// .ENV FILE SUPPORT
// Advisable NOT to use .env files. Consider using system environment vars instead
// If the env file is currently within the public directory
if (file_exists(__DIR__.'/.env')) {
    // Throw and exception because this is really bad
    // Uncomment if you need for testing
    // ONLY DO THIS IF THE PROJECT IS NOT PUBLIC
    // $env = parse_ini_file(__DIR__ . '/.env', TRUE);
    throw new \Exception('Environment variable is public!! Please move');
} // If there is an environment variable in a safe-ish place
elseif (file_exists(__DIR__.'/../.env')) {
    // Open and parse the environment var
    $env = parse_ini_file(__DIR__ . '/../.env', TRUE);
}
// If an environment file was parsed
if (isset($env) && is_array($env)) {
    // Loop through each of the env variables
    foreach ($env as $k => $value) {
        // If the environment variable is already present
        // Skip it! This is so we don't override anything set within the OS
        if (getenv($k)) { continue; }
        // Add the environment variable to the environment
        putenv("$k=$value");
    }
}

/** Core WP URL settings */
define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

/** Mailer Setup */
define('MAIL_SMTP', getenv('MAIL_SMTP'));
define('MAIL_HOST', getenv('MAIL_HOST'));
define('MAIL_PORT', getenv('MAIL_PORT'));
define('MAIL_AUTH', getenv('MAIL_AUTH'));
define('MAIL_USERNAME', getenv('MAIL_USERNAME'));
define('MAIL_PASSWORD', getenv('MAIL_PASSWORD'));

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'GENERATE AND REPLACE ME');
define('SECURE_AUTH_KEY',  'GENERATE AND REPLACE ME');
define('LOGGED_IN_KEY',    'GENERATE AND REPLACE ME');
define('NONCE_KEY',        'GENERATE AND REPLACE ME');
define('AUTH_SALT',        'GENERATE AND REPLACE ME');
define('SECURE_AUTH_SALT', 'GENERATE AND REPLACE ME');
define('LOGGED_IN_SALT',   'GENERATE AND REPLACE ME');
define('NONCE_SALT',       'GENERATE AND REPLACE ME');

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

// HTTPS setup
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS']='on';
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
