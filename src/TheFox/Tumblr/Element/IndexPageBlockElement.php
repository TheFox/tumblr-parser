<?php

namespace TheFox\Tumblr\Element;

class IndexPageBlockElement extends IfBlockElement{
	
	public function getTemplateName(){
		return $this->getName();
	}
	
}
