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
		#print str_repeat(' ', 0 * 4).'render: "'.$this->getName().'"'."\n";
		
		$children = array();
		$html = '';
		foreach($this->getContent() as $postId => $post){
			#print str_repeat(' ', 1 * 4).'post: '.$postId.', '.get_class($post).', '.$post->getType()."\n";
			
			$dateDayOfWeek = '';
			$dateDayOfMonth = '';
			$dateMonth = '';
			$dateYear = '';
			
			$postDateTime = $post->getDateTime();
			if($postDateTime){
				$dateDayOfWeek = $postDateTime->format('l');
				$dateDayOfMonth = $postDateTime->format('j');
				$dateMonth = $postDateTime->format('n');
				$dateYear = $postDateTime->format('Y');
			}
			
			// Set all children and subchildren.
			foreach($this->getChildren(true) as $element){
				#$newElement = clone $element;
				$elementName = strtolower($element->getTemplateName());
				
				#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
				
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
						#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
						$element->setContent($post);
					}
				}
				elseif($element instanceof VariableElement){
					#print str_repeat(' ', 2 * 4).'element: '.$element->getId().', "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
					#print str_repeat(' ', 2 * 4).'element: '.$element->getPath().', "'.$element->getName().'"'."\n";
					
					if($elementName == 'permalink'){
						$element->setContent($post->getPermalink());
						#ve($element);
					}
					elseif($elementName == 'dayofweek'){
						$element->setContent($dateDayOfWeek);
					}
					elseif($elementName == 'dayofmonth'){
						$element->setContent($dateDayOfMonth);
					}
					elseif($elementName == 'month'){
						$element->setContent($dateMonth);
					}
					elseif($elementName == 'year'){
						$element->setContent($dateYear);
					}
					elseif($elementName == 'postid'){
						$element->setContent($post->getPostId());
					}
				}
				
			}
			
			// Collect level 1 children for rendering.
			foreach($this->getChildren() as $element){
				$rc = new \ReflectionClass(get_class($element));
				
				#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
				
				$add = false;
				if($element instanceof TextBlockElement){
					if($post instanceof TextPost){
						#print str_repeat(' ', 2 * 4).'element: "'.$element->getName().'"'."\n";
						$add = true;
					}
				}
				elseif($element instanceof LinkBlockElement){
					if($post instanceof LinkPost){
						#print str_repeat(' ', 2 * 4).'element: "'.$element->getName().'"'."\n";
						$add = true;
					}
				}
				elseif($element instanceof PhotoBlockElement){
					if($post instanceof PhotoPost){
						#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
						$add = true;
					}
				}
				elseif($element instanceof PhotosetBlockElement){
					if($post instanceof PhotosetPost){
						#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
						$add = true;
					}
				}
				elseif($element instanceof VariableElement){
					#print str_repeat(' ', 2 * 4).'HtmlElement: "'.$element->getName().'"'."\n";
					$add = true;
				}
				elseif($element instanceof DateBlockElement){
					$add = true;
				}
				elseif($element instanceof HtmlElement){
					#print str_repeat(' ', 2 * 4).'HtmlElement: "'.$element->getName().'"'."\n";
					$add = true;
				}
				else{
					#$add = true;
					#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", '.$element->getName()."\n";
				}
				
				if($add){
					#print str_repeat(' ', 3 * 4).'add'."\n";
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
