<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Post\ChatPost;

class ChatBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		#parent::setElementsValues();
		
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$post = $this->getContent();
		#ve($post);
		
		if($post instanceof ChatPost){
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.$element->getPath().', '.$elementName.PHP_EOL;
				if($element instanceof VariableElement){
					if($elementName == 'title'){
						#print '        title: '.$element->getPath().''.PHP_EOL;
						$element->setContent($post->getTitle());
					}
				}
				elseif($element instanceof LinesBlockElement){
					#print '    LinesBlockElement'.PHP_EOL;
					$element->setContent($post->getChats());
				}
			}
		}
	}
	
	public function render1(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		#$this->setElementsValues();
		#
		
		#$content = $this->getContent();
		#ve($content);
		
		
		
		return parent::render();
	}
	
}
