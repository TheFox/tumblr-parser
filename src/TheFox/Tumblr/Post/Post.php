<?php

namespace TheFox\Tumblr\Post;

use DateTime;

class Post
{
    private $type = '';
    private $permalink = '';
    private $isPermalinkPage = false;
    private $dateTime = null;
    private $notes = array();
    private $tags = array();

    private $postId = 0;
    private $title = '';

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
    }

    public function getPermalink()
    {
        return $this->permalink;
    }

    public function setIsPermalinkPage($isPermalinkPage)
    {
        $this->isPermalinkPage = $isPermalinkPage;
    }

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

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
