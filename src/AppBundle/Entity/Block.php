<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Block
 *
 * @ORM\Table(name="block")
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"subscription" = "Subscription", "externalSocialNetworks" = "ExternalSocialNetworks"})
 */
abstract class Block
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false, unique=false)
     */
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false, unique=false)
     */
    protected $position;

    /**
     * @var \AppBundle\Entity\Page
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Page", inversedBy="blocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     * })
     */
    protected $page;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->page != null ? $this->page->getName().'_Page_Block_Position_'.$this->position : 'Block_Position_'.$this->position;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Block
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return Block
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set page.
     *
     * @param \AppBundle\Entity\Page|null $page
     *
     * @return Block
     */
    public function setPage(\AppBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page.
     *
     * @return \AppBundle\Entity\Page|null
     */
    public function getPage()
    {
        return $this->page;
    }

    abstract public function toArray();
}
