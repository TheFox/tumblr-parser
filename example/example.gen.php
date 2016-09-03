<?php

if(PHP_SAPI != 'cli') die('ERROR: You must run this script in your shell.'."\n");

require_once __DIR__.'/../vendor/autoload.php';

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
		'lang:Asker asked' => 'User0 asked',
		'lang:Asker asked 2' => 'Asked by <a href="http://fox21.at">User0</a>',
		'text:Google Analytics ID' => 1234,
	),
	'postsPerPage' => 10,
	'posts' => array(
		array('type' => 'text', 'permalink' => '?type=post&index=1', 'date' => '1987-02-21 09:58:00', 'notes' => array('text_1', 'text2'), 'tags' => array('tag1', 'tag_2'), 'title' => 'title_test1', 'body' => 'test1.body'),
		array('type' => 'text', 'date' => '1987-02-21 09:58:00', 'body' => 'test2.body'),
		array('type' => 'text', 'date' => '1987-02-21 09:58:00', 'title' => 'title_test3'),
		array('type' => 'link', 'date' => '1987-02-21 09:58:00', 'url' => 'http://fox21.at', 'name' => 'link_name1', 'target' => 'target="_blank"', 'description' => 'this is my description'),
		array('type' => 'link', 'date' => '1987-02-21 09:58:00', 'url' => 'http://www.fox21.at', 'name' => 'link_name2'),
		array('type' => 'photo', 'date' => '1987-02-21 09:58:00', 'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text', 'caption' => 'my caption text'),
		array('type' => 'photo', 'date' => '1987-02-21 09:58:00', 'url' => 'https://farm3.staticflickr.com/2882/10004722973_1774a72748.jpg', 'alt' => 'my alt text'),
		array('type' => 'photoset', 'date' => '1987-02-21 09:58:00', 'caption' => 'my super fancy caption', 'photos' => array(array('url' => 'https://farm3.staticflickr.com/2856/9816324626_63726c6fdd.jpg', 'link' => 'https://en.wikipedia.org/wiki/Halloumi', 'alt' => 'my alt text3', 'caption' => 'my caption text3'), array('url' => 'https://farm4.staticflickr.com/3057/2494697235_7617067bca.jpg', 'alt' => 'my alt text4'),)),
		array('type' => 'quote', 'date' => '1987-02-22 10:00:00', 'notes' => array('text_1', 'text2'), 'tags' => array('tag1', 'tag_2'), 'quote' => 'I\'m gonna taste like heaven.', 'source' => 'The Sausage', 'length' => 'short'),
		array('type' => 'chat', 'date' => '1987-02-23 10:00:00', 'notes' => array('text_1', 'text2'), 'tags' => array('tag1', 'tag_2'), 'title' => 'my chat title', 'chats' => array(array('label' => 'Johnny Cash', 'line' => 'Dear God, give us Freddie Mercury back and we will send you Justin Bieber.'), array('label' => 'Freddie Mercury', 'line' => 'I will rock you.'), array('label' => 'God', 'line' => 'Mkay.'), array('label' => 'Justin Bieber', 'line' => 'Aw maaan. :('), array('label' => 'God', 'line' => 'Done.'))),
		array('type' => 'answer', 'date' => '1987-03-01 09:08:07', 'notes' => array('text_1', 'text2'), 'tags' => array('tag1', 'tag_2'), 'asker' => 'A Asker', 'question' => 'The question is what is the question?', 'answer' => 'The answer might be similar.'),
	),
	'pages' => array(
		array('url' => 'http://fox21.at', 'label' => 'FOX21.at'),
		array('url' => 'http://tools.fox21.at', 'label' => 'Tools'),
	),
);

file_put_contents(__DIR__.'/example.settings.yml', Yaml::dump($settings));

print ''.count($settings['posts']).' posts ('.$settings['postsPerPage'].'/page)'."\n";
print ''.count($settings['pages']).' pages'."\n";
