<?php

use TheFox\Tumblr\Variable;

class VariableTest extends PHPUnit_Framework_TestCase{
	
	public function testSetId(){
		$variable = new Variable();
		
		$variable->setId(1);
		$this->assertEquals(1, $variable->getId());
	}
	
	public function testGetType(){
		$variable = new Variable();
		
		$this->assertEquals('', $variable->getType());
	}
	
	public function testSetName1(){
		$variable = new Variable();
		
		$variable->setName('test1');
		$this->assertEquals('test1', $variable->getName());
		$this->assertEquals('Iftest1', $variable->getIfName());
		$this->assertEquals('IfNottest1', $variable->getIfNotName());
	}
	
	public function testSetName2(){
		$variable = new Variable();
		
		$variable->setName('if:test2');
		$this->assertEquals('if:test2', $variable->getName());
		$this->assertEquals('Iftest2', $variable->getIfName());
		$this->assertEquals('IfNottest2', $variable->getIfNotName());
	}
	
	public function testSetName3(){
		$variable = new Variable();
		
		$variable->setName('text:test3');
		$this->assertEquals('text:test3', $variable->getName());
		$this->assertEquals('Iftest3', $variable->getIfName());
		$this->assertEquals('IfNottest3', $variable->getIfNotName());
	}
	
	public function testGetTemplateName(){
		$variable = new Variable();
		
		$this->assertEquals('', $variable->getTemplateName());
	}
	
	public function testSetValue1(){
		$variable = new Variable();
		
		$variable->setValue('val1');
		$this->assertEquals('val1', $variable->getValue());
	}
	
	public function testSetValue2(){
		$variable = new Variable();
		
		$variable->setValue(true);
		$this->assertEquals(true, $variable->getValue());
	}
	
	public function testSetReference(){
		$variable = new Variable();
		
		$variable->setReference('ref1');
		$this->assertEquals('ref1', $variable->getReference());
	}
	
}
