<?php

namespace TheFox\Tumblr\Post;

class Post{
	
	private $type = '';
	private $permalink = '';
	private $postId = 0;
	
	private $title = '';
	
	public function __construct(){
		
	}
	
	public function setType($type){
		$this->type = $type;
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
	
	public function setPostId($postId){
		$this->postId = $postId;
	}
	
	public function getPostId(){
		return $this->postId;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
}
