<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\CaptionBlockElement;
use TheFox\Tumblr\Post\PhotosetPost;

class PhotosetBlockElement extends PostBlockElement
{
    public function setElementsValues()
    {
        $post = $this->getContent();
        if ($post && $post instanceof PhotosetPost) {
            $hasCapation = (bool)$post->getCaption();
            foreach ($this->getChildren(true) as $element) {
                $elementName = strtolower($element->getTemplateName());

                if ($element instanceof VariableElement) {
                    if ($elementName == 'caption') {
                        $element->setContent($post->getCaption());
                    }
                } elseif ($element instanceof CaptionBlockElement) {
                    $element->setContent($hasCapation);
                } elseif ($element instanceof PhotosBlockElement) {
                    $element->setContent($post->getPhotos());
                }
            }
        }
    }
}
