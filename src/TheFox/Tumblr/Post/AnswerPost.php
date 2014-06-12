<?php

namespace TheFox\Tumblr\Post;

class AnswerPost extends Post{
	
	private $asker = '';
	private $question = '';
	private $answer = '';
	
	public function __construct(){
		$this->setType('answer');
	}
	
	public function setAsker($asker){
		$this->asker = $asker;
	}
	
	public function getAsker(){
		return $this->asker;
	}
	
	public function setQuestion($question){
		$this->question = $question;
	}
	
	public function getQuestion(){
		return $this->question;
	}
	
	public function setAnswer($answer){
		$this->answer = $answer;
	}
	
	public function getAnswer(){
		return $this->answer;
	}
	
}
