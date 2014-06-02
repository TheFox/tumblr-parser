<?php

namespace TheFox\Tumblr\Element\Post;

#class PhotosBlockElement extends PhotoBlockElement{
class PhotosBlockElement extends PostBlockElement{
	
	public function setElementsValues(){
		#ve('PhotosBlockElement');
		#ve($posts);
		#ve($this);
	}
	
	public function render(){
		print __CLASS__.'->'.__FUNCTION__.': "'.$this->getPath().'"'."\n";
		#$this->setElementsValues();
		#return parent::render();
		
		$html = '';
		$photos = $this->getContent();
		foreach($photos as $photoId => $photo){
			#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getPath().'" photo: '.$photoId."\n";
			
			ve($photo);
			
			$element = new PhotoBlockElement();
			$element->setId($photoId);
			$element->setName('Photo');
			#$this->addChild($element);
			$element->setContent($photo);
			$html .= $element->render();
		}
		
		ve($html);
		
		return $html;
	}
	
}
