<?php

namespace TheFox\Tumblr\Post;

class Post{
	
	protected $type = '';
	#protected $elementClassName = '';
	private $title = '';
	
	public function __construct(){
		
	}
	
	public function getType(){
		return $this->type;
	}
	
	#public function getElementClassName(){
	#	return $this->elementClassName;
	#}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
}
