<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
#use TheFox\Tumblr\Element\DescriptionBlockElement;
use TheFox\Tumblr\Post\PhotoPost;

class PhotoBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		$post = $this->getContent();
		if($post instanceof PhotoPost){
			$hasDescription = (bool)$post->getDescription();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				print '    element: '.get_class($element).', '.$element->getName()."\n";
				
				if($element instanceof VariableElement){
					if($elementName == 'url'){
						$element->setContent($post->getUrl());
					}
					elseif($elementName == 'name'){
						$element->setContent($post->getName());
					}
					elseif($elementName == 'target'){
						$element->setContent($post->getTarget());
					}
					elseif($elementName == 'description'){
						$element->setContent($post->getDescription());
					}
				}
			}
		}
	}
	
}
