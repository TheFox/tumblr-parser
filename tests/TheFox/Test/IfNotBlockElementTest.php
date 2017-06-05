<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\IfNotBlockElement;

class IfNotBlockElementTest extends TestCase
{

    public function testGetTemplateName()
    {
        $element = new IfNotBlockElement();
        $element->setName('name1');

        $this->assertEquals('IfNotname1', $element->getTemplateName());
    }

}
