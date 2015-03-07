<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;

use TheFox\Tumblr\Element\Post\ChatBlockElement;
use TheFox\Tumblr\Element\Post\LinesBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LabelBlockElement;
use TheFox\Tumblr\Post\ChatPost;

class ChatBlockElementTest extends PHPUnit_Framework_TestCase{
	
	public function testSetElementsValues(){
		$element2 = new ChatPost();
		$element2->setTitle('chat1');
		$element2->setChats(array(
			array('name' => 'x1', 'label' => 'lab1'),
			array('name' => 'x2', 'label' => 'lab2'),
		));
		
		$element1 = new ChatBlockElement();
		$element1->setContent($element2);
		
		
		$subElement = new VariableElement();
		$subElement->setName('title');
		$element1->addChild($subElement);
		
		$subElement = new LinesBlockElement();
		
		$subsubElement = new VariableElement();
		$subsubElement->setName('label');
		$subElement->addChild($subsubElement);
		
		$subsubElement = new VariableElement();
		$subsubElement->setName('line');
		$subElement->addChild($subsubElement);
		
		$subsubElement = new VariableElement();
		$subsubElement->setName('alt');
		$subElement->addChild($subsubElement);
		
		$subsubElement = new VariableElement();
		$subsubElement->setName('name');
		$subElement->addChild($subsubElement);
		
		$subsubElement = new VariableElement();
		$subsubElement->setName('usernumber');
		$subElement->addChild($subsubElement);
		
		$subsubElement = new LabelBlockElement();
		$subElement->addChild($subsubElement);
		
		$element1->addChild($subElement);
		
		
		$element1->setElementsValues();
		
		$html = $element1->render();
		$this->assertEquals('chat1lab1oddx11lab2evenx22', $html);
	}
	
}
