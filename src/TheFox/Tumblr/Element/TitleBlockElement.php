<?php

namespace TheFox\Tumblr\Element;

class TitleBlockElement extends IfBlockElement{
	
	public function getTemplateName(){
		return $this->getName();
	}
	
}
