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
	
}
