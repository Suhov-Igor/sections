<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SectionPage
 *
 * @ORM\Table(name="section_page")
 * @ORM\Entity
 */
class SectionPage
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
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false, unique=false)
     */
    private $position;

    /**
     * @var \AppBundle\Entity\Section
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Section", inversedBy="sectionPages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     * })
     */
    private $section;

    /**
     * @var \AppBundle\Entity\Page
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Page", inversedBy="pageSections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     * })
     */
    private $page;


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
     * Set position.
     *
     * @param int $position
     *
     * @return SectionPage
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
     * Set section.
     *
     * @param \AppBundle\Entity\Section|null $section
     *
     * @return SectionPage
     */
    public function setSection(\AppBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section.
     *
     * @return \AppBundle\Entity\Section|null
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set page.
     *
     * @param \AppBundle\Entity\Page|null $page
     *
     * @return SectionPage
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

    /**
         * Get page.
         *
         * @return \AppBundle\Entity\Page|null
     */
    public function getName()
    {
        return $this->page->getName();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->page->getName();
    }
}
