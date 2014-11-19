<?php

namespace TheFox\Tumblr\Element;

class IfNotBlockElement extends BoolBlockElement{
	
	public function getTemplateName(){
		return 'IfNot'.$this->getName();
	}
	
	public function getDefaultContent(){
		return true;
	}
	
}
