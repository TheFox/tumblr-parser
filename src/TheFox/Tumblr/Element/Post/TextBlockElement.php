<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Post\TextPost;

class TextBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		#parent::setElementsValues();
		
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$post = $this->getContent();
		#ve($post);
		
		if($post instanceof TextPost){
			$hasTitle = (bool)$post->getTitle();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.$element->getPath().', '.$elementName.PHP_EOL;
				if($element instanceof VariableElement){
					if($elementName == 'title'){
						#print '        title: '.$element->getPath().''.PHP_EOL;
						$element->setContent($post->getTitle());
					}
					elseif($elementName == 'body'){
						#print '        body: '.$element->getPath().''.PHP_EOL;
						$element->setContent($post->getBody());
					}
				}
				elseif($element instanceof TitleBlockElement){
					$element->setContent($hasTitle);
				}
			}
		}
	}
	
}
