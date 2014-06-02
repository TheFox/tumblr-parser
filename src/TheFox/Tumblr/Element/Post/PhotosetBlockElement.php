<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Post\PhotosetPost;

class PhotosetBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		$post = $this->getContent();
		if($post instanceof PhotosetPost){
			$hasCapation = (bool)$post->getCaption();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.get_class($element).', '.$element->getName()."\n";
				
				if($element instanceof VariableElement){
					if($elementName == 'caption'){
						$element->setContent($post->getCaption());
					}
				}
				elseif($element instanceof CaptionBlockElement){
					$element->setContent($hasCapation);
				}
				elseif($element instanceof PhotosBlockElement){
					#print '        PhotosBlockElement'."\n";
					$element->setContent($post->getPhotos());
					#ve($element->getContent());
				}
			}
		}
	}
	
}
