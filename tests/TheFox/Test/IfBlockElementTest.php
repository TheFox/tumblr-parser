<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\IfBlockElement;

class IfBlockElementTest extends TestCase
{

    public function testGetTemplateName()
    {
        $element = new IfBlockElement();
        $element->setName('name1');

        $this->assertEquals('Ifname1', $element->getTemplateName());
    }

}
