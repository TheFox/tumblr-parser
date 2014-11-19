<?php

use TheFox\Tumblr\Element\PagesBlockElement;
use TheFox\Tumblr\Element\VariableElement;

class PagesBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testRender(){
		$element1 = new PagesBlockElement();
		$element1->setContent(array(
			array('label' => 'l1', 'url' => 'u1'),
			array('label' => 'l2', 'url' => 'u2'),
		));
		
		$varLabel = new VariableElement();
		$varLabel->setName('label');
		
		$varUrl = new VariableElement();
		$varUrl->setName('url');
		
		$element1->addChild($varLabel);
		$element1->addChild($varUrl);
		
		$html = $element1->render();
		$this->assertEquals('l1u1l2u2', $html);
	}
	
}
