<?php

namespace TheFox\Tumblr\Element;

class PagesBlockElement extends BlockElement{
	
	public function render(){
		$pages = $this->getContent();
		
		$html = '';
		if(is_array($pages)){
			#\Doctrine\Common\Util\Debug::dump($pages, 10);
			foreach($pages as $page){
				foreach($this->getChildren(true) as $element){
					$elementName = strtolower($element->getTemplateName());
					if($element instanceof VariableElement){
						if($elementName == 'label' && isset($page['label'])){
							$element->setContent($page['label']);
						}
						elseif($elementName == 'url' && isset($page['url'])){
							$element->setContent($page['url']);
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
