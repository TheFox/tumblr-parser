<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;
use TheFox\Tumblr\Post\PhotoPost;
use TheFox\Tumblr\Post\PhotosetPost;

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
				
				#print '        element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
				
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
				elseif($element instanceof PhotoBlockElement){
					if($post instanceof PhotoPost){
						$element->setContent($post);
					}
				}
				elseif($element instanceof PhotosetBlockElement){
					if($post instanceof PhotosetPost){
						#print '        element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
						$element->setContent($post);
					}
				}
				elseif($element instanceof VariableElement){
					#print '        element: '.$element->getId().', "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
					#print '        element: '.$element->getPath().', "'.$element->getName().'"'."\n";
					
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
				
				#print '        element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
				
				$add = false;
				if($element instanceof TextBlockElement){
					if($post instanceof TextPost){
						#print '        element: "'.$element->getName().'"'."\n";
						$add = true;
					}
				}
				elseif($element instanceof LinkBlockElement){
					if($post instanceof LinkPost){
						#print '        element: "'.$element->getName().'"'."\n";
						$add = true;
					}
				}
				elseif($element instanceof PhotoBlockElement){
					if($post instanceof PhotoPost){
						#print '        element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
						$add = true;
					}
				}
				elseif($element instanceof PhotosetBlockElement){
					if($post instanceof PhotosetPost){
						#print '        element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
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
