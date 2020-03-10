<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false, unique=true)
     */
    private $slug;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SectionPage", mappedBy="page")
     */
    private $pageSections;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Block", mappedBy="page", cascade={"persist"})
     */
    private $blocks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pageSections = new ArrayCollection();
        $this->blocks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set name.
     *
     * @param string $name
     *
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add pageSection.
     *
     * @param \AppBundle\Entity\SectionPage $pageSection
     *
     * @return Page
     */
    public function addPageSection(\AppBundle\Entity\SectionPage $pageSection)
    {
        $this->pageSections[] = $pageSection;

        return $this;
    }

    /**
     * Remove pageSection.
     *
     * @param \AppBundle\Entity\SectionPage $pageSection
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePageSection(\AppBundle\Entity\SectionPage $pageSection)
    {
        return $this->pageSections->removeElement($pageSection);
    }

    /**
     * Get pageSections.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageSections()
    {
        return $this->pageSections;
    }

    /**
     * Add block.
     *
     * @param \AppBundle\Entity\Block $block
     *
     * @return Page
     */
    public function addBlock(\AppBundle\Entity\Block $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * Remove block.
     *
     * @param \AppBundle\Entity\Block $block
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBlock(\AppBundle\Entity\Block $block)
    {
        return $this->blocks->removeElement($block);
    }

    /**
     * Get blocks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    public function toArray() : array {
        $blocks = $this->blocks->getIterator();
        $blocks->uasort(function ($a, $b) {
            return ($a->getPosition() >= $b->getPosition()) ? 1 : -1;
        });
        $blocksCollection = new ArrayCollection(iterator_to_array($blocks));

        $blocksResult = [];
        foreach($blocksCollection as $Block) {
            $blocksResult[] = $Block->toArray();
        }

        return [
            "page" => [
                "id" => $this->id,
                "name" => $this->name,
                "blocks" => $blocksResult
            ]
        ];
    }
}
