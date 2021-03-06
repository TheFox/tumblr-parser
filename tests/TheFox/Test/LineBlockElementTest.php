<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Post\LineBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LabelBlockElement;

class LineBlockElementTest extends TestCase
{
    public function testRenderWithContent()
    {
        $element1 = new LineBlockElement();
        $element1->setContent([
            'label' => 'lab1',
            'line' => 'line1',
            'alt' => 'alt1',
            'name' => 'name1',
            'usernumber' => 'usernumber1',
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
        $this->assertEquals('lab1line1alt1name1', $html);
    }
    
    public function testRenderWithoutContent(){
        $element1 = new LineBlockElement();
        $html = $element1->render();
        $this->assertEquals('', $html);
    }
}
