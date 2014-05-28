<?php

if(PHP_SAPI != 'cli') die('ERROR: You must run this script in your shell.'."\n");

require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\Yaml\Yaml;

$settings = array(
	
	'vars' => array(
		'Title' => 'my example page',
		'CustomCSS' => '<!-- my custom //-->',
		'MetaDescription' => 'my meta description',
		'if:Show Archive' => 0,
	),
	
	'posts' => array(
		array('type' => 'Text', 'Title' => 'test1', 'Permalink' => '/post/1', 'content' => 'test1.content'),
	),
	
	'postsPerPage' => 15,
);

file_put_contents(__DIR__.'/example.settings.yml', Yaml::dump($settings));
