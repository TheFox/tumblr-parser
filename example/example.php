<?php

#if(PHP_SAPI == 'cli') die('ERROR: You must run this script in your browser.'."\n");

require_once __DIR__.'/../bootstrap.php';

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

/*
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
*/

#$parser->setTemplate('{block:IfAskEnabled}OK{/block:IfAskEnabled}{block:IfNotAskEnabled}NOT{/block:IfNotAskEnabled}');

if(PHP_SAPI == 'cli'){
	$type = 'post'; $id = 6;
	$type = 'post'; $id = 2;
	$type = 'post'; $id = 1;
	$type = 'post'; $id = 7;
	$type = 'page'; $id = 1;
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


