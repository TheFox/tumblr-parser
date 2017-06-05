<?php

namespace TheFox\Tumblr\Post;

class ChatPost extends Post
{
    /**
     * @var array
     */
    private $chats = array();

    public function __construct()
    {
        $this->setType('chat');
    }

    /**
     * @param array $chats
     */
    public function setChats($chats)
    {
        $this->chats = $chats;
    }

    /**
     * @return array
     */
    public function getChats()
    {
        return $this->chats;
    }
}
