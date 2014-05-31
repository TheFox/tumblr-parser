<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;

class PostsBlockElement extends BlockElement{
	
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
						#print '            set'."\n";
						print '        TextBlockElement: "'.$newElement->getName().'"'."\n";
						$newElement->setContent($post);
						$add = true;
					}
				}
				elseif($newElement instanceof LinkBlockElement){
					if($post instanceof LinkPost){
						#print '            set'."\n";
						print '        LinkBlockElement: "'.$newElement->getName().'"'."\n";
						$newElement->setContent($post);
						$add = true;
					}
				}
				elseif($newElement instanceof HtmlElement){
					#print '            set'."\n";
					print '        HtmlElement: "'.$newElement->getName().'"'."\n";
					$add = true;
				}
				else{
					print '        element: "'.get_class($newElement).'", '.$newElement->getName()."\n";
				}
				
				if($add){
					$children[] = $newElement;
				}
				
			}
			
		}
		
		return $this->renderChildren($children);
	}
	
}
