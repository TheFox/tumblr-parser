<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\BlockElement;
use TheFox\Tumblr\Post\Post;

class PostBlockElement extends BlockElement{
	
	public function setElementsValues(){
		
	}
	
	public function render(){
		$this->setElementsValues();
		return parent::render();
	}
	
}
