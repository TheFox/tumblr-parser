<?php

namespace TheFox\Tumblr\Post;

class AnswerPost extends Post
{
    /**
     * @var string
     */
    private $asker = '';

    /**
     * @var string
     */
    private $question = '';

    /**
     * @var string
     */
    private $answer = '';

    public function __construct()
    {
        $this->setType('answer');
    }

    /**
     * @param string $asker
     */
    public function setAsker(string $asker)
    {
        $this->asker = $asker;
    }

    /**
     * @return string
     */
    public function getAsker(): string
    {
        return $this->asker;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }
}
