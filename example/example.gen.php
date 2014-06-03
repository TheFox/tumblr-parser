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
		array('type' => 'text', 'permalink' => '?type=post&index=1', 'date' => '1987-02-21 09:58:00', 'notes' => array('text_1', 'text2'), 'title' => 'title_test1', 'body' => 'test1.body'),
		array('type' => 'text', 'body' => 'test2.body'),
		array('type' => 'text', 'date' => '1987-02-21 09:58:00', 'title' => 'title_test3'),
		array('type' => 'link', 'date' => '1987-02-21 09:58:00', 'url' => 'http://fox21.at', 'name' => 'link_name1', 'target' => 'target="_blank"', 'description' => 'this is my description'),
		array('type' => 'link', 'date' => '1987-02-21 09:58:00', 'url' => 'http://www.fox21.at', 'name' => 'link_name2'),
		array('type' => 'photo', 'date' => '1987-02-21 09:58:00', 'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text', 'caption' => 'my caption text'),
		array('type' => 'photo', 'date' => '1987-02-21 09:58:00', 'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'alt' => 'my alt text'),
		array('type' => 'photoset', 'date' => '1987-02-21 09:58:00', 'caption' => 'my super fancy caption', 'photos' => array(array('url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text3', 'caption' => 'my caption text3'), array('url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'alt' => 'my alt text4'),)),
	),
	'postsPerPage' => 50,
);

file_put_contents(__DIR__.'/example.settings.yml', Yaml::dump($settings));
