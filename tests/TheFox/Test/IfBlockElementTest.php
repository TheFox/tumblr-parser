<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;

use TheFox\Tumblr\Element\IfBlockElement;

class IfBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testGetTemplateName(){
		$element = new IfBlockElement();
		$element->setName('name1');
		
		$this->assertEquals('Ifname1', $element->getTemplateName());
	}
	
}
