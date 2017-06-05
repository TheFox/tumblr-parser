<?php

namespace TheFox\Tumblr\Element;

class VariableElement extends Element
{
    /**
     * @return mixed
     */
    public function render()
    {
        $content = $this->getContent();
        return $content;
    }
}
