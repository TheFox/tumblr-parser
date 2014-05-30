<?php

namespace TheFox\Tumblr\Post;

class LinkPost extends Post{
	
	private $url = '';
	private $name = '';
	private $target = '';
	private $description = '';
	
	public function __construct(){
		$this->type = 'link';
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function getUrl(){
		return $this->url;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setTarget($target){
		$this->target = $target;
	}
	
	public function getTarget(){
		return $this->target;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
}
