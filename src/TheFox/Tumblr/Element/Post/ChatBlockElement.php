<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Post\ChatPost;

class ChatBlockElement extends PostBlockElement
{
    public function setElementsValues()
    {
        #parent::setElementsValues();

        $post = $this->getContent();
        if ($post instanceof ChatPost) {
            foreach ($this->getChildren(true) as $element) {
                $elementName = strtolower($element->getTemplateName());

                if ($element instanceof VariableElement) {
                    if ($elementName == 'title') {
                        $element->setContent($post->getTitle());
                    }
                } elseif ($element instanceof LinesBlockElement) {
                    $element->setContent($post->getChats());
                }
            }
        }
    }
}
