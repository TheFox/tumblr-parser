<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Post\PhotoBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LinkUrlBlockElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Post\PhotoPost;

class PhotoBlockElementTest extends TestCase
{
    public function testSetElementsValues1()
    {
        $element2 = new PhotoPost();
        $element2->setUrl('url1');
        $element2->setAlt('alt1');
        $element2->setLinkUrl('url2');
        $element2->setCaption('cap1');

        $element1 = new PhotoBlockElement();
        $element1->setContent($element2);

        $subElement = new VariableElement();
        $subElement->setName('photourl-500');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('photoalt');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('linkurl');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('caption');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('linkopentag');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('linkclosetag');
        $element1->addChild($subElement);

        $subElement = new LinkUrlBlockElement();
        $element1->addChild($subElement);

        $subElement = new CaptionBlockElement();
        $element1->addChild($subElement);

        $html = $element1->render();
        $this->assertEquals('url1alt1url2cap1<a href="url2"></a>', $html);
    }

    public function testSetElementsValues2()
    {
        $element2 = new PhotoPost();
        $element2->setPermalink('perm1');
        $element2->setUrl('url1');
        $element2->setAlt('alt1');
        $element2->setCaption('cap1');

        $element1 = new PhotoBlockElement();
        $element1->setContent($element2);

        $subElement = new VariableElement();
        $subElement->setName('photourl-500');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('photoalt');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('linkurl');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('caption');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('linkopentag');
        $element1->addChild($subElement);

        $subElement = new VariableElement();
        $subElement->setName('linkclosetag');
        $element1->addChild($subElement);

        $subElement = new LinkUrlBlockElement();
        $element1->addChild($subElement);

        $subElement = new CaptionBlockElement();
        $element1->addChild($subElement);

        $html = $element1->render();
        $this->assertEquals('url1alt1perm1cap1<a href="perm1"></a>', $html);
    }
}
