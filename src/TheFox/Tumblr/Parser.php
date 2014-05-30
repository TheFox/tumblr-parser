<?php

namespace TheFox\Tumblr;

#use Exception;
use RuntimeException;
#use InvalidArgumentException;

use Symfony\Component\Yaml\Yaml;

class Parser{
	
	public static $variableNames = array(
		'Title',
	);
	
	private $template = '';
	private $variables = array();
	private $rootElement = null;
	
	public function __construct($template = ''){
		$this->template = $template;
	}
	
	public function setTemplate($template){
		$this->template = $template;
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
		foreach($this->settings['vars'] as $key => $val){
			$variable = new Variable();
			$variable->setName($key);
			$variable->setValue($val);
			
			$this->variables[$variable->getTemplateName()] = $variable;
		}
	}
	
	private function parseMetaSettings(){
		foreach(array('if:', 'text:') as $type){
			preg_match_all('/<meta name="('.$type.'[^"]+)" content="([^"]+)"/i', $this->template, $matches);
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
		fwrite(STDOUT, __CLASS__.'->'.__FUNCTION__.': '.$level."\n");
		if($level >= 100){
			throw new RuntimeException('Maximum level of 100 reached.', 2);
		}
		
		if(!$rawhtml){
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
				
				if($pos > 1){
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
							
							#usleep(100000);
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
			
			#usleep(100000);
		}
		
		if($level == 1){
			#ve($this->rootElement);
		}
	}
	
	private function renderElements(Element $element){
		return $element->render();
	}
	
	public function parse($type = 'page', $page = 1){
		#$parsed = $this->template;
		
		$this->parseMetaSettings();
		
		$this->parseElements();
		
		$elemtents = $this->rootElement->getChildren(true);
		foreach($elemtents as $elementId => $element){
			#ve($element);
			print "element: ".$elementId.', '.get_class($element).', "'.$element->getName().'", "'.$element->getContent().'", "'.$element->render().'"'."\n";
		}
		
		if($type == 'page'){
			
		}
		elseif($type == 'post'){
			
		}
		
		#ve();
		
		return $this->renderElements($this->rootElement);
	}
	
	public function printHtml($type = 'page', $page = 1){
		$html = $this->parse($type, $page);
		#print "\n\n\n\n\n\n\n\n\n";
		#print "\n\n\n\n'$html'\n\n\n\n\n";
		flush();
	}
	
}
