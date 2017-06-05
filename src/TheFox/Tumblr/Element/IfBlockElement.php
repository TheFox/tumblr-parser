<?php

namespace TheFox\Tumblr\Element;

class IfBlockElement extends BoolBlockElement
{
    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return 'If' . $this->getName();
    }
}
