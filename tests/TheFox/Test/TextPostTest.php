<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;

use TheFox\Tumblr\Post\TextPost;

class TextPostTest extends PHPUnit_Framework_TestCase{
	
	public function testType(){
		$post = new TextPost();
		$this->assertEquals('text', $post->getType());
	}
	
	public function testSetBody(){
		$post = new TextPost();
		
		$post->setBody('body1');
		$this->assertEquals('body1', $post->getBody());
	}
	
}
