<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;

use TheFox\Tumblr\Element\BoolBlockElement;
use TheFox\Tumblr\Element\HtmlElement;

class BoolBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testGetDefaultContent(){
		$element = new BoolBlockElement();
		
		$this->assertFalse($element->getDefaultContent());
	}
	
	public function testRender1(){
		$element = new BoolBlockElement();
		
		$html = $element->render();
		$this->assertEquals('', $html);
	}
	
	public function testRender2(){
		$element = new BoolBlockElement();
		$element->setContent(false);
		
		$html = $element->render();
		$this->assertEquals('', $html);
	}
	
	public function testRender3(){
		$element1 = new BoolBlockElement();
		$element1->setContent(true);
		
		$element2 = new HtmlElement();
		$element2->setContent('cont2');
		$element1->addChild($element2);
		
		$html = $element1->render();
		$this->assertEquals('cont2', $html);
	}
	
}
