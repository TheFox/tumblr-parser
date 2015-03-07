<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;

use TheFox\Tumblr\Post\QuotePost;

class QuotePostTest extends PHPUnit_Framework_TestCase{
	
	public function testType(){
		$post = new QuotePost();
		$this->assertEquals('quote', $post->getType());
	}
	
	public function testSetQuote(){
		$post = new QuotePost();
		
		$post->setQuote('quote1');
		$this->assertEquals('quote1', $post->getQuote());
	}
	
	public function testSetSource(){
		$post = new QuotePost();
		
		$post->setSource('source1');
		$this->assertEquals('source1', $post->getSource());
	}
	
	public function testSetLength(){
		$post = new QuotePost();
		
		$post->setLength(24);
		$this->assertEquals(24, $post->getLength());
	}
	
}
