<?php

namespace TheFox\Tumblr\Element;

class TagsBlockElement extends BlockElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        /** @var null|array $tags */
        $tags = $this->getContent();

        if (!$tags || !is_array($tags)) {
            return '';
        }

        $html = '';
        foreach ($tags as $tag) {
            foreach ($this->getChildren(true) as $element) {
                $elementName = strtolower($element->getTemplateName());
                if ($element instanceof VariableElement) {
                    if ($elementName == 'tag') {
                        $element->setContent($tag);
                    } elseif ($elementName == 'tagurl') {
                        $element->setContent('?type=tag&id=' . $tag);
                    }
                }
            }
            foreach ($this->getChildren() as $element) {
                $html .= $element->render();
            }
        }

        return $html;
    }
}
