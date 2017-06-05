<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\TitleBlockElement;
use TheFox\Tumblr\Post\TextPost;

class TextBlockElement extends PostBlockElement
{
    public function setElementsValues()
    {
        /** @var TextPost $post */
        $post = $this->getContent();

        if (!$post || !$post instanceof TextPost) {
            return;
        }

        $hasTitle = (bool)$post->getTitle();
        foreach ($this->getChildren(true) as $element) {
            $elementName = strtolower($element->getTemplateName());

            if ($element instanceof VariableElement) {
                if ($elementName == 'title') {
                    $element->setContent($post->getTitle());
                } elseif ($elementName == 'body') {
                    $element->setContent($post->getBody());
                }
            } elseif ($element instanceof TitleBlockElement) {
                $element->setContent($hasTitle);
            }
        }
    }
}
