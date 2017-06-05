<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Post\PhotoPost;

class PhotoPostTest extends TestCase
{
    public function testType()
    {
        $post = new PhotoPost();
        $this->assertEquals('photo', $post->getType());
    }

    public function testSetUrl()
    {
        $post = new PhotoPost();

        $post->setUrl('url1');
        $this->assertEquals('url1', $post->getUrl());
    }

    public function testSetAlt()
    {
        $post = new PhotoPost();

        $post->setAlt('alt1');
        $this->assertEquals('alt1', $post->getAlt());
    }

    public function testSetLinkUrl()
    {
        $post = new PhotoPost();

        $post->setLinkUrl('url2');
        $this->assertEquals('url2', $post->getLinkUrl());
    }

    public function testSetCaption()
    {
        $post = new PhotoPost();

        $post->setCaption('cap1');
        $this->assertEquals('cap1', $post->getCaption());
    }
}
