<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity
 */
class Section
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SectionPage", mappedBy="section")
     */
    private $sectionPages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Page")
     * @ORM\JoinTable(name="section_page",
     *      joinColumns={@ORM\JoinColumn(name="section_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id")}
     *      )
     */
    private $pages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sectionPages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Section
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
     * @return Section
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
     * Add sectionPage.
     *
     * @param \AppBundle\Entity\SectionPage $sectionPage
     *
     * @return Section
     */
    public function addSectionPage(\AppBundle\Entity\SectionPage $sectionPage)
    {
        $this->sectionPages[] = $sectionPage;

        return $this;
    }

    /**
     * Remove sectionPage.
     *
     * @param \AppBundle\Entity\SectionPage $sectionPage
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSectionPage(\AppBundle\Entity\SectionPage $sectionPage)
    {
        return $this->sectionPages->removeElement($sectionPage);
    }

    /**
     * Get sectionPages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSectionPages()
    {
        return $this->sectionPages;
    }

    /**
     * Add page.
     *
     * @param \AppBundle\Entity\Page $page
     *
     * @return Section
     */
    public function addPage(\AppBundle\Entity\Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page.
     *
     * @param \AppBundle\Entity\Page $page
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePage(\AppBundle\Entity\Page $page)
    {
        return $this->pages->removeElement($page);
    }

    /**
     * Get pages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }
}
