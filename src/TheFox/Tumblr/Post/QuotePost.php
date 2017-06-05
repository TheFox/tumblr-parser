<?php

namespace TheFox\Tumblr\Post;

class QuotePost extends Post
{
    private $quote = '';
    private $source = '';
    private $length = '';

    public function __construct()
    {
        $this->setType('quote');
    }

    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    public function getQuote()
    {
        return $this->quote;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getLength()
    {
        return $this->length;
    }
}
