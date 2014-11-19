<?php

use TheFox\Tumblr\Element\IfNotBlockElement;

class IfNotBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testGetTemplateName(){
		$element = new IfNotBlockElement();
		$element->setName('name1');
		
		$this->assertEquals('IfNotname1', $element->getTemplateName());
	}
	
}
