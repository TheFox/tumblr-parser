<?php

namespace TheFox\Tumblr\Post;

class TextPost extends Post{
	
	#private $title = '';
	private $body = '';
	
	public function __construct(){
		$this->setType('text');
	}
	
	public function setBody($body){
		$this->body = $body;
	}
	
	public function getBody(){
		return $this->body;
	}
	
}
