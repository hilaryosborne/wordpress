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
