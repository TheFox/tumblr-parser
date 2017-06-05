<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Post\LinesBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LabelBlockElement;

class LinesBlockElementTest extends TestCase
{
    public function testRender()
    {
        $element1 = new LinesBlockElement();
        $element1->setContent([
            ['name' => 'x1', 'label' => 'lab1'],
            ['name' => 'x2', 'label' => 'lab2'],
        ]);

        $subElement = new VariableElement();
        $subElement->setName('label');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('line');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('alt');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('name');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('usernumber');
        $element1->addChild($subElement);

        $subElement = new LabelBlockElement();
        $element1->addChild($subElement);

        $html = $element1->render();
        $this->assertEquals('lab1oddx11lab2evenx22', $html);
    }
}
