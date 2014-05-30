<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Element\VariableElement;

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
			#print '    post: '.$postId.', '.get_class($post).', '.$post->getType().', '.$post->getElementClassName()."\n";
			#print '    post: '.$postId.', '.get_class($post).', '.$post->getType()."\n";
			
			foreach($this->getChildren() as $element){
				
				$newElement = clone $element;
				#print '       element: "'.get_class($newElement).'"'."\n";
				
				if($newElement instanceof TextBlockElement && $post instanceof TextPost){
					#print '           set'."\n";
					$newElement->setContent($post);
				}
				
				$children[] = $newElement;
			}
			
		}
		
		$rv = '';
		#ve($children);
		
		#print 'render'."\n";
		#$this->setChildren($children);
		#$rv = parent::render();
		$rv = $this->renderChildren($children);
		
		return $rv;
	}
	
}
