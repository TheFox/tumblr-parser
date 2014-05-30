<?php

namespace TheFox\Tumblr\Element;

class DescriptionBlockElement extends IfBlockElement{
	
	public function getTemplateName(){
		return $this->getName();
	}
	
}
