<?php

namespace TheFox\Tumblr;

#use Exception;
use RuntimeException;
#use InvalidArgumentException;

use Symfony\Component\Yaml\Yaml;

use TheFox\Tumblr\Element\Element;
use TheFox\Tumblr\Element\HtmlElement;
use TheFox\Tumblr\Element\PostsBlockElement;
use TheFox\Tumblr\Element\TextBlockElement;
use TheFox\Tumblr\Element\LinkBlockElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\PostTitleBlockElement;
use TheFox\Tumblr\Element\IfBlockElement;

#use TheFox\Tumblr\Post\Post;
use TheFox\Tumblr\Post\TextPost;

class Parser{
	
	public static $variableNames = array(
		'Title',
		'PostTitle',
		'Body',
	);
	
	private $settings = array();
	private $template = '';
	private $templateChanged = false;
	private $variables = array();
	private $rootElement = null;
	
	public function __construct($template = ''){
		$this->template = $template;
	}
	
	public function setTemplate($template){
		$this->template = $template;
		$this->templateChanged = true;
	}
	
	public function setSettings($settings){
		if(!isset($settings['vars']) || !is_array($settings['vars'])){
			throw new RuntimeException('"vars" not set in settings.', 1);
		}
		
		if(!isset($settings['posts']) || !is_array($settings['posts'])){
			throw new RuntimeException('"posts" not set in settings.', 2);
		}
		
		if(!isset($settings['postsPerPage'])){
			throw new RuntimeException('"postsPerPage" not set in settings.', 3);
		}
		
		$this->settings = $settings;
		
		$this->parseSettingsVars();
	}
	
	public function loadSettingsFromFile($file){
		$settings = Yaml::parse($file);
		$this->setSettings($settings);
	}
	
	private function parseSettingsVars(){
		#ve($this->settings['vars']);
		foreach($this->settings['vars'] as $key => $val){
			$variable = new Variable();
			$variable->setName($key);
			$variable->setValue($val);
			
			$this->variables[$variable->getTemplateName()] = $variable;
		}
	}
	
	private function parseMetaSettings(){
		foreach(array('if', 'text') as $type){
			preg_match_all('/<meta name="('.$type.':[^"]+)" content="([^"]+)"/i', $this->template, $matches);
			
			foreach(array_combine($matches[1], $matches[2]) as $key => $val){
				$variable = new Variable();
				$variable->setName($key);
				$variable->setValue($val);
				
				$tmpname = $variable->getTemplateName();
				
				#print "'$key' [$tmpname] => '$val'\n";
				
				if(!isset($this->variables[$tmpname])){
					$this->variables[$tmpname] = $variable;
				}
			}
		}
		
		#ve($this->variables);
	}
	
