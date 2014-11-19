<?php

error_reporting(E_ALL | E_STRICT);

if(@date_default_timezone_get() == 'UTC') date_default_timezone_set('UTC');

ini_set('display_errors', true);
ini_set('memory_limit', '128M');

define('STDOUT', fopen('php://output', 'w'), true);

chdir(__DIR__);

if(getenv('TEST')){
	define('TEST', true, true);
}
else{
	define('TEST', false, true);
}


if(version_compare(PHP_VERSION, '5.3.0', '<')){
	print 'FATAL ERROR: you need at least PHP 5.3. Your version: '.PHP_VERSION."\n";
	exit(1);
}

# TODO: use DIRECTORY_SEPARATOR
if(!file_exists(__DIR__.'/vendor')){
	print "FATAL ERROR: you must first run 'composer install'.\nVisit https://getcomposer.org\n";
	exit(1);
}

require_once __DIR__.'/vendor/autoload.php';
