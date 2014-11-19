<?php

use TheFox\Tumblr\Post\AnswerPost;

class AnswerPostTest extends PHPUnit_Framework_TestCase{
	
	public function testType(){
		$post = new AnswerPost();
		$this->assertEquals('answer', $post->getType());
	}
	
	public function testSetAsker(){
		$post = new AnswerPost();
		
		$post->setAsker('asker1');
		$this->assertEquals('asker1', $post->getAsker());
	}
	
	public function testSetQuestion(){
		$post = new AnswerPost();
		
		$post->setQuestion('question1');
		$this->assertEquals('question1', $post->getQuestion());
	}
	
	public function testSetAnswer(){
		$post = new AnswerPost();
		
		$post->setAnswer('answer1');
		$this->assertEquals('answer1', $post->getAnswer());
	}
	
}
