<?php

use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\DescriptionBlockElement;
use TheFox\Tumblr\Post\LinkPost;

class LinkBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testSetElementsValues(){
		$element2 = new LinkPost();
		$element2->setUrl('url1');
		$element2->setName('name1');
		$element2->setTarget('target1');
		$element2->setDescription('descr1');
		
		$element1 = new LinkBlockElement();
		$element1->setContent($element2);
		
		$subElement = new VariableElement();
		$subElement->setName('url');
		$element1->addChild($subElement);
		
		$subElement = new VariableElement();
		$subElement->setName('name');
		$element1->addChild($subElement);
		
		$subElement = new VariableElement();
		$subElement->setName('target');
		$element1->addChild($subElement);
		
		$subElement = new VariableElement();
		$subElement->setName('description');
		$element1->addChild($subElement);
		
		$subElement = new DescriptionBlockElement();
		$element1->addChild($subElement);
		
		$html = $element1->render();
		$this->assertEquals('url1name1target1descr1', $html);
	}
	
}
