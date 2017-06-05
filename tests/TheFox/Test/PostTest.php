<?php

namespace TheFox\Test;

use DateTime;
use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Post\Post;

class PostTest extends PHPUnit_Framework_TestCase
{
    public function testType()
    {
        $post = new Post();
        $this->assertEquals('', $post->getType());
    }

    public function testSetType()
    {
        $post = new Post();

        $post->setType('type1');
        $this->assertEquals('type1', $post->getType());
    }

    public function testSetPermalink()
    {
        $post = new Post();

        $post->setPermalink('url1');
        $this->assertEquals('url1', $post->getPermalink());
    }

    public function testSetIsPermalinkPage()
    {
        $post = new Post();

        $this->assertFalse($post->getIsPermalinkPage());

        $post->setIsPermalinkPage(true);
        $this->assertTrue($post->getIsPermalinkPage());
    }

    public function testSetDateTime()
    {
        $dt = new DateTime('2001-02-03 04:05:06');

        $post = new Post();
        $post->setDateTime($dt);

        $this->assertEquals('2001-02-03 04:05:06', $post->getDateTime()->format('Y-m-d H:i:s'));
    }

    public function testSetNotes()
    {
        $post = new Post();

        $this->assertEquals(array(), $post->getNotes());

        $post->setNotes(array('node1', 'node2'));
        $this->assertEquals(array('node1', 'node2'), $post->getNotes());
    }

    public function testSetTags()
    {
        $post = new Post();

        $this->assertEquals(array(), $post->getTags());

        $post->setTags(array('tag1', 'tag2'));
        $this->assertEquals(array('tag1', 'tag2'), $post->getTags());
    }

    public function testSetPostId()
    {
        $post = new Post();

        $post->setPostId(24);
        $this->assertEquals(24, $post->getPostId());
    }

    public function testSetTitle()
    {
        $post = new Post();

        $post->setTitle('title1');
        $this->assertEquals('title1', $post->getTitle());
    }
}
