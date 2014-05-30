<?php

#if(PHP_SAPI == 'cli') die('ERROR: You must run this script in your browser.'."\n");

require_once __DIR__.'/../bootstrap.php';

use TheFox\Tumblr\Parser;

#header('Content-type: text/plain');

$type = 'page';
if(isset($_GET['type'])){
	$type = $_GET['type'];
}

$index = 1;
if(isset($_GET['index'])){
	$index = $_GET['index'];
}

$template = file_get_contents(__DIR__.'/example.tpl.html');

$parser = new Parser();
$parser->setTemplate($template);

$parser->loadSettingsFromFile(__DIR__.'/example.settings.yml');

$parser->setTemplate('BEGIN
{block:Posts}
	POST_BEGIN
	{block:Text}
		--Text--
		title={Title}
		{block:Title}titleblock={Title}{/block:Title}
		body={Body}
	{/block:Text}
	{block:Link}
		--Link--
		url={URL}
		target={Target}
		name={Name}
		desc={block:Description}block={Description}{/block:Description}
	{/block:Link}
	POST_END
{/block:Posts}
END');


$type = 'post'; $index = 6;
$type = 'page'; $index = 1;

$html = $parser->parse($type, $index);

#print "\n'$html'\n";

