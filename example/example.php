<?php

#if(PHP_SAPI == 'cli') die('ERROR: You must run this script in your browser.'."\n");

require_once __DIR__.'/../vendor/autoload.php';

use TheFox\Tumblr\Parser;

#header('Content-type: text/plain');

$type = 'page';
if(isset($_GET['type'])){
	$type = $_GET['type'];
}

$id = 1;
if(isset($_GET['id'])){
	$id = $_GET['id'];
}

$template = file_get_contents(__DIR__.'/example.tpl.html');

$parser = new Parser();
$parser->setTemplate($template);
$parser->loadSettingsFromFile(__DIR__.'/example.settings.yml');


if(PHP_SAPI == 'cli'){
	$type = 'post'; $id = 1;
}

try{
	$html = $parser->parse($type, $id);
	#print "\n'".$html."'\n";
	if(PHP_SAPI == 'cli'){
	}
	else{
		print $html."\n";
	}
}
catch(Exception $e){
	print 'ERROR: '.$e->getMessage()."\n";
	exit(1);
}
