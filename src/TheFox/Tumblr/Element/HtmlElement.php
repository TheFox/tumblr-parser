<?php

namespace TheFox\Tumblr\Element;

class HtmlElement extends Element
{
    /**
     * @return mixed
     */
    public function render()
    {
        return $this->getContent();
    }
}
