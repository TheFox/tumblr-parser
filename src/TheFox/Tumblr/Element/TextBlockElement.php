<?php

namespace TheFox\Tumblr\Element;

use RuntimeException;

use TheFox\Tumblr\Post\TextPost;

class TextBlockElement extends BlockElement{
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.''."\n";
		print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$content = $this->getContent();
		#ve($content);
		
		if($content instanceof TextPost){
			#throw new RuntimeException('Wrong type of content: '.get_class($content));
			
			$hasTitle = (bool)$content->getTitle();
			#$hasTitle = false;
			
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.get_class($element).', '.$element->getName()."\n";
				
				if($element instanceof TitleBlockElement){
					$element->setContent($hasTitle);
				}
				elseif($element instanceof VariableElement){
					if($elementName == 'title'){
						$element->setContent($content->getTitle());
					}
					elseif($elementName == 'body'){
						$element->setContent($content->getBody());
					}
				}
			}
		}
		
		
		
		return parent::render();
	}
	
}
