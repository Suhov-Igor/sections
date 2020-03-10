<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Entity
 */
class Subscription extends Block
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="button_title", type="string", length=255, nullable=false, unique=false)
     */
    private $buttonTitle;


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Subscription
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set buttonTitle.
     *
     * @param string $buttonTitle
     *
     * @return Subscription
     */
    public function setButtonTitle($buttonTitle)
    {
        $this->buttonTitle = $buttonTitle;

        return $this;
    }

    /**
     * Get buttonTitle.
     *
     * @return string
     */
    public function getButtonTitle()
    {
        return $this->buttonTitle;
    }

    public function toArray() {
        return [
            "name" => self::class,
            "props" => [
                "title" => $this->title,
                "buttonTitle" => $this->buttonTitle,
            ]
        ];
    }
}
