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
    private $photos = array();

    public function __construct()
    {
        $this->setType('photoset');
    }

    /**
     * @param string $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
