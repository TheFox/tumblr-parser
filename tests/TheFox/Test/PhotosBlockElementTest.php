<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Element\Post\PhotosBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LinkUrlBlockElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Post\PhotoPost;

class PhotosBlockElementTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $photos = [];

        $subElement = new PhotoPost();
        $subElement->setUrl('url1');
        $subElement->setAlt('alt1');
        $subElement->setLinkUrl('url2');
        $subElement->setCaption('cap1');
        $photos[] = $subElement;

        $element1 = new PhotosBlockElement();
        $element1->setContent($photos);

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
}
