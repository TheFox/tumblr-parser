<?php

namespace TheFox\Test;

use PHPUnit_Framework_TestCase;
use TheFox\Tumblr\Element\Post\AnswerBlockElement;
use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Post\AnswerPost;

class AnswerBlockElementTest extends PHPUnit_Framework_TestCase
{
    public function testSetElementsValues()
    {
        $element2 = new AnswerPost();
        $element2->setAsker('asker1');
        $element2->setQuestion('quest1');
        $element2->setAnswer('answer1');

        $element1 = new AnswerBlockElement();
        $element1->setContent($element2);


        $subElement1 = new VariableElement();
        $subElement1->setName('asker');
        $element1->addChild($subElement1);

        $subElement2 = new VariableElement();
        $subElement2->setName('question');
        $element1->addChild($subElement2);

        $subElement3 = new VariableElement();
        $subElement3->setName('answer');
        $element1->addChild($subElement3);

        $element1->setElementsValues();

        $html = $element1->render();
        $this->assertEquals('asker1quest1answer1', $html);
    }
}
