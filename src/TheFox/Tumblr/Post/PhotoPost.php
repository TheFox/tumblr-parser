<?php

namespace TheFox\Tumblr\Post;

class PhotoPost extends Post
{
    /**
     * @var string
     */
    private $url = '';

    /**
     * @var string
     */
    private $alt = '';

    /**
     * @var string
     */
    private $link = '';

    /**
     * @var string
     */
    private $caption = '';

    public function __construct()
    {
        $this->setType('photo');
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $link
     */
    public function setLinkUrl($link)
    {
        $this->link = $link;
    }

    /**
     * @return  string
     */
    public function getLinkUrl()
    {
        return $this->link;
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
}
