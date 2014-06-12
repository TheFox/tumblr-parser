<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Post\AnswerPost;

class AnswerBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		#parent::setElementsValues();
		
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$post = $this->getContent();
		#ve($post);
		
		if($post instanceof AnswerPost){
			#$hasTitle = (bool)$post->getTitle();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.$element->getPath().', '.$elementName.PHP_EOL;
				if($element instanceof VariableElement){
					if($elementName == 'asker'){
						#print '        title: '.$element->getPath().''.PHP_EOL;
						$element->setContent($post->getAsker());
					}
					elseif($elementName == 'question'){
						#print '        title: '.$element->getPath().''.PHP_EOL;
						$element->setContent($post->getQuestion());
					}
					elseif($elementName == 'answer'){
						#print '        body: '.$element->getPath().''.PHP_EOL;
						$element->setContent($post->getAnswer());
					}
				}
			}
		}
	}
	
}
