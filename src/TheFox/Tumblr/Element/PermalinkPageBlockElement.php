<?php

namespace TheFox\Tumblr\Element;

class PermalinkPageBlockElement extends IfBlockElement{
	
	public function getTemplateName(){
		return $this->getName();
	}
	
}
