<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LinkUrlBlockElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Post\PhotoPost;

class PhotoBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		$post = $this->getContent();
		if($post instanceof PhotoPost){
			$hasUrl = (bool)$post->getUrl();
			$hasLink = (bool)$post->getLinkUrl();
			$hasCapation = (bool)$post->getCaption();
			foreach($this->getChildren(true) as $element){
				$elementName = strtolower($element->getTemplateName());
				
				#print '    element: '.get_class($element).', '.$element->getName()."\n";
				
				if($element instanceof VariableElement){
					if($elementName == 'photourl-500'){
						$element->setContent($post->getUrl());
					}
					elseif($elementName == 'photoalt'){
						$element->setContent($post->getAlt());
					}
					elseif($elementName == 'linkurl'){
						if($hasLink){
							$element->setContent($post->getLinkUrl());
						}
						else{
							$element->setContent($post->getPermalink());
						}
					}
					elseif($elementName == 'caption'){
						$element->setContent($post->getCaption());
					}
					elseif($elementName == 'linkopentag'){
						if($hasLink){
							$element->setContent('<a href="'.$post->getLinkUrl().'">');
						}
						else{
							$element->setContent('<a href="'.$post->getPermalink().'">');
						}
					}
					elseif($elementName == 'linkclosetag'){
						$element->setContent('</a>');
					}
				}
				elseif($element instanceof LinkUrlBlockElement){
					$element->setContent($hasLink);
				}
				elseif($element instanceof CaptionBlockElement){
					$element->setContent($hasCapation);
				}
			}
		}
	}
	
}
