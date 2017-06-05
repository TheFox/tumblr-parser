<?php

namespace TheFox\Tumblr\Element\Post;

class PhotosBlockElement extends PhotoBlockElement
{
    /**
     * @return string
     */
    public function render()
    {
        /** @var null|array $photos */
        $photos = $this->getContent();

        if (!$photos || !is_array($photos)) {
            return '';
        }

        $html = '';
        foreach ($photos as $photoId => $photo) {
            $this->setContent($photo);
            $this->setElementsValues();
            
            $html .= parent::render();
        }

        // Reset original content.
        $this->setContent($photos);

        return $html;
    }
}
