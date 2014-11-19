<?php

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

class PostsBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testRender(){
		$dt = new DateTime('2014-11-19 19:16:38');
		
		$posts = array();
		
		$post = new TextPost();
		$post->setPermalink('url1');
		$post->setIsPermalinkPage(true);
		$post->setDateTime($dt);
		$post->setNotes(array('node1', 'node2'));
		$post->setTags(array('tag1', 'tag2'));
		$post->setPostId(1);
		$post->setTitle('text1.title');
		$post->setBody('text1.body');
		$posts[] = $post;
		
		$post = new LinkPost();
		$post->setPermalink('url2');
		$post->setDateTime($dt);
		$post->setNotes(array());
		$post->setTags(array());
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
		$post->setNotes(array());
		$post->setTags(array());
		$post->setPostId(3);
		$post->setTitle('text3.title');
		$posts[] = $post;
		
		$post = new PhotosetPost();
		$post->setPermalink('url4');
		$post->setDateTime($dt);
		$post->setNotes(array());
		$post->setTags(array());
		$post->setPostId(4);
		$post->setTitle('text4.title');
		$posts[] = $post;
		
		$post = new QuotePost();
		$post->setPermalink('url5');
		$post->setDateTime($dt);
		$post->setNotes(array());
		$post->setTags(array());
		$post->setPostId(5);
		$post->setTitle('text5.title');
		$posts[] = $post;
		
		$post = new ChatPost();
		$post->setPermalink('url6');
		$post->setDateTime($dt);
		$post->setNotes(array());
		$post->setTags(array());
		$post->setPostId(6);
		$post->setTitle('text6.title');
		$posts[] = $post;
		
		$post = new AnswerPost();
		$post->setPermalink('url7');
		$post->setDateTime($dt);
		$post->setNotes(array());
		$post->setTags(array());
		$post->setPostId(7);
		$post->setTitle('text7.title');
		$posts[] = $post;
		
		
		
		$blocks = array();
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
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('dayofmonth');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('dayofmonthwithzero');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('dayofweek');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('shortdayofweek');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('dayofweeknumber');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('dayofmonthsuffix');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('dayofyear');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('weekofyear');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('month');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('shortmonth');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('monthnumber');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('monthnumberwithzero');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('year');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('shortyear');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('ampm');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('capitalampm');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('12hour');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('24hour');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('12hourwithzero');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('24hourwithzero');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('minutes');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('seconds');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('timestamp');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('postid');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('likebutton');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('reblogbutton');
		#$blocks[] = $varElement;
		
		$varElement = new VariableElement();
		$varElement->setName('postnotes');
		#$blocks[] = $varElement;
		
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
		$this->assertEquals('', $html);
	}
	
}
