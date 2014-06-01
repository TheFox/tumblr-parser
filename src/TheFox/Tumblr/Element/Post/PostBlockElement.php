<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\BlockElement;
use TheFox\Tumblr\Post\Post;

class PostBlockElement extends BlockElement{
	
	public function setElementsValues(){
		
	}
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		$this->setElementsValues();
		return parent::render();
	}
	
}
