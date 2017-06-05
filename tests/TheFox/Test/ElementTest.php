<?php

namespace TheFox\Test;

use PHPUnit\Framework\TestCase;
use TheFox\Tumblr\Element\Element;
use TheFox\Tumblr\Element\HtmlElement;

class ElementTest extends TestCase
{

    public function testConstruct()
    {
        $element = new Element();

        $this->assertEquals(null, $element->getDefaultContent());
        $this->assertEquals($element->getDefaultContent(), $element->getContent());
    }

    public function testSetId()
    {
        $element = new Element();

        $element->setId(1);
        $this->assertEquals(1, $element->getId());
    }

    public function testSetName()
    {
        $element = new Element();

        $element->setName('name1');
        $this->assertEquals('name1', $element->getName());
    }

    public function testGetTemplateName()
    {
        $element = new Element();

        $element->setName('name1');
        $this->assertEquals('name1', $element->getTemplateName());
    }

    public function testSetContent()
    {
        $element = new Element();

        $element->setContent('cont1');
        $this->assertEquals('cont1', $element->getContent());
    }

    public function testSetParent()
    {
        $parent = new Element();
        $element = new Element();

        $element->setParent($parent);
        $this->assertEquals($parent, $element->getParent());
    }

    public function testGetPath1()
    {
        $element = new Element();

        $this->assertEquals('Element[0]', $element->getPath());
    }

    public function testGetPath2()
    {
        $element1 = new Element();
        $element1->setId(1);
        $element2 = new Element();
        $element2->setId(2);

        $element2->setParent($element1);

        $this->assertEquals('Element[1]', $element1->getPath());
        $this->assertEquals('Element[1]->Element[2]', $element2->getPath());
    }

    public function testSetChildren1()
    {
        $element1 = new Element();

        $this->assertEquals([], $element1->getChildren());
    }

    public function testSetChildren2()
    {
        $element1 = new Element();
        $element2 = new Element();
        $element3 = new Element();

        $element1->setChildren([$element2, $element3]);
        $this->assertEquals([$element2, $element3], $element1->getChildren());
    }

    public function testAddChild()
    {
        $element1 = new Element();
        $element2 = new Element();
        $element3 = new Element();

        $element1->addChild($element2);
        $this->assertEquals([$element2], $element1->getChildren());

        $element1->addChild($element3);
        $this->assertEquals([$element2, $element3], $element1->getChildren());
    }

    public function testGetChildren()
    {
        $element1 = new Element();
        $element2 = new Element();
        $element3 = new Element();
        $element4 = new Element();

        $element3->addChild($element4);

        $element1->setChildren([$element2, $element3]);
        $this->assertEquals([$element2, $element3], $element1->getChildren());
        $this->assertEquals([$element2, $element3, $element4], $element1->getChildren(true));
    }

    public function testRenderChildren1()
    {
        $element1 = new Element();
        $element2 = new HtmlElement();
        $element3 = new HtmlElement();
        $element4 = new HtmlElement();

        $element3->addChild($element4);
        $element1->setChildren([$element2, $element3]);

        $this->assertEquals('', $element1->renderChildren($element1->getChildren()));
    }

    public function testRenderChildren2()
    {
        $element1 = new Element();
        $element2 = new HtmlElement();
        $element3 = new HtmlElement();

        $element1->setChildren([$element2, $element3]);

        $element2->setContent('el2');
        $element3->setContent('el3');

        $this->assertEquals('el2el3', $element1->renderChildren($element1->getChildren()));
    }

    public function testRender()
    {
        $element1 = new Element();

        $this->assertEquals('', $element1->render());
    }

}
