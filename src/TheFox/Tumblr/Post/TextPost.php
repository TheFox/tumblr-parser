<?php

namespace TheFox\Tumblr\Post;

class TextPost extends Post
{
    /**
     * @var string
     */
    private $body = '';

    public function __construct()
    {
        $this->setType('text');
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
