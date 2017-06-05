<?php

namespace TheFox\Tumblr\Element;

class VariableElement extends Element
{
    /**
     * @return string
     */
    public function render()
    {
        return $this->getContent();
    }
}
