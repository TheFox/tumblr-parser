<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\VariableElement;

class VariableElementTest extends TestCase
{
    public function testRender()
    {
        $element = new VariableElement();
        $element->setContent('cont1');

        $html = $element->render();
        $this->assertEquals('cont1', $html);
    }
}
