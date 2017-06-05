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
    public function setAsker($asker)
    {
        $this->asker = $asker;
    }

    /**
     * @return string
     */
    public function getAsker()
    {
        return $this->asker;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
