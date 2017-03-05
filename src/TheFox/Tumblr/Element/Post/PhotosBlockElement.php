<?php

namespace TheFox\Tumblr\Element\Post;

class PhotosBlockElement extends PhotoBlockElement{
	
	public function render(){
		$html = '';
		$photos = $this->getContent();
		
		if($photos && is_array($photos)){
			foreach($photos as $photoId => $photo){
				$this->setContent($photo);
				$this->setElementsValues();
				$html .= parent::render();
			}
		}
		
		// Reset original content.
		$this->setContent($photos);
		
		return $html;
	}
	
}
