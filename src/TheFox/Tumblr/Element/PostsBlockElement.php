<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;

class PostsBlockElement extends BlockElement{
	
	private $templates = array();
	
	public function setContent($content){
		parent::setContent($content);
		#$this->fillTemplates();
	}
	
	private function fillTemplates(){
		#print ''."\n";
		
		foreach($this->getChildren() as $element){
			#print '     '.(int)($element instanceof Element).' '.(int)($element instanceof BlockElement).' '.(int)($element instanceof TextBlockElement).' "'.$element->getName().'" "'.$element->getTemplateName().'"'."\n";
			
			if($element instanceof BlockElement){
				$this->templates[strtolower($element->getTemplateName())] = $element;
			}
		}
	}
	
	public function render(){
		print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$children = array();
		foreach($this->getContent() as $postId => $post){
			print '    post: '.$postId.', '.get_class($post).', '.$post->getType()."\n";
			
			foreach($this->getChildren() as $element){
				$newElement = clone $element;
				print '        element: "'.get_class($newElement).'", '.$newElement->getName()."\n";
				
				$add = false;
				if($newElement instanceof TextBlockElement){
					if($post instanceof TextPost){
						print '            set'."\n";
						#print '        element: "'.get_class($newElement).'", '.$newElement->getName()."\n";
						$newElement->setContent($post);
						$add = true;
					}
				}
				elseif($newElement instanceof LinkBlockElement){
					if($post instanceof LinkPost){
						print '            set'."\n";
						#print '        element: "'.get_class($newElement).'", '.$newElement->getName()."\n";
						$newElement->setContent($post);
						$add = true;
					}
				}
				elseif($newElement instanceof HtmlElement){
					print '            set'."\n";
					#print '        element: "'.get_class($newElement).'", '.$newElement->getName().', "'.$newElement->getContent().'"'."\n";
					$add = true;
				}
				
				if($add){
					$children[] = $newElement;
				}
				
			}
			
		}
		
		return $this->renderChildren($children);
	}
	
}
