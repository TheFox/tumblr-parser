<?php

namespace TheFox\Test;

use DateTime;
use DateTimeZone;
use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Element\PostsBlockElement;
use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Element\Post\QuoteBlockElement;
use TheFox\Tumblr\Element\Post\ChatBlockElement;
use TheFox\Tumblr\Element\Post\AnswerBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\DateBlockElement;
use TheFox\Tumblr\Element\PostNotesBlockElement;
use TheFox\Tumblr\Element\NoteCountBlockElement;
use TheFox\Tumblr\Element\HasTagsBlockElement;
use TheFox\Tumblr\Element\TagsBlockElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Element\HtmlElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;
use TheFox\Tumblr\Post\PhotoPost;
use TheFox\Tumblr\Post\PhotosetPost;
use TheFox\Tumblr\Post\QuotePost;
use TheFox\Tumblr\Post\ChatPost;
use TheFox\Tumblr\Post\AnswerPost;

class PostsBlockElementTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $tz = new DateTimeZone('Europe/Vienna');
        $dt = new DateTime('2014-11-19 19:16:38', $tz);

        $posts = [];

        $post = new TextPost();
        $post->setPermalink('url1');
        $post->setIsPermalinkPage(true);
        $post->setDateTime($dt);
        $post->setNotes(['node1', 'node2']);
        $post->setTags(['tag1', 'tag2']);
        $post->setPostId(1);
        $post->setTitle('text1.title');
        $post->setBody('text1.body');
        $posts[] = $post;

        $post = new LinkPost();
        $post->setPermalink('url2');
        $post->setDateTime($dt);
        $post->setNotes([]);
        $post->setTags([]);
        $post->setPostId(2);
        $post->setTitle('text2.title');
        $post->setUrl('text2.url');
        $post->setName('text2.name');
        $post->setTarget('text2.target');
        $post->setDescription('text2.descr');
        $posts[] = $post;

        $post = new PhotoPost();
        $post->setPermalink('url3');
        $post->setDateTime($dt);
        $post->setNotes([]);
        $post->setTags([]);
        $post->setPostId(3);
        $post->setTitle('text3.title');
        $posts[] = $post;

        $post = new PhotosetPost();
        $post->setPermalink('url4');
        $post->setDateTime($dt);
        $post->setNotes([]);
        $post->setTags([]);
        $post->setPostId(4);
        $post->setTitle('text4.title');
        $posts[] = $post;

        $post = new QuotePost();
        $post->setPermalink('url5');
        $post->setDateTime($dt);
        $post->setNotes([]);
        $post->setTags([]);
        $post->setPostId(5);
        $post->setTitle('text5.title');
        $posts[] = $post;

        $post = new ChatPost();
        $post->setPermalink('url6');
        $post->setDateTime($dt);
        $post->setNotes([]);
        $post->setTags([]);
        $post->setPostId(6);
        $post->setTitle('text6.title');
        $posts[] = $post;

        $post = new AnswerPost();
        $post->setPermalink('url7');
        $post->setDateTime($dt);
        $post->setNotes([]);
        $post->setTags([]);
        $post->setPostId(7);
        $post->setTitle('text7.title');
        $posts[] = $post;


        $blocks = [];
        $blocks[] = new TextBlockElement();
        $blocks[] = new LinkBlockElement();
        $blocks[] = new PhotoBlockElement();
        $blocks[] = new PhotosetBlockElement();
        $blocks[] = new QuoteBlockElement();
        $blocks[] = new ChatBlockElement();
        $blocks[] = new AnswerBlockElement();

        $blocks[] = new DateBlockElement();
        $blocks[] = new PostNotesBlockElement();
        $blocks[] = new NoteCountBlockElement();
        $blocks[] = new HasTagsBlockElement();
        $blocks[] = new TagsBlockElement();
        $blocks[] = new TitleBlockElement();
        $blocks[] = new HtmlElement();
        $blocks[] = new IndexPageBlockElement();
        $blocks[] = new PermalinkPageBlockElement();


        $varElement = new VariableElement();
        $varElement->setName('permalink');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('dayofmonth');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('dayofmonthwithzero');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('dayofweek');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('shortdayofweek');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('dayofweeknumber');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('dayofmonthsuffix');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('dayofyear');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('weekofyear');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('month');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('shortmonth');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('monthnumber');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('monthnumberwithzero');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('year');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('shortyear');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('ampm');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('capitalampm');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('12hour');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('24hour');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('12hourwithzero');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('24hourwithzero');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('minutes');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('seconds');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('timestamp');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('postid');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('likebutton');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('reblogbutton');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('postnotes');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('notecount');
        $blocks[] = $varElement;

        $varElement = new VariableElement();
        $varElement->setName('notecountwithlabel');
        $blocks[] = $varElement;


        $element1 = new PostsBlockElement();
        $element1->setContent($posts);
        $element1->setChildren($blocks);

        $html = $element1->render();

        $expected = '';
        $expected .= 'url11919WednesdayWed3th32247NovemberNov1111201414pmPM7190719163814164209981<div ';
        $expected .= 'class="like_button" data-post-id="1" id="like_button_1"><iframe id="like_iframe_';
        $expected .= '1" src="http://assets.tumblr.com/assets/html/like_iframe.html?_v=2#name=thefox21';
        $expected .= '&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="20" frameborder="0';
        $expected .= '" class="like_toggle" allowTransparency="true"></iframe></div><a href="" class="';
        $expected .= 'reblog_button"style="display: block;width:20px;height:20px;"><svg width="100%" h';
        $expected .= 'eight="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" xmlns:xlink=';
        $expected .= '"http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.01092527,5.99908429 L16.0';
        $expected .= '088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L16.1360004,3.011108';
        $expected .= '45 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3.44726568 0.979248';
        $expected .= '041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 L3.98376463,6.8980';
        $expected .= '1007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.99908429 Z"></pat';
        $expected .= 'h><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.022957,14.0490723 16';
        $expected .= '.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,15.806 L4.92919922';
        $expected .= ',20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.5640928,16.9990234';
        $expected .= ' 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.5324707 L17.142,12.20';
        $expected .= '3"></path></svg></a><ol class="notes"><!-- START NOTES --><li class="note reblog';
        $expected .= ' tumblelog_thefox21 original_post without_commentary"><a rel="nofollow" class="a';
        $expected .= 'vatar_frame" target="_blank" href="http://blog.fox21.at/" title="thefox21"><img ';
        $expected .= 'src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " alt=';
        $expected .= '"" /></a><span class="action" data-post-url="http://blog.fox21.at/post/138351482';
        $expected .= '95/hello-world">node1<div class="clear"></div></li><li class="note reblog tumble';
        $expected .= 'log_thefox21 original_post without_commentary"><a rel="nofollow" class="avatar_f';
        $expected .= 'rame" target="_blank" href="http://blog.fox21.at/" title="thefox21"><img src="ht';
        $expected .= 'tp://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " alt="" /></';
        $expected .= 'a><span class="action" data-post-url="http://blog.fox21.at/post/13835148295/hell';
        $expected .= 'o-world">node2</span><div class="clear"></div></li><!-- END NOTES --></ol>22 not';
        $expected .= 'esurl21919WednesdayWed3th32247NovemberNov1111201414pmPM7190719163814164209982<di';
        $expected .= 'v class="like_button" data-post-id="1" id="like_button_1"><iframe id="like_ifram';
        $expected .= 'e_1" src="http://assets.tumblr.com/assets/html/like_iframe.html?_v=2#name=thefox';
        $expected .= '21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="20" frameborder=';
        $expected .= '"0" class="like_toggle" allowTransparency="true"></iframe></div><a href="" class';
        $expected .= '="reblog_button"style="display: block;width:20px;height:20px;"><svg width="100%"';
        $expected .= ' height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" xmlns:xlin';
        $expected .= 'k="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.01092527,5.99908429 L16';
        $expected .= '.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L16.1360004,3.0111';
        $expected .= '0845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3.44726568 0.9792';
        $expected .= '48041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 L3.98376463,6.89';
        $expected .= '801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.99908429 Z"></p';
        $expected .= 'ath><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.022957,14.0490723 ';
        $expected .= '16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,15.806 L4.929199';
        $expected .= '22,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.5640928,16.99902';
        $expected .= '34 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.5324707 L17.142,12.';
        $expected .= '203"></path></svg></a><ol class="notes"><!-- START NOTES --><li class="note rebl';
        $expected .= 'og tumblelog_thefox21 original_post without_commentary"><a rel="nofollow" class=';
        $expected .= '"avatar_frame" target="_blank" href="http://blog.fox21.at/" title="thefox21"><im';
        $expected .= 'g src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " al';
        $expected .= 't="" /></a><span class="action" data-post-url="http://blog.fox21.at/post/1383514';
        $expected .= '8295/hello-world"></span><div class="clear"></div></li><!-- END NOTES --></ol>20';
        $expected .= ' notesurl31919WednesdayWed3th32247NovemberNov1111201414pmPM719071916381416420998';
        $expected .= '3<div class="like_button" data-post-id="1" id="like_button_1"><iframe id="like_i';
        $expected .= 'frame_1" src="http://assets.tumblr.com/assets/html/like_iframe.html?_v=2#name=th';
        $expected .= 'efox21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="20" framebor';
        $expected .= 'der="0" class="like_toggle" allowTransparency="true"></iframe></div><a href="" c';
        $expected .= 'lass="reblog_button"style="display: block;width:20px;height:20px;"><svg width="1';
        $expected .= '00%" height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" xmlns:';
        $expected .= 'xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.01092527,5.99908429';
        $expected .= ' L16.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L16.1360004,3.';
        $expected .= '01110845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3.44726568 0.';
        $expected .= '979248041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 L3.98376463,';
        $expected .= '6.89801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.99908429 Z"';
        $expected .= '></path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.022957,14.0490';
        $expected .= '723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,15.806 L4.92';
        $expected .= '919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.5640928,16.9';
        $expected .= '990234 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.5324707 L17.142';
        $expected .= ',12.203"></path></svg></a><ol class="notes"><!-- START NOTES --><li class="note ';
        $expected .= 'reblog tumblelog_thefox21 original_post without_commentary"><a rel="nofollow" cl';
        $expected .= 'ass="avatar_frame" target="_blank" href="http://blog.fox21.at/" title="thefox21"';
        $expected .= '><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar ';
        $expected .= '" alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/post/138';
        $expected .= '35148295/hello-world"></span><div class="clear"></div></li><!-- END NOTES --></o';
        $expected .= 'l>20 notesurl41919WednesdayWed3th32247NovemberNov1111201414pmPM71907191638141642';
        $expected .= '09984<div class="like_button" data-post-id="1" id="like_button_1"><iframe id="li';
        $expected .= 'ke_iframe_1" src="http://assets.tumblr.com/assets/html/like_iframe.html?_v=2#nam';
        $expected .= 'e=thefox21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="20" fram';
        $expected .= 'eborder="0" class="like_toggle" allowTransparency="true"></iframe></div><a href=';
        $expected .= '"" class="reblog_button"style="display: block;width:20px;height:20px;"><svg widt';
        $expected .= 'h="100%" height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" xm';
        $expected .= 'lns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.01092527,5.9990';
        $expected .= '8429 L16.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L16.136000';
        $expected .= '4,3.01110845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3.4472656';
        $expected .= '8 0.979248041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 L3.98376';
        $expected .= '463,6.89801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.9990842';
        $expected .= '9 Z"></path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.022957,14.';
        $expected .= '0490723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,15.806 L';
        $expected .= '4.92919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.5640928,';
        $expected .= '16.9990234 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.5324707 L17';
        $expected .= '.142,12.203"></path></svg></a><ol class="notes"><!-- START NOTES --><li class="n';
        $expected .= 'ote reblog tumblelog_thefox21 original_post without_commentary"><a rel="nofollow';
        $expected .= '" class="avatar_frame" target="_blank" href="http://blog.fox21.at/" title="thefo';
        $expected .= 'x21"><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="ava';
        $expected .= 'tar " alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/post';
        $expected .= '/13835148295/hello-world"></span><div class="clear"></div></li><!-- END NOTES --';
        $expected .= '></ol>20 notesurl51919WednesdayWed3th32247NovemberNov1111201414pmPM7190719163814';
        $expected .= '164209985<div class="like_button" data-post-id="1" id="like_button_1"><iframe id';
        $expected .= '="like_iframe_1" src="http://assets.tumblr.com/assets/html/like_iframe.html?_v=2';
        $expected .= '#name=thefox21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="20" ';
        $expected .= 'frameborder="0" class="like_toggle" allowTransparency="true"></iframe></div><a h';
        $expected .= 'ref="" class="reblog_button"style="display: block;width:20px;height:20px;"><svg ';
        $expected .= 'width="100%" height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg';
        $expected .= '" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.01092527,5.';
        $expected .= '99908429 L16.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L16.13';
        $expected .= '60004,3.01110845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3.447';
        $expected .= '26568 0.979248041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 L3.9';
        $expected .= '8376463,6.89801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.999';
        $expected .= '08429 Z"></path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.022957';
        $expected .= ',14.0490723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,15.8';
        $expected .= '06 L4.92919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.5640';
        $expected .= '928,16.9990234 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.5324707';
        $expected .= ' L17.142,12.203"></path></svg></a><ol class="notes"><!-- START NOTES --><li clas';
        $expected .= 's="note reblog tumblelog_thefox21 original_post without_commentary"><a rel="nofo';
        $expected .= 'llow" class="avatar_frame" target="_blank" href="http://blog.fox21.at/" title="t';
        $expected .= 'hefox21"><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class=';
        $expected .= '"avatar " alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/';
        $expected .= 'post/13835148295/hello-world"></span><div class="clear"></div></li><!-- END NOTE';
        $expected .= 'S --></ol>20 notesurl61919WednesdayWed3th32247NovemberNov1111201414pmPM719071916';
        $expected .= '3814164209986<div class="like_button" data-post-id="1" id="like_button_1"><ifram';
        $expected .= 'e id="like_iframe_1" src="http://assets.tumblr.com/assets/html/like_iframe.html?';
        $expected .= '_v=2#name=thefox21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="';
        $expected .= '20" frameborder="0" class="like_toggle" allowTransparency="true"></iframe></div>';
        $expected .= '<a href="" class="reblog_button"style="display: block;width:20px;height:20px;"><';
        $expected .= 'svg width="100%" height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000';
        $expected .= '/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.0109252';
        $expected .= '7,5.99908429 L16.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L1';
        $expected .= '6.1360004,3.01110845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3';
        $expected .= '.44726568 0.979248041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 ';
        $expected .= 'L3.98376463,6.89801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5';
        $expected .= '.99908429 Z"></path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.02';
        $expected .= '2957,14.0490723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,';
        $expected .= '15.806 L4.92919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.';
        $expected .= '5640928,16.9990234 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.532';
        $expected .= '4707 L17.142,12.203"></path></svg></a><ol class="notes"><!-- START NOTES --><li ';
        $expected .= 'class="note reblog tumblelog_thefox21 original_post without_commentary"><a rel="';
        $expected .= 'nofollow" class="avatar_frame" target="_blank" href="http://blog.fox21.at/" titl';
        $expected .= 'e="thefox21"><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" cl';
        $expected .= 'ass="avatar " alt="" /></a><span class="action" data-post-url="http://blog.fox21';
        $expected .= '.at/post/13835148295/hello-world"></span><div class="clear"></div></li><!-- END ';
        $expected .= 'NOTES --></ol>20 notesurl71919WednesdayWed3th32247NovemberNov1111201414pmPM71907';
        $expected .= '19163814164209987<div class="like_button" data-post-id="1" id="like_button_1"><i';
        $expected .= 'frame id="like_iframe_1" src="http://assets.tumblr.com/assets/html/like_iframe.h';
        $expected .= 'tml?_v=2#name=thefox21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" heig';
        $expected .= 'ht="20" frameborder="0" class="like_toggle" allowTransparency="true"></iframe></';
        $expected .= 'div><a href="" class="reblog_button"style="display: block;width:20px;height:20px';
        $expected .= ';"><svg width="100%" height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/';
        $expected .= '2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.010';
        $expected .= '92527,5.99908429 L16.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.08';
        $expected .= '3 L16.1360004,3.01110845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.9792480';
        $expected .= '41,3.44726568 0.979248041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993';
        $expected .= '634 L3.98376463,6.89801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.010925';
        $expected .= '27,5.99908429 Z"></path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 1';
        $expected .= '7.022957,14.0490723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L';
        $expected .= '0.5,15.806 L4.92919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 ';
        $expected .= 'C19.5640928,16.9990234 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9';
        $expected .= '.5324707 L17.142,12.203"></path></svg></a><ol class="notes"><!-- START NOTES -->';
        $expected .= '<li class="note reblog tumblelog_thefox21 original_post without_commentary"><a r';
        $expected .= 'el="nofollow" class="avatar_frame" target="_blank" href="http://blog.fox21.at/" ';
        $expected .= 'title="thefox21"><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png';
        $expected .= '" class="avatar " alt="" /></a><span class="action" data-post-url="http://blog.f';
        $expected .= 'ox21.at/post/13835148295/hello-world"></span><div class="clear"></div></li><!-- ';
        $expected .= 'END NOTES --></ol>20 notes';


        $this->assertEquals($expected, $html);
    }
}
