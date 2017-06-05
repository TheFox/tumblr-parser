<?php

namespace TheFox\Tumblr\Element;

class BoolBlockElement extends BlockElement
{
    /**
     * @return bool
     */
    public function getDefaultContent(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        if ($this->getContent()) {
            return parent::render();
        }
        return '';
    }
}
