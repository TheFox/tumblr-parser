<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\PagesBlockElement;
use TheFox\Tumblr\Element\VariableElement;

class PagesBlockElementTest extends TestCase
{
    public function testRenderWithContent()
    {
        $element1 = new PagesBlockElement();
        $element1->setContent([
            ['label' => 'l1', 'url' => 'u1'],
            ['label' => 'l2', 'url' => 'u2'],
        ]);

        $varLabel = new VariableElement();
        $varLabel->setName('label');

        $varUrl = new VariableElement();
        $varUrl->setName('url');

        $element1->addChild($varLabel);
        $element1->addChild($varUrl);

        $html = $element1->render();
        $this->assertEquals('l1u1l2u2', $html);
    }
    
    public function testRenderWithoutContent(){
        $element1 = new PagesBlockElement();
        $html = $element1->render();
        $this->assertEquals('', $html);
    }
}
