<?php

use TheFox\Tumblr\Parser;

class ParserTest extends PHPUnit_Framework_TestCase{
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 1
	 */
	public function testSetSettings1(){
		$parser = new Parser();
		$parser->setSettings(array());
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 1
	 */
	public function testSetSettings2(){
		$parser = new Parser();
		$parser->setSettings(array('vars'));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 2
	 */
	public function testSetSettings3(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array()));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 2
	 */
	public function testSetSettings4(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts'));
	}
	
	/**
	 * @expectedException RuntimeException
	 * @expectedExceptionCode 3
	 */
	public function testSetSettings5(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array(), 'posts' => array()));
	}
	
	public function testParseVariable(){
		$parser = new Parser();
		$parser->setSettings(array('vars' => array('Title' => 'my_title'), 'posts' => array(), 'postsPerPage' => 15));
		
		$parser->setTemplate('');
		$this->assertEquals('', $parser->parse());
		
		$parser->setTemplate('test');
		$this->assertEquals('test', $parser->parse());
		
		$parser->setTemplate('{Title}>');
		$this->assertEquals('my_title>', $parser->parse());
		
		$parser->setTemplate('<{Title}');
		$this->assertEquals('<my_title', $parser->parse());
		
		$parser->setTemplate('<{Title}>');
		$this->assertEquals('<my_title>', $parser->parse());
		
		$parser->setTemplate('BEGIN<{Title}>END');
		$this->assertEquals('BEGIN<my_title>END', $parser->parse());
		
		$parser->setTemplate('BEGIN Title1={Title} Title2={Title} END');
		$this->assertEquals('BEGIN Title1=my_title Title2=my_title END', $parser->parse());
	}
	
}
