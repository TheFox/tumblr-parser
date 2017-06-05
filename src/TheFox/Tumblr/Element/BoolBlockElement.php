<?php

namespace TheFox\Tumblr\Element;

class BoolBlockElement extends BlockElement
{
    /**
     * @return bool
     */
    public function getDefaultContent()
    {
        return false;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->getContent()) {
            return parent::render();
        }
        return '';
    }
}
