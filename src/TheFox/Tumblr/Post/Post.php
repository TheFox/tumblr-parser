<?php

namespace TheFox\Tumblr\Post;

use DateTime;

class Post
{
    /**
     * @var string
     */
    private $type = '';

    /**
     * @var string
     */
    private $permalink = '';

    /**
     * @var bool
     */
    private $isPermalinkPage = false;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var array
     */
    private $notes = array();

    /**
     * @var array
     */
    private $tags = array();

    /**
     * @var int
     */
    private $postId = 0;

    /**
     * @var string
     */
    private $title = '';

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $permalink
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * @param bool $isPermalinkPage
     */
    public function setIsPermalinkPage($isPermalinkPage)
    {
        $this->isPermalinkPage = $isPermalinkPage;
    }

    /**
     * @return bool
     */
    public function getIsPermalinkPage()
    {
        return $this->isPermalinkPage;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setDateTime(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param array $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param int $postId
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
