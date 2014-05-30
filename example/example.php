<?php

#if(PHP_SAPI == 'cli') die('ERROR: You must run this script in your browser.'."\n");

require_once __DIR__.'/../bootstrap.php';

use TheFox\Tumblr\Parser;

header('Content-type: text/plain');

$template = file_get_contents(__DIR__.'/example.tpl.html');

$parser = new Parser();
$parser->setTemplate($template);

$parser->loadSettingsFromFile(__DIR__.'/example.settings.yml');

$parser->printHtml();
#$parser->printHtml('page', 1);
#$parser->printHtml('page', 2);
