<?php

namespace TheFox\Tumblr\Element;

class BoolBlockElement extends BlockElement
{
    public function getDefaultContent()
    {
        return false;
    }

    public function render()
    {
        if ($this->getContent()) {
            return parent::render();
        }
        return '';
    }
}
