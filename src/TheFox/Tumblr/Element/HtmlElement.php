<?php

namespace TheFox\Tumblr\Element;

class HtmlElement extends Element{
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		return $this->getContent();
	}
	
}
