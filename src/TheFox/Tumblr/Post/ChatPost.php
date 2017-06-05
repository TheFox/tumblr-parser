<?php

namespace TheFox\Tumblr\Post;

class ChatPost extends Post
{
    /**
     * @var array
     */
    private $chats = [];

    public function __construct()
    {
        $this->setType('chat');
    }

    /**
     * @param array $chats
     */
    public function setChats(array $chats)
    {
        $this->chats = $chats;
    }

    /**
     * @return array
     */
    public function getChats(): array 
    {
        return $this->chats;
    }
}
