<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\BlockElement;

//use TheFox\Tumblr\Post\Post;

class PostBlockElement extends BlockElement
{
    public function setElementsValues()
    {
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->setElementsValues();

        return parent::render();
    }
}
