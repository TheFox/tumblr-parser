<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\SourceBlockElement;
use TheFox\Tumblr\Post\QuotePost;

class QuoteBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		#parent::setElementsValues();
		
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$post = $this->getContent();
		#\Doctrine\Common\Util\Debug::dump($post);
		
		if($post && $post instanceof QuotePost){
			$hasSource = (bool)$post->getSource();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.$element->getPath().', '.$elementName.PHP_EOL;
				if($element instanceof VariableElement){
					if($elementName == 'quote'){
						$element->setContent($post->getQuote());
					}
					elseif($elementName == 'source'){
						$element->setContent($post->getSource());
					}
					elseif($elementName == 'length'){
						$element->setContent($post->getLength());
					}
				}
				elseif($element instanceof SourceBlockElement){
					$element->setContent($hasSource);
				}
			}
		}
	}
	
}
