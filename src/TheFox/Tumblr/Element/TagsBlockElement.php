<?php

namespace TheFox\Tumblr\Element;

class TagsBlockElement extends BlockElement{
	
	public function render(){
		$tags = $this->getContent();
		
		$html = '';
		if($tags && is_array($tags)){
			foreach($tags as $tag){
				foreach($this->getChildren(true) as $element){
					$elementName = strtolower($element->getTemplateName());
					if($element instanceof VariableElement){
						if($elementName == 'tag'){
							$element->setContent($tag);
						}
						elseif($elementName == 'tagurl'){
							$element->setContent('?type=tag&id='.$tag);
						}
					}
				}
				foreach($this->getChildren() as $element){
					$html .= $element->render();
				}
			}
		}
		return $html;
	}
	
}
