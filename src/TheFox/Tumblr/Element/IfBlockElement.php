<?php

namespace TheFox\Tumblr\Element;

class IfBlockElement extends BoolBlockElement{
	
	public function getTemplateName(){
		return 'If'.$this->getName();
	}
	
}
