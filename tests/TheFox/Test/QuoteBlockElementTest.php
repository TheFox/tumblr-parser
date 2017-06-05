<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Post\QuoteBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\SourceBlockElement;
use TheFox\Tumblr\Post\QuotePost;

class QuoteBlockElementTest extends TestCase
{
    public function testSetElementsValues()
    {
        $element2 = new QuotePost();
        $element2->setQuote('quo1');
        $element2->setSource('source1');
        $element2->setLength('len1');

        $element1 = new QuoteBlockElement();
        $element1->setContent($element2);

        $subElement = new VariableElement();
        $subElement->setName('quote');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('source');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('length');
        $element1->addChild($subElement);

        $subElement = new SourceBlockElement();
        $element1->addChild($subElement);

        $html = $element1->render();
        $this->assertEquals('quo1source1len1', $html);
    }
}
