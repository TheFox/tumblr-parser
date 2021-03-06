<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Post\PhotosetBlockElement;
use TheFox\Tumblr\Element\Post\PhotosBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Post\PhotosetPost;

class PhotosetBlockElementTest extends TestCase
{
    public function testSetElementsValues()
    {
        $photos = [];

        $element2 = new PhotosetPost();
        $element2->setCaption('capt1');
        $element2->setPhotos($photos);

        $element1 = new PhotosetBlockElement();
        $element1->setContent($element2);

        $subElement = new VariableElement();
        $subElement->setName('caption');
        $element1->addChild($subElement);

        $subElement = new CaptionBlockElement();
        $element1->addChild($subElement);

        $subElement = new PhotosBlockElement();
        $element1->addChild($subElement);

        $html = $element1->render();
        $this->assertEquals('capt1', $html);
    }
}
