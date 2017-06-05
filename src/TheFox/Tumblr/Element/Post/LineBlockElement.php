<?php

namespace TheFox\Tumblr\Element\Post;

use TheFox\Tumblr\Element\VariableElement;
use TheFox\Tumblr\Element\LabelBlockElement;

class LineBlockElement extends PostBlockElement
{
    public function setElementsValues()
    {
        /** @var null|array $content */
        $content = $this->getContent();

        if (!$content || !is_array($content)) {
            return;
        }

        $hasLabel = isset($content['label']) && $content['label'];
        $label = $hasLabel ? $content['label'] : '';
        $line = isset($content['line']) && $content['line'] ? $content['line'] : '';
        $alt = isset($content['alt']) && $content['alt'] ? $content['alt'] : '';
        $name = isset($content['name']) && $content['name'] ? $content['name'] : '';
        $userNumber = isset($content['userNumber']) && $content['userNumber'] ? $content['userNumber'] : '';

        foreach ($this->getChildren(true) as $element) {
            $elementName = strtolower($element->getTemplateName());

            if ($element instanceof VariableElement) {
                if ($elementName == 'label') {
                    if ($hasLabel) {
                        $element->setContent($label);
                    }
                } elseif ($elementName == 'line') {
                    $element->setContent($line);
                } elseif ($elementName == 'alt') {
                    $element->setContent($alt);
                } elseif ($elementName == 'name') {
                    $element->setContent($name);
                } elseif ($elementName == 'usernumber') {
                    $element->setContent($userNumber);
                }
            } elseif ($element instanceof LabelBlockElement) {
                $element->setContent($hasLabel);
            }
        }
    }
}
