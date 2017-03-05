<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Post\TextPost;

class TextBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testSetElementsValues(){
		$element2 = new TextPost();
		$element2->setBody('body1');
		
		$element1 = new TextBlockElement();
		$element1->setContent($element2);
		
		$subElement = new VariableElement();
		$subElement->setName('title');
		$element1->addChild($subElement);
		
		$subElement = new VariableElement();
		$subElement->setName('body');
		$element1->addChild($subElement);
		
		$subElement = new TitleBlockElement();
		$element1->addChild($subElement);
		
		$html = $element1->render();
		$this->assertEquals('body1', $html);
	}
	
}
