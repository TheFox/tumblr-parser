<?php

namespace TheFox\Tumblr\Element;

class VariableElement extends Element{
	
	public function render(){
		return $this->getContent();
	}
	
}
