<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LabelBlockElement;

class LineBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		#parent::setElementsValues();
		
		$post = $this->getContent();
		
		$hasLabel = isset($post['label']) && $post['label'];
		$label = $hasLabel ? $post['label'] : '';
		$line = isset($post['line']) && $post['line'] ? $post['line'] : '';
		$alt = isset($post['alt']) && $post['alt'] ? $post['alt'] : '';
		$name = isset($post['name']) && $post['name'] ? $post['name'] : '';
		$userNumber = isset($post['userNumber']) && $post['userNumber'] ? $post['userNumber'] : '';
		
		foreach($this->getChildren(true) as $element){
			$elementName = strtolower($element->getTemplateName());
			
			if($element instanceof VariableElement){
				if($elementName == 'label'){
					if($hasLabel){
						$element->setContent($label);
					}
				}
				elseif($elementName == 'line'){
					$element->setContent($line);
				}
				elseif($elementName == 'alt'){
					$element->setContent($alt);
				}
				elseif($elementName == 'name'){
					$element->setContent($name);
				}
				elseif($elementName == 'usernumber'){
					$element->setContent($userNumber);
				}
			}
			elseif($element instanceof LabelBlockElement){
				$element->setContent($hasLabel);
			}
		}
	}
	
}
