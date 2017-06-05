<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Post\ChatPost;

class ChatPostTest extends PHPUnit_Framework_TestCase
{

    public function testType()
    {
        $post = new ChatPost();
        $this->assertEquals('chat', $post->getType());
    }

    public function testSetChats()
    {
        $post = new ChatPost();

        $this->assertEquals([], $post->getChats());

        $post->setChats(['chat1', 'chat2']);
        $this->assertEquals(['chat1', 'chat2'], $post->getChats());
    }

}
