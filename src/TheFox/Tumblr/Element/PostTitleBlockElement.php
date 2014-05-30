<?php

namespace TheFox\Tumblr\Element;

class PostTitleBlockElement extends IfBlockElement{
	
	public function getTemplateName(){
		return $this->getName();
	}
	
}
