<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Post\LinkPost;

class LinkBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		parent::setElementsValues();
		
		$content = $this->getContent();
		if($content instanceof LinkPost){
			$hasDescription = (bool)$content->getDescription();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.get_class($element).', '.$element->getName()."\n";
				
				if($element instanceof VariableElement){
					if($elementName == 'url'){
						$element->setContent($content->getUrl());
					}
					elseif($elementName == 'name'){
						$element->setContent($content->getName());
					}
					elseif($elementName == 'target'){
						$element->setContent($content->getTarget());
					}
					elseif($elementName == 'description'){
						$element->setContent($content->getDescription());
					}
				}
				elseif($element instanceof DescriptionBlockElement){
					$element->setContent($hasDescription);
				}
			}
		}
	}
	
	public function render(){
		print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		$this->setElementsValues();
		return parent::render();
	}
	
}
