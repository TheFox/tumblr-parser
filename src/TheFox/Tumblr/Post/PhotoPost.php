<?php

namespace TheFox\Tumblr\Post;

class PhotoPost extends Post{
	
	private $url = '';
	private $alt = '';
	private $caption = '';
	
	public function __construct(){
		$this->setType('photo');
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	
	public function getUrl(){
		return $this->url;
	}
	
	public function setAlt($alt){
		$this->alt = $alt;
	}
	
	public function getAlt(){
		return $this->alt;
	}
	
	public function setCaption($caption){
		$this->caption = $caption;
	}
	
	public function getCaption(){
		return $this->caption;
	}
	
}
