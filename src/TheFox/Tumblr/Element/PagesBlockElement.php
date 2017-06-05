<?php

namespace TheFox\Tumblr\Element;

class PagesBlockElement extends BlockElement
{
    /**
     * @return string
     */
    public function render()
    {
        /** @var null|array $pages */
        $pages = $this->getContent();

        if (!$pages || !is_array($pages)) {
            return '';
        }
        
        $html = '';
        foreach ($pages as $page) {
            /** @var Element $element */
            foreach ($this->getChildren(true) as $element) {
                $elementName = strtolower($element->getTemplateName());
                if ($element instanceof VariableElement) {
                    if ($elementName == 'label' && isset($page['label'])) {
                        $element->setContent($page['label']);
                    } elseif ($elementName == 'url' && isset($page['url'])) {
                        $element->setContent($page['url']);
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
