<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Post\PhotosetPost;

class PhotosetPostTest extends TestCase
{
    public function testType()
    {
        $post = new PhotosetPost();
        $this->assertEquals('photoset', $post->getType());
    }

    public function testSetCaption()
    {
        $post = new PhotosetPost();

        $post->setCaption('cap1');
        $this->assertEquals('cap1', $post->getCaption());
    }

    public function testSetPhotos()
    {
        $post = new PhotosetPost();

        $this->assertEquals([], $post->getPhotos());

        $post->setPhotos(['photo1', 'photo2']);
        $this->assertEquals(['photo1', 'photo2'], $post->getPhotos());
    }
}
