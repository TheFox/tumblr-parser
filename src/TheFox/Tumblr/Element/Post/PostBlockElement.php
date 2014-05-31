<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\BlockElement;
use TheFox\Tumblr\Post\Post;

class PostBlockElement extends BlockElement{
	
	public function setElementsValues(){
		print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$content = $this->getContent();
		if($content instanceof Post){
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				if($element instanceof VariableElement){
					if($elementName == 'permalink'){
						
						$element->setContent($content->getPermalink());
						ve($element);
					}
					elseif($elementName == 'postid'){
						$element->setContent($content->getPostId());
					}
				}
				elseif($element instanceof TitleBlockElement){
					$element->setContent($hasTitle);
				}
			}
		}
	}
	
}
