<?php

namespace TheFox\Tumblr\Post;

class TextPost extends Post{
	
	private $body = '';
	
	public function __construct(){
		$this->type = 'text';
		#$this->elementClassName = 'TheFox\Tumblr\Element\TextBlockElement';
	}
	
	public function setBody($body){
		$this->body = $body;
	}
	
	public function getBody(){
		return $this->body;
	}
	
}
