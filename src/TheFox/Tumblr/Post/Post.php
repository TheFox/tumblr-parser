<?php

namespace TheFox\Tumblr\Post;

class Post{
	
	private $type = '';
	private $permalink = '';
	private $title = '';
	
	public function __construct(){
		
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setPermalink($permalink){
		$this->permalink = $permalink;
	}
	
	public function getPermalink(){
		return $this->permalink;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
}
