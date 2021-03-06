<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\TagsBlockElement;
use TheFox\Tumblr\Element\VariableElement;

class TagsBlockElementTest extends TestCase
{
    public function testRender()
    {
        $element1 = new TagsBlockElement();
        $element1->setContent(['tag1', 'tag_2']);

        $varTag = new VariableElement();
        $varTag->setName('tag');

        $varUrl = new VariableElement();
        $varUrl->setName('tagurl');

        $element1->addChild($varTag);
        $element1->addChild($varUrl);

        $html = $element1->render();
        $this->assertEquals('tag1?type=tag&id=tag1tag_2?type=tag&id=tag_2', $html);
    }
}
