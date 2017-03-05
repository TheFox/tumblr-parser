<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Post\PhotosetPost;

class PhotosetPostTest extends PHPUnit_Framework_TestCase{
	
	public function testType(){
		$post = new PhotosetPost();
		$this->assertEquals('photoset', $post->getType());
	}
	
	public function testSetCaption(){
		$post = new PhotosetPost();
		
		$post->setCaption('cap1');
		$this->assertEquals('cap1', $post->getCaption());
	}
	
	public function testSetPhotos(){
		$post = new PhotosetPost();
		
		$this->assertEquals(array(), $post->getPhotos());
		
		$post->setPhotos(array('photo1', 'photo2'));
		$this->assertEquals(array('photo1', 'photo2'), $post->getPhotos());
	}
	
}
