<?php

namespace TheFox\Tumblr\Element;

#use RuntimeException;

class Element{
	
	#private $type = '';
	private $name = '';
	private $content = null;
	private $parent = null;
	protected $children = array();
	
	public function __construct(){
		#print __CLASS__.'->'.__FUNCTION__.''."\n";
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
	
	public function addChild(Element $element){
		$this->children[] = $element;
		#$element->setParent($this);
	}
	
	public function getChildren($recursive = false){
		if($recursive){
			$rv = array();
			#$rv = $this->children;
			foreach($this->children as $child){
				$rv[] = $child;
				$rv = array_merge($rv, $child->getChildren($recursive));
			}
			#ve($rv);
			return $rv;
		}
		else{
			return $this->children;
		}
	}
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getName().'"'."\n";
		
		$html = '';
		foreach($this->children as $child){
			$html .= $child->render();
		}
		return $html;
	}
	
}
