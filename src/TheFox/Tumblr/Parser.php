<?php

namespace TheFox\Tumblr;

use RuntimeException;
use DateTime;

use Symfony\Component\Yaml\Yaml;

use TheFox\Tumblr\Element\Element;
use TheFox\Tumblr\Element\AnswerBlockElement;
use TheFox\Tumblr\Element\AskEnabledBlockElement;
use TheFox\Tumblr\Element\AudioBlockElement;
use TheFox\Tumblr\Element\AudioEmbedBlockElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Element\DateBlockElement;
use TheFox\Tumblr\Element\DescriptionBlockElement;
use TheFox\Tumblr\Element\HasPagesBlockElement;
use TheFox\Tumblr\Element\HasTagsBlockElement;
use TheFox\Tumblr\Element\HtmlElement;
use TheFox\Tumblr\Element\IfBlockElement;
use TheFox\Tumblr\Element\IfNotBlockElement;
use TheFox\Tumblr\Element\IndexPageBlockElement;
use TheFox\Tumblr\Element\LabelBlockElement;
use TheFox\Tumblr\Element\LinkUrlBlockElement;
use TheFox\Tumblr\Element\NextPageBlockElement;
use TheFox\Tumblr\Element\NoteCountBlockElement;
use TheFox\Tumblr\Element\PagesBlockElement;
use TheFox\Tumblr\Element\PaginationBlockElement;
use TheFox\Tumblr\Element\PermalinkPageBlockElement;
use TheFox\Tumblr\Element\PostNotesBlockElement;
use TheFox\Tumblr\Element\PostsBlockElement;
use TheFox\Tumblr\Element\PostTitleBlockElement;
use TheFox\Tumblr\Element\PreviousPageBlockElement;
use TheFox\Tumblr\Element\SourceBlockElement;
use TheFox\Tumblr\Element\TagsBlockElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Element\VideoBlockElement;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\TextVariableElement;
use TheFox\Tumblr\Element\LangVariableElement;

use TheFox\Tumblr\Element\Post\TextBlockElement;
use TheFox\Tumblr\Element\Post\LinkBlockElement;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\Post\PhotosBlockElement;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Element\Post\QuoteBlockElement;
use TheFox\Tumblr\Element\Post\ChatBlockElement;
use TheFox\Tumblr\Element\Post\LinesBlockElement;

use TheFox\Tumblr\Post\TextPost;
use TheFox\Tumblr\Post\LinkPost;
use TheFox\Tumblr\Post\PhotoPost;
#use TheFox\Tumblr\Post\PhotosPost;
use TheFox\Tumblr\Post\PhotosetPost;
use TheFox\Tumblr\Post\QuotePost;
use TheFox\Tumblr\Post\ChatPost;

class Parser{
	
	public static $variableNames = array(
		'Alt',
		'AskLabel',
		'Body',
		'Caption',
		'CustomCSS',
		'DayOfMonth',
		'DayOfWeek',
		'Description',
		'Label',
		'Length',
		'LikeButton',
		'Line',
		'LinkCloseTag',
		'LinkOpenTag',
		'LinkURL',
		'MetaDescription',
		'Month',
		'Name',
		'NextPage',
		'NoteCount',
		'NoteCountWithLabel',
		'Permalink',
		'PhotoAlt',
		'PhotoURL-500',
		'PostID',
		'PostNotes',
		'PostTitle',
		'PreviousPage',
		'Quote',
		'ReblogButton',
		'Source',
		'Tag',
		'TagURL',
		'Target',
		'Title',
		'URL',
		'UserNumber',
		'Year',
	);
	
	private $settings = array();
	private $template = '';
	private $templateChanged = false;
	private $variablesId = 0;
	private $variables = array();
	private $rootElement = null;
	private $elementsId = 0;
	
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
		if(!isset($settings['pages'])){
			throw new RuntimeException(__FUNCTION__.': "pages" not set in settings.', 4);
		}
		
		$this->settings = $settings;
		
