<?php

namespace TheFox\Tumblr\Element;

use ReflectionClass;

class Element
{
    /**
     * @var int
     */
    private $id = 0;

    #private $type = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var mixed
     */
    private $content;

    /**
     * @var Element
     */
    private $parent;

    /**
     * @var array
     */
    protected $children = [];

    public function __construct()
    {
        $this->setContent($this->getDefaultContent());
    }

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

    /*public function setType($type){
        $this->type = $type;
    }
    
    public function getType(){
        return $this->type;
    }*/

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
        return $this->getName();
    }

    /**
     * @return null
     */
    public function getDefaultContent()
    {
        return null;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Element $parent
     */
    public function setParent(Element $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Element|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        $name = $this->getName();
        $rc = new ReflectionClass(get_class($this));
        $className = $rc->getShortName();

        if ($this->getParent()) {
            return $this->getParent()->getPath() . '->' . ($name ? $name : $className) . '[' . $this->getId() . ']';
        }

        return '' . ($name ? $name : $className) . '[' . $this->getId() . ']';
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @param Element $element
     */
    public function addChild(Element $element)
    {
        $this->children[] = $element;
        $element->setParent($this);
    }

    /**
     * @param bool $recursive
     * @return Element[]
     */
    public function getChildren(bool $recursive = false): array
    {
        if ($recursive) {
            $rv = [];
            foreach ($this->children as $element) {
                $rv[] = $element;
                $rv = array_merge($rv, $element->getChildren($recursive));
            }
            return $rv;
        } else {
            return $this->children;
        }
    }

    /**
     * @param array $children
     * @return string
     */
    public function renderChildren(array $children): string
    {
        $html = '';
        /** @var Element $element */
        foreach ($children as $element) {
            $html .= $element->render();
        }
        return $html;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->renderChildren($this->children);
    }
}
