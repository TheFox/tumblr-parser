<?php

use TheFox\Tumblr\Element\HtmlElement;

class HtmlElementTest extends PHPUnit_Framework_TestCase{
	
	public function testRender(){
		$element = new HtmlElement();
		$element->setContent('cont1');
		
		$html = $element->render();
		$this->assertEquals('cont1', $html);
	}
	
}
