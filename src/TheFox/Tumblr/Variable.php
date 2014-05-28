<?php

namespace TheFox\Tumblr;

class Variable{
	
	private $type = '';
	private $name = '';
	private $templateName = '';
	private $value = '';
	
	public function __construct(){
		
	}
	
	public function setName($name){
		$this->name = $name;
		
		$name = $this->name;
		
		
		$namecmp = strtolower($name);
		if(substr($namecmp, 0, 3) == 'if:'){
			$name = str_replace(' ', '', $name);
			$name = 'If'.substr($name, 3);
			$this->type = 'bool';
		}
		elseif(substr($namecmp, 0, 5) == 'text:'){
			#$name = 'Text'.substr($name, 5);
			$this->type = 'text';
		}
		
		$this->templateName = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getTemplateName(){
		return $this->templateName;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function getValue(){
		return $this->value;
	}
	
}
