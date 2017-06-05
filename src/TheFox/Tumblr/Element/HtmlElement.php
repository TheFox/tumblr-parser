<?php

namespace TheFox\Tumblr\Element;

class HtmlElement extends Element
{
    /**
     * @return string
     */
    public function render()
    {
        return $this->getContent();
    }
}
