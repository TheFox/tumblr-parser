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
    private $notes = [];

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var int
     */
    private $postId = 0;

    /**
     * @var string
     */
    private $title = '';

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $permalink
     */
    public function setPermalink(string $permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * @return string
     */
    public function getPermalink(): string
    {
        return $this->permalink;
    }

    /**
     * @param bool $isPermalinkPage
     */
    public function setIsPermalinkPage(bool $isPermalinkPage)
    {
        $this->isPermalinkPage = $isPermalinkPage;
    }

    /**
     * @return bool
     */
    public function getIsPermalinkPage(): bool
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
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param array $notes
     */
    public function setNotes(array $notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return array
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param int $postId
     */
    public function setPostId(int $postId)
    {
        $this->postId = $postId;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
