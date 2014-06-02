<?php

namespace TheFox\Tumblr\Post;

class PhotosetPost extends Post{
	
	private $caption = '';
	private $photos = array();
	
	public function __construct(){
		$this->setType('photoset');
	}
	
	public function setCaption($caption){
		$this->caption = $caption;
	}
	
	public function getCaption(){
		return $this->caption;
	}
	
	public function setPhotos($photos){
		$this->photos = $photos;
	}
	
	public function getPhotos(){
		return $this->photos;
	}
	
}
