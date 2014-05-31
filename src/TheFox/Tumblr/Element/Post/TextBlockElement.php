<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Post\TextPost;

class TextBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		parent::setElementsValues();
		
		$content = $this->getContent();
		if($content instanceof TextPost){
			$hasTitle = (bool)$content->getTitle();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.get_class($element).', '.$element->getName()."\n";
				
				if($element instanceof VariableElement){
					if($elementName == 'title'){
						$element->setContent($content->getTitle());
					}
					elseif($elementName == 'body'){
						$element->setContent($content->getBody());
					}
				}
				elseif($element instanceof TitleBlockElement){
					$element->setContent($hasTitle);
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
