<?php

namespace TheFox\Tumblr\Element;

use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Element\Post\QuoteBlockElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;
use TheFox\Tumblr\Post\PhotoPost;
use TheFox\Tumblr\Post\PhotosetPost;
use TheFox\Tumblr\Post\QuotePost;

class PostsBlockElement extends BlockElement{
	
	public function render(){
		#print str_repeat(' ', 0 * 4).'render: "'.$this->getName().'"'."\n";
		
		$children = array();
		$html = '';
		foreach($this->getContent() as $postId => $post){
			#print str_repeat(' ', 1 * 4).'post: '.$postId.', '.get_class($post).', '.$post->getType()."\n";
			
			$hasTitle = (bool)$post->getTitle();
			
			$dateDayOfWeek = '';
			$dateDayOfMonth = '';
			$dateMonth = '';
			$dateYear = '';
			
			$postDateTime = $post->getDateTime();
			if($postDateTime){
				$dateDayOfWeek = $postDateTime->format('l');
				$dateDayOfMonth = $postDateTime->format('j');
				$dateMonth = $postDateTime->format('F');
				$dateYear = $postDateTime->format('Y');
			}
			
			$notes = $post->getNotes();
			$notesCount = count($notes);
			$tags = $post->getTags();
			$tagsCount = count($tags);
			
			// Set all children and subchildren.
			foreach($this->getChildren(true) as $element){
				#$newElement = clone $element;
				$elementName = strtolower($element->getTemplateName());
				
				#print str_repeat(' ', 2 * 4).'element: "'.get_class($element).'", "'.$element->getName().'" '.$element->getPath()."\n";
				#print str_repeat(' ', 2 * 4).'element: '.$element->getPath()."\n";
				
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
				elseif($element instanceof QuoteBlockElement){
					if($post instanceof QuotePost){
						$element->setContent($post);
					}
				}
				elseif($element instanceof VariableElement){
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
					elseif($elementName == 'likebutton'){
						$element->setContent('<div class="like_button" data-post-id="1" id="like_button_1"><iframe id="like_iframe_1" src="http://assets.tumblr.com/assets/html/like_iframe.html?_v=2#name=thefox21&amp;post_id=1&rk=x9D9S9kC" scrolling="no" width="20" height="20" frameborder="0" class="like_toggle" allowTransparency="true"></iframe></div>');
					}
					elseif($elementName == 'reblogbutton'){
						#print str_repeat(' ', 2 * 4).'element: '.$element->getPath().', "'.$element->getName().'"'."\n";
						$element->setContent('<a href="" class="reblog_button"style="display: block;width:20px;height:20px;"><svg width="100%" height="100%" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M5.01092527,5.99908429 L16.0088498,5.99908429 L16.136,9.508 L20.836,4.752 L16.136,0.083 L16.1360004,3.01110845 L2.09985349,3.01110845 C1.50585349,3.01110845 0.979248041,3.44726568 0.979248041,4.45007306 L0.979248041,10.9999998 L3.98376463,8.30993634 L3.98376463,6.89801007 C3.98376463,6.20867902 4.71892527,5.99908429 5.01092527,5.99908429 Z"></path><path d="M17.1420002,13.2800293 C17.1420002,13.5720293 17.022957,14.0490723 16.730957,14.0490723 L4.92919922,14.0490723 L4.92919922,11 L0.5,15.806 L4.92919922,20.5103758 L5.00469971,16.9990234 L18.9700928,16.9990234 C19.5640928,16.9990234 19.9453125,16.4010001 19.9453125,15.8060001 L19.9453125,9.5324707 L17.142,12.203"></path></svg></a>');
					}
					elseif($elementName == 'postnotes'){
						$element->setContent('<ol class="notes"><!-- START NOTES --><li class="note reblog tumblelog_thefox21 original_post without_commentary"><a rel="nofollow" class="avatar_frame" target="_blank" href="http://blog.fox21.at/" title="thefox21"><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/post/13835148295/hello-world">'.join('<div class="clear"></div></li><li class="note reblog tumblelog_thefox21 original_post without_commentary"><a rel="nofollow" class="avatar_frame" target="_blank" href="http://blog.fox21.at/" title="thefox21"><img src="http://37.media.tumblr.com/avatar_3c795f47b134_16.png" class="avatar " alt="" /></a><span class="action" data-post-url="http://blog.fox21.at/post/13835148295/hello-world">', $notes).'</span><div class="clear"></div></li><!-- END NOTES --></ol>');
					}
					elseif($elementName == 'notecount' && $post->getIsPermalinkPage()){
						$element->setContent($notesCount);
					}
					elseif($elementName == 'notecountwithlabel'){
						$element->setContent($notesCount.' note'.($notesCount == 1 ? '' : 's'));
					}
				}
				elseif($element instanceof DateBlockElement){
					$element->setContent(true);
					#print str_repeat(' ', 2 * 4).'element: '.$element->getPath()."\n";
				}
				elseif($element instanceof PostNotesBlockElement){
					$element->setContent($notes && $post->getIsPermalinkPage() ? true : false);
				}
				elseif($element instanceof NoteCountBlockElement){
					$element->setContent($notes ? true : false);
				}
				elseif($element instanceof HasTagsBlockElement){
					$element->setContent($tags ? true : false);
				}
				elseif($element instanceof TagsBlockElement){
					$element->setContent($tags);
				}
				elseif($element instanceof TitleBlockElement){
					#print str_repeat(' ', 2 * 4).'element: '.$element->getPath().', "'.$element->getName().'" '.(int)$hasTitle."\n";
					$element->setContent($hasTitle);
				}
			}
			
			// Collect level 1 children for rendering.
			foreach($this->getChildren() as $element){
				$rc = new \ReflectionClass(get_class($element));
				
				#print str_repeat(' ', 2 * 4).'element: '.$element->getPath()."\n";
				#ve($element->getContent());
				
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
				elseif($element instanceof QuoteBlockElement){
					if($post instanceof QuotePost){
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
				elseif($element instanceof PostNotesBlockElement){
					$add = true;
				}
				elseif($element instanceof NoteCountBlockElement){
					$add = true;
				}
				elseif($element instanceof HasTagsBlockElement){
					$add = true;
				}
				elseif($element instanceof TagsBlockElement){
					$add = true;
				}
				elseif($element instanceof HtmlElement){
					#print str_repeat(' ', 2 * 4).'HtmlElement: "'.$element->getName().'"'."\n";
					$add = true;
				}
				elseif($element instanceof IndexPageBlockElement){
					$add = true;
				}
				elseif($element instanceof PermalinkPageBlockElement){
					$add = true;
				}
				else{
					#ve($element->getContent());
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
