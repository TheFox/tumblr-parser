<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Post\LinkPost;

class LinkPostTest extends PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $post = new LinkPost();
        $this->assertEquals('link', $post->getType());
    }

    public function testSetUrl()
    {
        $post = new LinkPost();

        $post->setUrl('body1');
        $this->assertEquals('body1', $post->getUrl());
    }

    public function testSetName()
    {
        $post = new LinkPost();

        $post->setName('body1');
        $this->assertEquals('body1', $post->getName());
    }

    public function testSetTarget()
    {
        $post = new LinkPost();

        $post->setTarget('body1');
        $this->assertEquals('body1', $post->getTarget());
    }

    public function testSetDescription()
    {
        $post = new LinkPost();

        $post->setDescription('body1');
        $this->assertEquals('body1', $post->getDescription());
    }
}
