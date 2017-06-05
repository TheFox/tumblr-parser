<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Post\AnswerPost;

class AnswerBlockElement extends PostBlockElement
{
    public function setElementsValues()
    {
        #parent::setElementsValues();

        $post = $this->getContent();
        if ($post instanceof AnswerPost) {
            #$hasTitle = (bool)$post->getTitle();
            foreach ($this->getChildren(true) as $element) {
                $elementName = strtolower($element->getTemplateName());

                if ($element instanceof VariableElement) {
                    if ($elementName == 'asker') {
                        $element->setContent($post->getAsker());
                    } elseif ($elementName == 'question') {
                        $element->setContent($post->getQuestion());
                    } elseif ($elementName == 'answer') {
                        $element->setContent($post->getAnswer());
                    }
                }
            }
        }
    }
}
