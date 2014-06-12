<?php

namespace TheFox\Tumblr\Element\Post;

#use TheFox\Tumblr\Element\VariableElement;
#use TheFox\Tumblr\Element\TitleBlockElement;
#use TheFox\Tumblr\Post\ChatPost;

class LinesBlockElement extends LineBlockElement{
	
	public function render(){
		#print __CLASS__.'->'.__FUNCTION__.': "'.$this->getPath().'"'."\n";
		
		$html = '';
		$lines = $this->getContent();
		#ve($lines);
		
		$usersId = 0;
		$users = array();
		
		$alt = 'even';
		foreach($lines as $lineId => $line){
			$line['name'] = 'your_tumblr_username';
			
			$alt = $alt == 'odd' ? 'even' : 'odd';
			$line['alt'] = $alt;
			
			$userNumber = 0;
			if(!isset($line['userNumber']) && isset($line['label']) && $line['label']){
				$labelLower = strtolower($line['label']);
				
				$userNumber = array_search($labelLower, $users);
				if($userNumber === false){
					$userNumber = array_push($users, $labelLower);
				}
			}
			
			
			$line['userNumber'] = $userNumber;
			
			#ve($line);
			
			$this->setContent($line);
			$this->setElementsValues();
			$html .= parent::render();
		}
		
		// Reset original content.
		$this->setContent($lines);
		
		return $html;
	}
	
}
