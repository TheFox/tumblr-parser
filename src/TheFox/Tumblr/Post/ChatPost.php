<?php

namespace TheFox\Tumblr\Post;

class ChatPost extends Post{
	
	private $chats = array();
	
	public function __construct(){
		$this->setType('chat');
	}
	
	public function setChats($chats){
		$this->chats = $chats;
	}
	
	public function getChats(){
		return $this->chats;
	}
	
}
