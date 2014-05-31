<?php

namespace TheFox\Tumblr;

#use Exception;
use RuntimeException;
#use InvalidArgumentException;

use Symfony\Component\Yaml\Yaml;

use TheFox\Tumblr\Element\Element;
use TheFox\Tumblr\Element\AnswerBlockElement;
use TheFox\Tumblr\Element\AskEnabledBlockElement;
use TheFox\Tumblr\Element\AudioBlockElement;
use TheFox\Tumblr\Element\AudioEmbedBlockElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Element\ChatBlockElement;
use TheFox\Tumblr\Element\DateBlockElement;
use TheFox\Tumblr\Element\DescriptionBlockElement;
use TheFox\Tumblr\Element\HasPagesBlockElement;
use TheFox\Tumblr\Element\HasTagsBlockElement;
use TheFox\Tumblr\Element\HtmlElement;
use TheFox\Tumblr\Element\IfBlockElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\LabelBlockElement;
use TheFox\Tumblr\Element\LinesBlockElement;
use TheFox\Tumblr\Element\LinkBlockElement;
use TheFox\Tumblr\Element\NextPageBlockElement;
use TheFox\Tumblr\Element\NoteCountBlockElement;
use TheFox\Tumblr\Element\PagesBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Element\PhotoBlockElement;
use TheFox\Tumblr\Element\PhotosBlockElement;
use TheFox\Tumblr\Element\PhotosetBlockElement;
use TheFox\Tumblr\Element\PostNotesBlockElement;
use TheFox\Tumblr\Element\PostsBlockElement;
use TheFox\Tumblr\Element\PostTitleBlockElement;
use TheFox\Tumblr\Element\PreviousPageBlockElement;
use TheFox\Tumblr\Element\QuoteBlockElement;
use TheFox\Tumblr\Element\SourceBlockElement;
use TheFox\Tumblr\Element\TagsBlockElement;
use TheFox\Tumblr\Element\TextBlockElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\VideoBlockElement;

#use TheFox\Tumblr\Post\Post;
use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;

class Parser{
	
	public static $variableNames = array(
		'Title',
		'PostTitle',
		'Body',
		'URL',
		'Target',
		'Name',
		'Description',
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
			throw new RuntimeException(__FUNCTION__.': "vars" not set in settings.', 1);
		}
		
		if(!isset($settings['posts']) || !is_array($settings['posts'])){
			throw new RuntimeException(__FUNCTION__.': "posts" not set in settings.', 2);
		}
		
		if(!isset($settings['postsPerPage'])){
			throw new RuntimeException(__FUNCTION__.': "postsPerPage" not set in settings.', 3);
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
	}
	
	private function parseElements($rawhtml = '', $parentElement = null, $level = 1){
		#fwrite(STDOUT, __CLASS__.'->'.__FUNCTION__.': level='.$level."\n");
		
		if($level >= 100){
			throw new RuntimeException(__FUNCTION__.': Maximum level of 100 reached.', 2);
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
					
					if(strtolower(substr($nameFull, 0, 6)) == 'block:'){
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
								throw new RuntimeException(__FUNCTION__.': Missing closing tag "{/'.$nameFull.'}".', 1);
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
							elseif($name == 'Description'){
								$element = new DescriptionBlockElement();
							}
							elseif($name == 'AskEnabled'){
								$element = new AskEnabledBlockElement();
							}
							elseif($name == 'HasPages'){
								$element = new HasPagesBlockElement();
							}
							elseif($name == 'Pages'){
								$element = new PagesBlockElement();
							}
							elseif($name == 'Photo'){
								$element = new PhotoBlockElement();
							}
							elseif($name == 'Photos'){
								$element = new PhotosBlockElement();
							}
							elseif($name == 'Photoset'){
								$element = new PhotosetBlockElement();
							}
							elseif($name == 'Caption'){
								$element = new CaptionBlockElement();
							}
							elseif($name == 'Quote'){
								$element = new QuoteBlockElement();
							}
							elseif($name == 'Chat'){
								$element = new ChatBlockElement();
							}
							elseif($name == 'Audio'){
								$element = new AudioBlockElement();
							}
							elseif($name == 'Video'){
								$element = new VideoBlockElement();
							}
							elseif($name == 'Answer'){
								$element = new AnswerBlockElement();
							}
							elseif($name == 'Source'){
								$element = new SourceBlockElement();
							}
							elseif($name == 'Lines'){
								$element = new LinesBlockElement();
							}
							elseif($name == 'Label'){
								$element = new LabelBlockElement();
							}
							elseif($name == 'Date'){
								$element = new DateBlockElement();
							}
							elseif($name == 'AudioEmbed'){
								$element = new AudioEmbedBlockElement();
							}
							elseif($name == 'NoteCount'){
								$element = new NoteCountBlockElement();
							}
							elseif($name == 'HasTags'){
								$element = new HasTagsBlockElement();
							}
							elseif($name == 'PostNotes'){
								$element = new PostNotesBlockElement();
							}
							elseif($name == 'PreviousPage'){
								$element = new PreviousPageBlockElement();
							}
							elseif($name == 'NextPage'){
								$element = new NextPageBlockElement();
							}
							elseif($name == 'Tags'){
								$element = new TagsBlockElement();
							}
							else{
								#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'unknown block: "'.$name.'"'."\n");
								throw new RuntimeException(__FUNCTION__.': Unknown block "'.$name.'".', 3);
							}
						}
						if($element){
							$element->setName($name);
							$parentElement->addChild($element);
							
							$this->parseElements($subhtml, $element, $level + 1);
						}
						else{
							throw new RuntimeException(__FUNCTION__.': Can not create element.', 4);
						}
						
					}
					else{
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'else'."\n");
						
						if(in_array($nameFull, static::$variableNames) || substr($nameFull, 0, 5) == 'text:'){
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
			throw new RuntimeException(__FUNCTION__.': Maximum level of 100 reached.', 1);
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
			elseif($element instanceof BoolBlockElement){
				$pairName = '';
				if(substr($elementName, 0, 5) == 'IfNot'){
					$pairName = 'If'.substr($elementName, 5);
				}
				#fwrite(STDOUT, ''.str_repeat('    |', $level).'- if has var: '.(int)isset($this->variables[$elementName]).', "'.$pairName.'"'."\n");
				
				if(isset($this->variables[$elementName])){
					#fwrite(STDOUT, ''.str_repeat('    |', $level + 1).'- val: '.$this->variables[$elementName]->getValue()."\n");
					$element->setContent((bool)$this->variables[$elementName]->getValue());
				}
				elseif($pairName && isset($this->variables[$pairName])){
					#fwrite(STDOUT, ''.str_repeat('    |', $level + 1).'- pair: '.$this->variables[$pairName]->getValue()."\n");
					$element->setContent(!(bool)$this->variables[$pairName]->getValue());
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
			elseif($type == 'link'){
				$postObj = new LinkPost();
				if(isset($post['url'])){
					$postObj->setUrl($post['url']);
				}
				if(isset($post['name'])){
					$postObj->setName($post['name']);
				}
				if(isset($post['target'])){
					$postObj->setTarget($post['target']);
				}
				if(isset($post['description'])){
					$postObj->setDescription($post['description']);
				}
			}
			
			if($postObj){
				$postObj->setPermalink($post['permalink']);
			}
		}
		
		return $postObj;
	}
	
	public function parse($type = 'page', $index = 1){
		fwrite(STDOUT, 'parse: '.$type.', '.$index."\n");
		
		$this->parseMetaSettings();
		
		#ve($this->variables);
		
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
			$postObj = $this->makePostFromIndex($index - 1);
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