	private function parseElements($rawhtml = '', $parentElement = null, $level = 1){
		#fwrite(STDOUT, __CLASS__.'->'.__FUNCTION__.': level='.$level."\n");
		if($level >= 100){
			throw new RuntimeException('Maximum level of 100 reached.', 2);
		}
		
		if(!$rawhtml && $level == 1){
			$rawhtml = $this->template;
		}
		if(!$parentElement){
			$parentElement = $this->rootElement = new Element();
		}
		
		$fuse = 0;
		while($rawhtml && $fuse <= 1000){
			$fuse++;
			
			#fwrite(STDOUT, str_repeat(' ', 4 * ($level)).'parse: "'.$rawhtml.'"'."\n");
			
			$content = '';
			$element = null;
			
			$pos = strpos($rawhtml, '{');
			if($pos === false){
				#fwrite(STDOUT, str_repeat(' ', 4 * ($level)).'no { found'."\n");
				
				$element = new HtmlElement();
				$element->setContent($rawhtml);
				$parentElement->addChild($element);
				
				$rawhtml = '';
			}
			else{
				#fwrite(STDOUT, str_repeat(' ', 4 * ($level)).'found {: '.$pos."\n");
				
				if($pos >= 1){
					$content = substr($rawhtml, 0, $pos);
					#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'content: "'.$content.'"'."\n");
					
					$element = new HtmlElement();
					$element->setContent($content);
					$parentElement->addChild($element);
				}
				$rawhtml = substr($rawhtml, $pos + 1);
				
				$pos = strpos($rawhtml, '}');
				if($pos === false){
					$content .= '{'.$rawhtml;
					#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'no } found: "'.$content.'"'."\n");
					
					$element->setContent($content);
				}
				else{
					$nameFull = substr($rawhtml, 0, $pos);
					$nameFullLen = strlen($nameFull);
					$rawhtml = substr($rawhtml, $pos + 1);
					
					#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'found }: '.$pos.', "'.$nameFull.'" '.$nameFullLen."\n");
					
					if(strtolower(substr($nameFull, 0, 6)) == 'block:' || strtolower(substr($nameFull, 0, 6)) == 'text:'){
						$nameFullPos = strpos($nameFull, ':');
						$name = substr($nameFull, $nameFullPos + 1);
						$type = strtolower(substr($nameFull, 0, $nameFullPos));
						
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'block|text: '.$nameFullPos.', "'.$type.'", "'.$name.'"'."\n");
						
						$offset = 0;
						$newoffset = 0;
						$testhtml = '';
						$temphtml = $rawhtml;
						do{
							$temphtml = substr($temphtml, $offset);
							$pos = strpos($temphtml, '{/'.$nameFull.'}');
							
							if($pos === false){
								throw new RuntimeException('Missing closing tag "{/'.$nameFull.'}".', 1);
							}
							else{
								$testhtml = substr($temphtml, 0, $pos);
								$newoffset = $offset + $pos + 2 + $nameFullLen + 1;
								
								#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 2)).'found: o='.$offset.' ('.$newoffset.'), p='.$pos.': "'.$temphtml.'", "'.$testhtml.'"'."\n");
								
								$offset = $newoffset;
							}
							
							#usleep(300000);
						}
						while(strpos($testhtml, '{'.$nameFull.'}') !== false);
						
						$subhtml = substr($rawhtml, 0, $offset - 2 - $nameFullLen - 1);
						$rawhtml = substr($rawhtml, $offset);
						
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'name: "'.$name.'", "'.$nameFull.'", '.$offset.''."\n");
						
						$element = null;
						if($type == 'block'){
							if(strtolower(substr($name, 0, 2)) == 'if'){
								$name = substr($name, 2);
								$element = new IfBlockElement();
							}
							elseif($name == 'Posts'){
								$element = new PostsBlockElement();
							}
							elseif($name == 'Text'){
								$element = new TextBlockElement();
							}
							elseif($name == 'Link'){
								$element = new LinkBlockElement();
							}
							elseif($name == 'IndexPage'){
								$element = new IndexPageBlockElement();
							}
							elseif($name == 'PermalinkPage'){
								$element = new PermalinkPageBlockElement();
							}
							elseif($name == 'Title'){
								$element = new TitleBlockElement();
							}
							elseif($name == 'PostTitle'){
								$element = new PostTitleBlockElement();
							}
							else{
								#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'unknown block: "'.$name.'"'."\n");
								throw new RuntimeException('Unknown block "'.$name.'".', 3);
							}
						}
						elseif($type == 'text'){
							$element = new TextElement();
						}
						if($element){
							$element->setName($name);
							$parentElement->addChild($element);
							
							$this->parseElements($subhtml, $element, $level + 1);
						}
						else{
							throw new RuntimeException('Can not create element.', 4);
						}
						
					}
					else{
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'else'."\n");
						
						if(in_array($nameFull, static::$variableNames)){
							#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'ok'."\n");
							
							$element = new VariableElement();
							$element->setName($nameFull);
							$parentElement->addChild($element);
						}
						else{
							$content = '{'.$nameFull.'}';
							#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'content: "'.$nameFull.'", "'.$content.'"'."\n");
							
							$element = new HtmlElement();
							$element->setName($nameFull);
							$element->setContent($content);
							$parentElement->addChild($element);
						}
						
						#$rawhtml = substr($rawhtml, $pos + 1);
					}
				}
				
			}
			
			#usleep(300000);
		}
		
		#if($level == 1){ ve($this->rootElement); }
	}
	
	private function setElementsValues(Element $element, $isIndexPage = false, $isPermalinkPage = false, $posts = array(), $level = 1){
		if($level >= 100){
			throw new RuntimeException('Maximum level of 100 reached.', 1);
		}
		
		$post = null;
		if($isPermalinkPage){
			$post = $posts[0];
		}
		
		#$elemtents = $this->rootElement->getChildren(true);
		#$elemtents = $element->getChildren(true);
		$elemtents = $element->getChildren();
		
		foreach($elemtents as $elementId => $element){
			$elementName = $element->getTemplateName();
			
			$elementNameOut = '';
			if($elementName){
				$elementNameOut = ', "'.$elementName.'"';
			}
			
			$className = str_replace('TheFox\Tumblr\Element\\', '', get_class($element));
			
			
			#fwrite(STDOUT, ''.str_repeat('    |', ($level - 1)).'- element '.$elementId.': '.$className.$elementNameOut."\n");
			
			#usleep(300000);
			
			$setSub = false;
			#$setSub = true;
			
			if($element instanceof VariableElement){
				#fwrite(STDOUT, "    'var' has var: ".(int)isset($this->variables[$elementName])."\n");
				if(isset($this->variables[$elementName])){
					#fwrite(STDOUT, "    val: '".$this->variables[$elementName]->getValue()."'\n");
					$element->setContent($this->variables[$elementName]->getValue());
				}
				else{
					$element->setContent(null);
				}
			}
			elseif($element instanceof IndexPageBlockElement){
				$element->setContent($isIndexPage);
				$setSub = true;
			}
			elseif($element instanceof PermalinkPageBlockElement){
				$element->setContent($isPermalinkPage);
				$setSub = true;
			}
			elseif($element instanceof PostTitleBlockElement){
				$element->setContent($isPermalinkPage);
				$setSub = true;
			}
			elseif($element instanceof IfBlockElement){
				#fwrite(STDOUT, ''.str_repeat('    |', $level).'- if has var: '.(int)isset($this->variables[$elementName])."\n");
				
				if(isset($this->variables[$elementName])){
					#fwrite(STDOUT, ''.str_repeat('    |', $level + 1).'- val: '.$this->variables[$elementName]->getValue()."\n");
					$element->setContent((bool)$this->variables[$elementName]->getValue());
				}
				else{
					$element->setContent(false);
				}
				
				$setSub = true;
			}
			elseif($element instanceof PostsBlockElement){
				#fwrite(STDOUT, "    PostsBlockElement"."\n");
				$element->setContent($posts);
			}
			else{
				$setSub = true;
			}
			
			if($setSub){
				$this->setElementsValues($element, $isIndexPage, $isPermalinkPage, $posts, $level + 1);
			}
		}
		
		#usleep(300000);
		
		#ve($elemtents);
	}
	
	private function renderElements(Element $element){
		return $element->render();
	}
	
	private function makePostFromIndex($index){
		$postObj = null;
		
		if(isset($this->settings['posts'][$index])){
			$post = $this->settings['posts'][$index];
			$type = strtolower($post['type']);
			
			if($type == 'text'){
				$postObj = new TextPost();
				if(isset($post['title'])){
					$postObj->setTitle($post['title']);
				}
				if(isset($post['body'])){
					$postObj->setBody($post['body']);
				}
			}
		}
		
		return $postObj;
	}
	
	public function parse($type = 'page', $index = 1){
		$this->parseMetaSettings();
		
		if($this->templateChanged){
			$this->templateChanged = false;
			$this->parseElements();
		}
		
		$isIndexPage = $type == 'page';
		$isPermalinkPage = $type == 'post';
		
		$posts = array();
		
		if($isIndexPage){
			$postIdMin = ($index - 1) * $this->settings['postsPerPage'];
			$postIdMax = $postIdMin + $this->settings['postsPerPage'];
			#fwrite(STDOUT, 'ids: '.$postIdMin.' - '.$postIdMax."\n");
			
			for($id = $postIdMin; $id < $postIdMax; $id++){
				if(isset($this->settings['posts'][$id])){
					$postObj = $this->makePostFromIndex($id);
					if($postObj){
						$posts[] = $postObj;
					}
				}
				else{
					break;
				}
			}
		}
		elseif($isPermalinkPage){
			$postObj = $this->makePostFromIndex($index);
			if($postObj){
				$posts[] = $postObj;
				
				$variable = new Variable();
				$variable->setName('PostTitle');
				$variable->setValue($postObj->getTitle());
				
				$this->variables['PostTitle'] = $variable;
			}
		}
		
		#ve($posts);
		#ve($this->variables);
		
		$this->setElementsValues($this->rootElement, $isIndexPage, $isPermalinkPage, $posts);
		return $this->renderElements($this->rootElement);
	}
	
	public function printHtml($type = 'page', $index = 1){
		$html = $this->parse($type, $index);
		#print "\n\n\n\n\n\n\n\n\n";
		
		print "\n'$html'\n";
		flush();
	}
	
}
