<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Post\PostBlockElement;

class PostBlockElementTest extends TestCase
{
    public function testRender()
    {
        $element = new PostBlockElement();

        $html = $element->render();
        $this->assertEquals('', $html);
    }
}
