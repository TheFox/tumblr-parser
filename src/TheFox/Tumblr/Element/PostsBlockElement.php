<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;

class PostsBlockElement extends BlockElement{
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$children = array();
		$html = '';
		foreach($this->getContent() as $postId => $post){
			#print '    post: '.$postId.', '.get_class($post).', '.$post->getType()."\n";
			
			// Set all children and subchildren.
			foreach($this->getChildren(true) as $element){
				#$newElement = clone $element;
				$elementName = strtolower($element->getTemplateName());
				
				#print '        PostsBlockElement element: "'.get_class($newElement).'", "'.$newElement->getName().'" '.$element->getPath()."\n";
				
				if($element instanceof TextBlockElement){
					if($post instanceof TextPost){
						$element->setContent($post);
					}
				}
				elseif($element instanceof LinkBlockElement){
					if($post instanceof LinkPost){
						$element->setContent($post);
					}
				}
				elseif($element instanceof VariableElement){
					#print '        PostsBlockElement element: '.$element->getId().', "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
					#print '        PostsBlockElement element: '.$element->getPath().', "'.$element->getName().'"'."\n";
					
					if($elementName == 'permalink'){
						$element->setContent($post->getPermalink());
						#ve($element);
					}
					elseif($elementName == 'postid'){
						$element->setContent($post->getPostId());
					}
				}
			}
			
			// Collect level 1 children for rendering.
			foreach($this->getChildren() as $element){
				$rc = new \ReflectionClass(get_class($element));
				
				#$newElement = clone $element;
				
				#print '        PostsBlockElement element: "'.get_class($newElement).'", "'.$newElement->getName().'" '.$element->getPath()."\n";
				#print '        PostsBlockElement element: '.$element->getPath().', "'.get_class($newElement).'", "'.$newElement->getName().'"'."\n";
				#print '        element: '.$rc->getShortName().', '.$element->getPath().', "'.$element->getName().'"  '."\n";
				#print '        element: '.$element->getPath().'  '."\n";
				
				$add = false;
				if($element instanceof TextBlockElement){
					if($post instanceof TextPost){
						#print '        TextBlockElement: "'.$element->getName().'"'."\n";
						$add = true;
					}
				}
				elseif($element instanceof LinkBlockElement){
					if($post instanceof LinkPost){
						#print '        LinkBlockElement: "'.$element->getName().'"'."\n";
						$add = true;
					}
				}
				elseif($element instanceof VariableElement){
					#print '        HtmlElement: "'.$element->getName().'"'."\n";
					$add = true;
				}
				elseif($element instanceof HtmlElement){
					#print '        HtmlElement: "'.$element->getName().'"'."\n";
					$add = true;
				}
				else{
					#$add = true;
					#print '        element: "'.get_class($element).'", '.$element->getName()."\n";
				}
				
				if($add){
					#print '            add'."\n";
					#$children[] = $newElement;
					#$children[] = $element;
					$html .= $element->render();
				}
				
			}
			
		}
		
		#return $this->renderChildren($children);
		return $html;
	}
	
}
