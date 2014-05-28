<?php

#if(PHP_SAPI == 'cli') die('ERROR: You must run this script in your browser.'."\n");

require_once __DIR__.'/../bootstrap.php';

use TheFox\Tumblr\Parser;

header('Content-type: text/plain');

$template = file_get_contents(__DIR__.'/example.tpl.html');

$parser = new Parser();
$parser->setTemplate($template);
#$parser->setTemplate('<title>{block:IndexPage}{Title}{/block:IndexPage}{block:PermalinkPage}{block:PostTitle}{PostTitle} - {/block:PostTitle}{Title}{/block:PermalinkPage}</title>');
#$parser->setTemplate('ANFANG{block:IndexPage}{Title}{/block:IndexPage}END');
#$parser->setTemplate('<title>{block:IndexPage}{Title}{block:IndexPage}test{/block:IndexPage}{/block:IndexPage}{block:PermalinkPage}{block:PostTitle}{PostTitle} - {/block:PostTitle}{Title}{/block:PermalinkPage}</title>');
#$parser->setTemplate('<title>{block:IndexPage}{Title}{block:IndexPage}test{/block:IndexPage}abc{/block:IndexPage}</title>{TESTER}hallo');
#$parser->setTemplate('{block:IfMetaLinkPublisherURL}href=<{text:MetaLink Publisher URL}>,{/block:IfMetaLinkPublisherURL},{block:IndexPage}test{/block:IndexPage}END');
$parser->setTemplate('A { das ist ein test } END');
#$parser->setTemplate('A { das ist ein test END');
$parser->loadSettingsFromFile(__DIR__.'/example.settings.yml');

$parser->printHtml();
#$parser->printHtml('page', 1);
#$parser->printHtml('page', 2);
