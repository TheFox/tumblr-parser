<?php

namespace TheFox\Tumblr;

class Variable
{
    private $id = 0;
    private $type = '';
    private $name = '';
    private $templateName = '';
    private $ifName = '';
    private $ifNotName = '';
    private $value = '';
    private $reference = null;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setName($name)
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

    public function getName()
    {
        return $this->name;
    }

    public function getTemplateName()
    {
        return $this->templateName;
    }

    public function getIfName()
    {
        return $this->ifName;
    }

    public function getIfNotName()
    {
        return $this->ifNotName;
    }

    public function setValue($value)
    {
        $this->value = $value;

        if (is_string($value)) {
            $this->type = 'text';
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getReference()
    {
        return $this->reference;
    }
}
