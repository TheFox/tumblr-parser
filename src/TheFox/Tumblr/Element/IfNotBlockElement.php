<?php

namespace TheFox\Tumblr\Element;

class IfNotBlockElement extends BoolBlockElement
{
    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return 'IfNot' . $this->getName();
    }

    /**
     * @return bool
     */
    public function getDefaultContent(): bool
    {
        return true;
    }
}
