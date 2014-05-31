<?php

namespace TheFox\Tumblr\Element;

class BoolBlockElement extends BlockElement{
	
	public function __construct(){
		#print __CLASS__.'->'.__FUNCTION__.''."\n";
		
		$this->setContent(false);
	}
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		if($this->getContent()){
			#print __CLASS__.'->'.__FUNCTION__.':     render'."\n";
			return parent::render();
		}
		return '';
	}
	
}
