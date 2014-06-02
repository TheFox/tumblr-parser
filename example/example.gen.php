<?php

if(PHP_SAPI != 'cli') die('ERROR: You must run this script in your shell.'."\n");

require_once __DIR__.'/../bootstrap.php';

use Symfony\Component\Yaml\Yaml;

$settings = array(
	'vars' => array(
		'Title' => 'my example page',
		'CustomCSS' => 'my custom',
		'Description' => 'my description',
		'MetaDescription' => 'my meta description',
		'if:AskEnabled' => 1,
		'AskLabel' => 'my ask label',
		'lang:Newer posts' => 'Newer Posts',
		'lang:Older posts' => 'Older Posts',
		'text:Google Analytics ID' => 1234,
	),
	'posts' => array(
		array('type' => 'Text', 'Title' => 'test1', 'Permalink' => '/post/1', 'content' => 'test1.content'),
		array('type' => 'text', 'permalink' => '?type=post&index=1', 'title' => 'title_test1', 'body' => 'test1.body'),
		array('type' => 'text', 'body' => 'test2.body'),
		array('type' => 'text', 'title' => 'title_test3'),
		array('type' => 'link', 'url' => 'http://fox21.at', 'name' => 'link_name1', 'target' => 'target="_blank"', 'description' => 'this is my description'),
		array('type' => 'link', 'url' => 'http://www.fox21.at', 'name' => 'link_name2'),
		array('type' => 'link', 'url' => 'http://www.fox21.at', 'name' => 'link_name2'),
		array('type' => 'photo', 'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text', 'caption' => 'my caption text'),
		array('type' => 'photo', 'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'alt' => 'my alt text'),
	),
	'postsPerPage' => 50,
);

file_put_contents(__DIR__.'/example.settings.yml', Yaml::dump($settings));
