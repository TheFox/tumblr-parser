<?php

namespace TheFox\Tumblr;

class Variable
{
    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $templateName = '';

    /**
     * @var string
     */
    private $ifName = '';

    /**
     * @var string
     */
    private $ifNotName = '';

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $reference;

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;

        $this->ifName = $name;

        $namecmp = strtolower($name);
        if (substr($namecmp, 0, 3) == 'if:') {
            $this->ifName = substr($this->ifName, 3);
            $name = str_replace(' ', '', $name);
            $name = 'If' . substr($name, 3);
            $this->type = 'bool';
        } elseif (substr($namecmp, 0, 5) == 'text:') {
            $this->ifName = substr($this->ifName, 5);
            $this->type = 'text';
        }

        $this->ifName = str_replace(' ', '', $this->ifName);
        $this->ifNotName = 'IfNot' . $this->ifName;
        $this->ifName = 'If' . $this->ifName;

        $this->templateName = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * @return string
     */
    public function getIfName(): string
    {
        return $this->ifName;
    }

    /**
     * @return string
     */
    public function getIfNotName(): string
    {
        return $this->ifNotName;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;

        if (is_string($value)) {
            $this->type = 'text';
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
}
