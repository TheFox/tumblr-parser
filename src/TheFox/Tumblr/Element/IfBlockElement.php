<?php

namespace TheFox\Tumblr\Element;

class IfBlockElement extends BoolBlockElement
{
    /**
     * @return string
     */
    public function getTemplateName()
    {
        return 'If' . $this->getName();
    }
}
