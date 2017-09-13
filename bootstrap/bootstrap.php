<?php

// Composer autoload
/*----------------------------------------------------*/
if (!is_dir(__DIR__.DS.'vendor')) {
	throw new \Exception('No vendor folder found, please run composer');
}

if (file_exists($autoload = __DIR__.DS.'vendor'.DS.'autoload.php')) {
	require_once $autoload;
} else {
	throw new \Exception('No autoloader found, please re-run composer');
}

// OPTIONAL SENTRY SETUP
// If a sentry URL was provided then setup sentry
// Sentry is a error reporting service https://sentry.io
if (getenv('SENTRY_URL')) {
	// Create a new sentry client
	$sentry_client = new Raven_Client(getenv('SENTRY_URL'));
	// Create a new error handler
	$error_handler = new Raven_ErrorHandler($sentry_client);
	// Register the recommended handlers
	$error_handler->registerExceptionHandler();
	$error_handler->registerErrorHandler();
	$error_handler->registerShutdownFunction();
}
