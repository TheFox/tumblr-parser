<?php

namespace TheFox\Tumblr\Post;

class QuotePost extends Post
{
    /**
     * @var string
     */
    private $quote = '';

    /**
     * @var string
     */
    private $source = '';

    /**
     * @var integer|string
     */
    private $length;

    public function __construct()
    {
        $this->setType('quote');
    }

    /**
     * @param string $quote
     */
    public function setQuote(string $quote)
    {
        $this->quote = $quote;
    }

    /**
     * @return string
     */
    public function getQuote(): string
    {
        return $this->quote;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param integer|string $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return integer|string
     */
    public function getLength()
    {
        return $this->length;
    }
}
