<?php

namespace TheFox\Tumblr\Post;

class PhotosetPost extends Post
{
    /**
     * @var string
     */
    private $caption = '';

    /**
     * @var array
     */
    private $photos = [];

    public function __construct()
    {
        $this->setType('photoset');
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param array $photos
     */
    public function setPhotos(array $photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return array
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }
}
