<?php

#if(PHP_SAPI == 'cli') die('ERROR: You must run this script in your browser.'."\n");

require_once __DIR__.'/../bootstrap.php';

use TheFox\Tumblr\Parser;

header('Content-type: text/plain');

$template = file_get_contents(__DIR__.'/example.tpl.html');

$parser = new Parser();
$parser->setTemplate($template);

$parser->loadSettingsFromFile(__DIR__.'/example.settings.yml');

#$parser->setTemplate('<title>{block:IndexPage}{Title}{/block:IndexPage}{block:PermalinkPage}{block:PostTitle}{PostTitle} - {/block:PostTitle}{Title}{/block:PermalinkPage}</title>');
#$parser->setTemplate('ANFANG{block:IndexPage}{Title}{/block:IndexPage}END');
#$parser->setTemplate('<title>{block:IndexPage}{Title}{block:IndexPage}test{/block:IndexPage}{/block:IndexPage}{block:PermalinkPage}{block:PostTitle}{PostTitle} - {/block:PostTitle}{Title}{/block:PermalinkPage}</title>');
#$parser->setTemplate('<title>{block:IndexPage}{Title}{block:IndexPage}test{/block:IndexPage}abc{/block:IndexPage}</title>{TESTER}hallo');

$parser->setTemplate('BEGIN
<meta name="if:Show Archive" content="1" />
{block:IndexPage}
	IndexPage
	"{Title}"
{/block:IndexPage}
{block:PermalinkPage}
	PermalinkPage
	"{Title}""
{/block:PermalinkPage}
{block:IfShowArchive}
	IfShowArchive
	{block:PostTitle}
		PostTitle
		"{PostTitle}"
	{/block:PostTitle}
{/block:IfShowArchive}

{block:Posts}
	POST_BEGIN
	{block:Text}
		{block:Title}title={Title}{/block:Title}
		body={Body}
	{/block:Text}
	POST_END
{/block:Posts}END');
#$parser->setTemplate('BEGIN {block:Posts}POST {/block:Posts}END');


$parser->printHtml('page', 1);
#$parser->printHtml('page', 2);
#$parser->printHtml('page', 3);

#$parser->printHtml('post', 1);
#$parser->printHtml('post', 2);
