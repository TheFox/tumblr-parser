<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Element\Post\PostBlockElement;

class PostBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testRender(){
		$element = new PostBlockElement();
		
		$html = $element->render();
		$this->assertEquals('', $html);
	}
	
}
