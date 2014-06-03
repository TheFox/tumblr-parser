<?php

namespace TheFox\Tumblr\Element;

#use RuntimeException;

class Element{
	
	private $id = 0;
	#private $type = '';
	private $name = '';
	private $content = null;
	private $parent = null;
	protected $children = array();
	
	public function __construct(){
		#print __CLASS__.'->'.__FUNCTION__.''."\n";
		$this->setContent($this->getDefaultContent());
	}
	
	public function __destruct(){
		#print __CLASS__.'->'.__FUNCTION__.''."\n";
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	/*public function setType($type){
		$this->type = $type;
	}
	
	public function getType(){
		return $this->type;
	}*/
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getTemplateName(){
		return $this->getName();
	}
	
	public function getDefaultContent(){
		return null;
	}
	
	public function setContent($content){
		$this->content = $content;
	}
	
	public function getContent(){
		return $this->content;
	}
	
	public function setParent(Element $parent){
		$this->parent = $parent;
	}
	
	public function getParent(){
		return $this->parent;
	}
	
	public function getPath(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$name = $this->getName();
		$rc = new \ReflectionClass(get_class($this));
		$className = $rc->getShortName();
		
		if($this->getParent()){
			return $this->getParent()->getPath().'->'.($name ? $name : $className).'['.$this->getId().']';
		}
		else{
			#return 'ROOT'.'['.$this->getId().']';
			return ''.($name ? $name : $className).'['.$this->getId().']';
		}
	}
	
	public function setChildren($children){
		$this->children = $children;
	}
	
	public function addChild(Element $element){
		$this->children[] = $element;
		$element->setParent($this);
	}
	
	public function getChildren($recursive = false){
		if($recursive){
			$rv = array();
			foreach($this->children as $element){
				$rv[] = $element;
				$rv = array_merge($rv, $element->getChildren($recursive));
			}
			return $rv;
		}
		else{
			return $this->children;
		}
	}
	
	public function renderChildren($children){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$html = '';
		foreach($children as $element){
			#print '       element: "'.get_class($element).'"'."\n";
			$html .= $element->render();
		}
		return $html;
	}
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getPath().'"'."\n";
		
		return $this->renderChildren($this->children);
	}
	
}
