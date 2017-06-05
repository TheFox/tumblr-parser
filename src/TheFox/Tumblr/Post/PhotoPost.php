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
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $alt
     */
    public function setAlt(string $alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return string
     */
    public function getAlt(): string
    {
        return $this->alt;
    }

    /**
     * @param string $link
     */
    public function setLinkUrl(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return  string
     */
    public function getLinkUrl(): string
    {
        return $this->link;
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
}
