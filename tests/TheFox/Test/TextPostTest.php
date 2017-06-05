<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Post\TextPost;

class TextPostTest extends TestCase
{
    public function testType()
    {
        $post = new TextPost();
        $this->assertEquals('text', $post->getType());
    }

    public function testSetBody()
    {
        $post = new TextPost();

        $post->setBody('body1');
        $this->assertEquals('body1', $post->getBody());
    }
}
