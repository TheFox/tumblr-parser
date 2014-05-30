<?php

namespace TheFox\Tumblr\Element;

class PostsBlockElement extends BlockElement{
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$html = '';
		foreach($this->children as $child){
			$html .= $child->render();
		}
		return $html;
	}
	
}
