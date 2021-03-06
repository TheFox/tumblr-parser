<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\DescriptionBlockElement;
use TheFox\Tumblr\Post\LinkPost;

class LinkBlockElement extends PostBlockElement
{
    public function setElementsValues()
    {
        /** @var LinkPost|null $post */
        $post = $this->getContent();

        if (!$post || !$post instanceof LinkPost) {
            return;
        }

        $hasDescription = (bool)$post->getDescription();
        foreach ($this->getChildren(true) as $element) {
            $elementName = strtolower($element->getTemplateName());

            if ($element instanceof VariableElement) {
                if ($elementName == 'url') {
                    $element->setContent($post->getUrl());
                } elseif ($elementName == 'name') {
                    $element->setContent($post->getName());
                } elseif ($elementName == 'target') {
                    $element->setContent($post->getTarget());
                } elseif ($elementName == 'description') {
                    $element->setContent($post->getDescription());
                }
            } elseif ($element instanceof DescriptionBlockElement) {
                $element->setContent($hasDescription);
            }
        }
    }
}
