<?php

namespace TheFox\Tumblr\Element;

class HtmlElement extends Element
{
    public function render()
    {
        return $this->getContent();
    }
}