		$this->parseSettingsVars();
	}
	
	public function loadSettingsFromFile($file){
		$settings = Yaml::parse($file);
		$this->setSettings($settings);
	}
	
	private function fillVariables($variables, $overwrite = false){
		foreach($variables as $key => $val){
			$this->variablesId++;
			$variable = new Variable();
			$variable->setId($this->variablesId);
			$variable->setName($key);
			$variable->setValue($val);
			
			$tmpName = $variable->getTemplateName();
			$ifName = $variable->getIfName();
			$ifNotName = $variable->getIfNotName();
			
			#fwrite(STDOUT, "settings: '".$key."' '".$tmpName."' '".$ifName."' => '".$val."'\n");
			
			if($overwrite || !$overwrite && !isset($this->variables[$tmpName])){
				$this->variables[$tmpName] = $variable;
				
				$variableIf = clone $variable;
				if($tmpName != $ifName){
					#$variableIf->setReference($variable);
					$this->variablesId++;
					$variableIf->setId($this->variablesId);
					$variableIf->setValue((bool)$val);
					$this->variables[$ifName] = $variableIf;
				}
				
				$variableIfNot = clone $variableIf;
				#$variableIfNot->setReference($variableIf);
				$this->variablesId++;
				$variableIfNot->setId($this->variablesId);
				$variableIfNot->setValue(!$variableIfNot->getValue());
				$this->variables[$ifNotName] = $variableIfNot;
				
				
			}
		}
	}
	
	private function parseSettingsVars(){
		$this->fillVariables($this->settings['vars'], true);
	}
	
	private function parseMetaSettings(){
		foreach(array('if', 'text') as $type){
			preg_match_all('/<meta name="('.$type.':[^"]+)" content="([^"]+)"/i', $this->template, $matches);
			$this->fillVariables(array_combine($matches[1], $matches[2]));
		}
		
		#ve($this->variables);
	}
	
	private function parseElements($rawhtml = '', $parentElement = null, $level = 1){
		#fwrite(STDOUT, __CLASS__.'->'.__FUNCTION__.': level='.$level.PHP_EOL);
		
		if($level >= 100){
			throw new RuntimeException(__FUNCTION__.': Maximum level of 100 reached.', 2);
		}
		
		if(!$rawhtml && $level == 1){
			$rawhtml = $this->template;
		}
		if(!$parentElement){
			$this->elementsId++;
			$parentElement = $this->rootElement = new Element();
			$parentElement->setId($this->elementsId);
		}
		
		$fuse = 0;
		while($rawhtml && $fuse <= 1000){
			$fuse++;
			
			#fwrite(STDOUT, str_repeat(' ', 4 * ($level)).'parse: "'.$rawhtml.'"'.PHP_EOL);
			
			$content = '';
			$element = null;
			
			$pos = strpos($rawhtml, '{');
			if($pos === false){
				#fwrite(STDOUT, str_repeat(' ', 4 * ($level)).'no { found'.PHP_EOL);
				
				$this->elementsId++;
				$element = new HtmlElement();
				$element->setId($this->elementsId);
				$element->setContent($rawhtml);
				$parentElement->addChild($element);
				
				$rawhtml = '';
			}
			else{
				#fwrite(STDOUT, str_repeat(' ', 4 * ($level)).'found {: '.$pos.PHP_EOL);
				
				if($pos >= 1){
					$content = substr($rawhtml, 0, $pos);
					#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'content: "'.$content.'"'.PHP_EOL);
					
					$this->elementsId++;
					$element = new HtmlElement();
					$element->setId($this->elementsId);
					$element->setContent($content);
					$parentElement->addChild($element);
				}
				$rawhtml = substr($rawhtml, $pos + 1);
				
				$pos = strpos($rawhtml, '}');
				if($pos === false){
					$content .= '{'.$rawhtml;
					#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'no } found: "'.$content.'"'.PHP_EOL);
					
					$element->setContent($content);
				}
				else{
					$nameFull = substr($rawhtml, 0, $pos);
					$nameFullLen = strlen($nameFull);
					$rawhtml = substr($rawhtml, $pos + 1);
					
					#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'found }: '.$pos.', "'.$nameFull.'" '.$nameFullLen.PHP_EOL);
					
					if(strtolower(substr($nameFull, 0, 6)) == 'block:'){
						$nameFullPos = strpos($nameFull, ':');
						$name = substr($nameFull, $nameFullPos + 1);
						$type = strtolower(substr($nameFull, 0, $nameFullPos));
						
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'block|text: '.$nameFullPos.', "'.$type.'", "'.$name.'"'.PHP_EOL);
						
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
								
								#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 2)).'found: o='.$offset.' ('.$newoffset.'), p='.$pos.': "'.$temphtml.'", "'.$testhtml.'"'.PHP_EOL);
								
								$offset = $newoffset;
							}
							
							#usleep(300000);
						}
						while(strpos($testhtml, '{'.$nameFull.'}') !== false);
						
						$subhtml = substr($rawhtml, 0, $offset - 2 - $nameFullLen - 1);
						$rawhtml = substr($rawhtml, $offset);
						
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'name: "'.$name.'", "'.$nameFull.'", '.$offset.''.PHP_EOL);
						
						$element = null;
						if($type == 'block'){
							if(strtolower(substr($name, 0, 5)) == 'ifnot'){
								$name = substr($name, 5);
								$element = new IfNotBlockElement();
							}
							elseif(strtolower(substr($name, 0, 2)) == 'if'){
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
							elseif($name == 'Photo'){
								$element = new PhotoBlockElement();
							}
							elseif($name == 'Photos'){
								$element = new PhotosBlockElement();
							}
							elseif($name == 'Photoset'){
								$element = new PhotosetBlockElement();
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
							elseif($name == 'Pagination'){
								$element = new PaginationBlockElement();
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
							elseif($name == 'LinkURL'){
								$element = new LinkUrlBlockElement();
							}
							else{
								#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'unknown block: "'.$name.'". Path: '.$parentElement->getPath().''.PHP_EOL);
								throw new RuntimeException(__FUNCTION__.': Unknown block "'.$name.'". Path: '.$parentElement->getPath(), 3);
							}
						}
						if($element){
							$this->elementsId++;
							$element->setId($this->elementsId);
							$element->setName($name);
							$parentElement->addChild($element);
							
							$this->parseElements($subhtml, $element, $level + 1);
						}
						else{
							throw new RuntimeException(__FUNCTION__.': Can not create element.', 4);
						}
						
					}
					else{
						#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'else'.PHP_EOL);
						
						if(in_array($nameFull, static::$variableNames)){
							#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'ok'.PHP_EOL);
							
							$this->elementsId++;
							$element = new VariableElement();
							$element->setId($this->elementsId);
							$element->setName($nameFull);
							$parentElement->addChild($element);
						}
						elseif(substr($nameFull, 0, 5) == 'text:'){
							#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'ok text'.PHP_EOL);
							
							$this->elementsId++;
							$element = new TextVariableElement();
							$element->setId($this->elementsId);
							$element->setName($nameFull);
							$parentElement->addChild($element);
						}
						elseif(substr($nameFull, 0, 5) == 'lang:'){
							#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'ok lang'.PHP_EOL);
							
							$this->elementsId++;
							$element = new LangVariableElement();
							$element->setId($this->elementsId);
							$element->setName($nameFull);
							$parentElement->addChild($element);
						}
						else{
							$content = '{'.$nameFull.'}';
							#fwrite(STDOUT, str_repeat(' ', 4 * ($level + 1)).'content: "'.$nameFull.'", "'.$content.'"'.PHP_EOL);
							
							$this->elementsId++;
							$element = new HtmlElement();
							$element->setId($this->elementsId);
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
	
	private function setElementsValues(Element $element, $isIndexPage = false, $isPermalinkPage = false, $posts = array(), $id = 1, $totalPages = 1, $pages = array(), $level = 1){
		if($level >= 100){
			throw new RuntimeException(__FUNCTION__.': Maximum level of 100 reached.', 1);
		}
		
		$elemtents = $element->getChildren();
		foreach($elemtents as $elementId => $element){
			$elementName = $element->getTemplateName();
			
			$elementNameOut = '';
			if($elementName){
				$elementNameOut = ', "'.$elementName.'"';
			}
			
			$rc = new \ReflectionClass(get_class($element));
			$className = $rc->getShortName();
			
			#fwrite(STDOUT, str_repeat('    |', ($level - 1)).'- element '.$elementId.': '.$className.$elementNameOut.PHP_EOL);
			#fwrite(STDOUT, str_repeat('    |', ($level - 1)).'- element '.$elementId.': '.$element->getPath().PHP_EOL);
			#fwrite(STDOUT, 'element: '.$element->getPath().PHP_EOL);
			
			$setSub = true;
			if($element instanceof VariableElement){
				#fwrite(STDOUT, 'element: '.$element->getPath().PHP_EOL);
				
				$content = $element->getDefaultContent();
				if($element instanceof LangVariableElement){
					#fwrite(STDOUT, '    lang "'.$elementName.'"'.PHP_EOL);
					
					if($isIndexPage && $elementName == 'lang:Page CurrentPage of TotalPages'){
						$content = 'Page '.$id.' of '.$totalPages;
					}
					else{
						if(isset($this->variables[$elementName])){
							$content = $this->variables[$elementName]->getValue();
						}
					}
				}
				elseif($elementName == 'PreviousPage'){
					#fwrite(STDOUT, '    PreviousPage '.(int)$isIndexPage.', '.$id.', '.$totalPages.PHP_EOL);
					if($isIndexPage && $id > 1){
						$content = '?type=page&id='.($id - 1);
						#fwrite(STDOUT, '        url "'.$content.'"'.PHP_EOL);
						#$element->setContent($url);
					}
				}
				elseif($elementName == 'NextPage'){
					#fwrite(STDOUT, '    NextPage '.(int)$isIndexPage.', '.$id.', '.$totalPages.PHP_EOL);
					if($isIndexPage && $id < $totalPages){
						$content = '?type=page&id='.($id + 1);
						#fwrite(STDOUT, '        url "'.$content.'"'.PHP_EOL);
						#$element->setContent($url);
					}
				}
				
				if(!$content && isset($this->variables[$elementName])){
					$content = $this->variables[$elementName]->getValue();
				}
				
				$element->setContent($content);
				$setSub = false;
			}
			elseif($element instanceof IndexPageBlockElement){
				#fwrite(STDOUT, 'element index:  '.$element->getPath().' "'.$elementName.'" '.(int)$isIndexPage.PHP_EOL);
				$element->setContent($isIndexPage);
			}
			elseif($element instanceof PermalinkPageBlockElement){
				#fwrite(STDOUT, 'element perm:  '.$element->getPath().' "'.$elementName.'" '.(int)$isPermalinkPage.PHP_EOL);
				$element->setContent($isPermalinkPage);
			}
			elseif($element instanceof PostTitleBlockElement){
				$element->setContent($isPermalinkPage);
			}
			elseif($element instanceof IfNotBlockElement){
				#fwrite(STDOUT, 'element not:  '.$element->getPath().' "'.$elementName.'"'.PHP_EOL);
				
				if(isset($this->variables[$elementName])){
					#$val = !(bool)$this->variables[$elementName]->getValue();
					$val = (bool)$this->variables[$elementName]->getValue();
					#fwrite(STDOUT, 'element not:  '.$element->getPath().'    - val: '.(int)$val.PHP_EOL);
					$element->setContent((bool)$val);
				}
				else{
					#fwrite(STDOUT, 'element not:  '.$element->getPath().'    - default: '.(int)$element->getDefaultContent().PHP_EOL);
					$element->setContent($element->getDefaultContent());
				}
			}
			elseif($element instanceof IfBlockElement){
				#fwrite(STDOUT, 'element if:   '.$element->getPath().' "'.$elementName.'"'.PHP_EOL);
				
				if(isset($this->variables[$elementName])){
					$val = (bool)$this->variables[$elementName]->getValue();
					#fwrite(STDOUT, 'element if:   '.$element->getPath().'    - val: '.(int)$val.PHP_EOL);
					$element->setContent((bool)$val);
				}
				else{
					#fwrite(STDOUT, 'element if:   '.$element->getPath().'    - default: '.(int)$element->getDefaultContent().PHP_EOL);
					$element->setContent($element->getDefaultContent());
				}
			}
			elseif($element instanceof AskEnabledBlockElement){
				$elementName = 'IfAskEnabled';
				#fwrite(STDOUT, str_repeat('    |', ($level - 1)).'- element '.$elementId.': '.$className.$elementNameOut.PHP_EOL);
				if(isset($this->variables[$elementName])){
					#fwrite(STDOUT, ''.str_repeat('    |', $level + 1).'- val: '.$this->variables[$elementName]->getValue().PHP_EOL);
					$element->setContent(true);
				}
				else{
					$element->setContent($element->getDefaultContent());
				}
			}
			elseif($element instanceof DescriptionBlockElement){
				$elementName = 'MetaDescription';
				#fwrite(STDOUT, str_repeat('    |', ($level - 1)).'- element '.$elementId.': '.$className.$elementNameOut.PHP_EOL);
				if(isset($this->variables[$elementName])){
					#fwrite(STDOUT, ''.str_repeat('    |', $level + 1).'- val: '.$this->variables[$elementName]->getValue().PHP_EOL);
					$element->setContent(true);
				}
				else{
					$element->setContent($element->getDefaultContent());
				}
			}
			elseif($element instanceof PaginationBlockElement){
				#fwrite(STDOUT, 'element: '.$element->getPath().PHP_EOL);
				$element->setContent($isIndexPage);
			}
			elseif($element instanceof PreviousPageBlockElement){
				#fwrite(STDOUT, 'element: '.$element->getPath().PHP_EOL);
				if($isIndexPage && $id > 1){
					$element->setContent(true);
				}
			}
			elseif($element instanceof NextPageBlockElement){
				#fwrite(STDOUT, 'element: '.$element->getPath().PHP_EOL);
				if($isIndexPage && $id < $totalPages){
					$element->setContent(true);
				}
			}
			elseif($element instanceof HasPagesBlockElement){
				$element->setContent(count($pages) > 0);
			}
			elseif($element instanceof PagesBlockElement){
				$element->setContent($pages);
			}
			elseif($element instanceof PostsBlockElement){
				#fwrite(STDOUT, "    PostsBlockElement".PHP_EOL);
				$element->setContent($posts);
			}
			
			if($setSub){
				$this->setElementsValues($element, $isIndexPage, $isPermalinkPage, $posts, $id, $totalPages, $pages, $level + 1);
			}
		}
	}
	
	private function renderElements(Element $element){
		return $element->render();
	}
	
	private function makePhoto($post){
		$postObj = new PhotoPost();
		if(isset($post['url'])){
			$postObj->setUrl($post['url']);
		}
		if(isset($post['alt'])){
			$postObj->setAlt($post['alt']);
		}
		if(isset($post['link'])){
			$postObj->setLinkUrl($post['link']);
		}
		if(isset($post['caption'])){
			$postObj->setCaption($post['caption']);
		}
		
		return $postObj;
	}
	
	private function makePostFromIndex($id, $isPermalinkPage = false){
		$htmlId = $id + 1;
		#fwrite(STDOUT, 'makePostFromIndex: '.$id.', '.$htmlId.PHP_EOL);
		
		$postObj = null;
		
		if(isset($this->settings['posts'][$id])){
			$post = $this->settings['posts'][$id];
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
			elseif($type == 'photo'){
				$postObj = $this->makePhoto($post);
			}
			elseif($type == 'photoset'){
				$postObj = new PhotosetPost();
				if(isset($post['caption'])){
					$postObj->setCaption($post['caption']);
				}
				if(isset($post['photos'])){
					$photos = array();
					foreach($post['photos'] as $photo){
						$photoObj = $this->makePhoto($photo);
						if($photoObj){
							$photos[] = $photoObj;
							#ve($photoObj);
						}
					}
					$postObj->setPhotos($photos);
				}
			}
			elseif($type == 'quote'){
				$postObj = new QuotePost();
				if(isset($post['quote'])){
					$postObj->setQuote($post['quote']);
				}
				if(isset($post['source'])){
					$postObj->setSource($post['source']);
				}
				if(isset($post['length'])){
					$postObj->setLength($post['length']);
				}
			}
			elseif($type == 'chat'){
				$postObj = new ChatPost();
				if(isset($post['title'])){
					$postObj->setTitle($post['title']);
				}
				if(isset($post['chats'])){
					$postObj->setChats($post['chats']);
				}
			}
			
			if($postObj){
				if(isset($post['permalink'])){
					$postObj->setPermalink($post['permalink']);
				}
				else{
					$postObj->setPermalink('?type=post&id='.$htmlId);
					#fwrite(STDOUT, 'makePostFromIndex: '.$postObj->getPermalink().PHP_EOL);
				}
				if(isset($post['date'])){
					$postDateTime = new DateTime($post['date']);
					$postObj->setDateTime($postDateTime);
				}
				if(isset($post['notes'])){
					$postObj->setNotes($post['notes']);
				}
				if(isset($post['tags'])){
					$postObj->setTags($post['tags']);
				}
				
				$postObj->setIsPermalinkPage($isPermalinkPage);
				#$postObj->setHasNextPage(isset($this->settings['posts'][$id + 1]));
				$postObj->setPostId($htmlId);
			}
		}
		
		return $postObj;
	}
	
	public function parse($type = 'page', $id = 1){
		#fwrite(STDOUT, 'parse: '.$type.', '.$id.PHP_EOL);
		
		$this->parseMetaSettings();
		
		#ve($this->variables);
		
		if($this->templateChanged){
			$this->templateChanged = false;
			$this->parseElements();
		}
		
		$isIndexPage = $type == 'page';
		$isPermalinkPage = $type == 'post';
		$totalPages = ceil(count($this->settings['posts']) / $this->settings['postsPerPage']);
		
		$posts = array();
		
		if($isIndexPage){
			$postIdMin = ($id - 1) * $this->settings['postsPerPage'];
			$postIdMax = $postIdMin + $this->settings['postsPerPage'];
			#fwrite(STDOUT, 'ids: '.$postIdMin.' - '.$postIdMax.PHP_EOL);
			
			for($postId = $postIdMin; $postId < $postIdMax; $postId++){
				if(isset($this->settings['posts'][$postId])){
					$postObj = $this->makePostFromIndex($postId, $isPermalinkPage);
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
			$postObj = $this->makePostFromIndex($id - 1, $isPermalinkPage);
			if($postObj){
				$posts[] = $postObj;
				
				$variable = new Variable();
				$variable->setName('PostTitle');
				$variable->setValue($postObj->getTitle());
				
				$this->variables['PostTitle'] = $variable;
				
				#fwrite(STDOUT, 'PostTitle: '.$postObj->getTitle().PHP_EOL);
			}
			
			#ve($postObj);
		}
		
		#ve($posts);
		#ve($this->variables);
		
		$this->setElementsValues($this->rootElement, $isIndexPage, $isPermalinkPage, $posts, $id, $totalPages, $this->settings['pages']);
		return $this->renderElements($this->rootElement);
	}
	
	public function printHtml($type = 'page', $id = 1){
		$html = $this->parse($type, $id);
		#print "\n\n\n\n\n\n\n\n\n";
		
		#print "\n'$html'\n";
		print $html;
		flush();
	}
	
}
