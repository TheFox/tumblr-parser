<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\HtmlElement;

class HtmlElementTest extends TestCase
{

    public function testRender()
    {
        $element = new HtmlElement();
        $element->setContent('cont1');

        $html = $element->render();
        $this->assertEquals('cont1', $html);
    }

}
