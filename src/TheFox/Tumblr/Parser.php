<?php

namespace TheFox\Tumblr;

use Exception;
use RuntimeException;
use InvalidArgumentException;

use Symfony\Component\Yaml\Yaml;

class Parser{
	
	private $template = '';
	#private $html = '';
	
	public function __construct($template = ''){
		$this->template = $template;
	}
	
	public function setTemplate($template){
		$this->template = $template;
	}
	
	public function setSettings($settings){
		$this->settings = $settings;
	}
	
	public function loadSettingsFromFile($file){
		$this->settings = Yaml::parse($file);
		ve($this->settings);
		
		
	}
	
	public function parseMetaSettings(){
		
	}
	
	public function parse($type = 'page', $page = 1){
		$parsed = $this->template;
		
		if($type == 'page'){
			
		}
		elseif($type == 'post'){
			
		}
		
		return $parsed;
	}
	
	public function printHtml($type = 'page', $page = 1){
		print $this->parse($type, $page);
		flush();
	}
	
}
