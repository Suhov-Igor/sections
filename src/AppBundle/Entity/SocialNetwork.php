<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * SocialNetwork
 *
 * @ORM\Table(name="social_network")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class SocialNetwork
{
    const SERVER_PATH_TO_IMAGE_FOLDER = 'files';

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
     * @ORM\Column(name="link", type="string", length=255, nullable=false, unique=false)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="icon_url", type="string", length=255, nullable=false, unique=false)
     */
    private $iconUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="integer", nullable=false, unique=false)
     */
    private $position;

    /**
     * @var \AppBundle\Entity\ExternalSocialNetworks
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ExternalSocialNetworks", inversedBy="socialNetworks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="block_id", referencedColumnName="id")
     * })
     */
    private $block;

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
//    var_dump('setFile');exit();
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->link != null ? $this->link : 'SocialNetwork';
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
     * Set link.
     *
     * @param string $link
     *
     * @return SocialNetwork
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set iconUrl.
     *
     * @param string $iconUrl
     *
     * @return SocialNetwork
     */
    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    /**
     * Get iconUrl.
     *
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
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
     * Set block.
     *
     * @param \AppBundle\Entity\ExternalSocialNetworks|null $block
     *
     * @return SocialNetwork
     */
    public function setBlock(\AppBundle\Entity\ExternalSocialNetworks $block = null)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block.
     *
     * @return \AppBundle\Entity\ExternalSocialNetworks|null
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->upload();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate ()
    {
        $this->upload();
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

       $target = $this->getFile()->move(
           self::SERVER_PATH_TO_IMAGE_FOLDER,
           $this->getFile()->getClientOriginalName()
       );

       $this->iconUrl = $target->getPathName();

       $this->setFile(null);
    }

    public function toArray() {
        return [
            "id" => $this->id,
            "link" => $this->link,
            "icon" => [
                "url" => $this->iconUrl,
            ]
        ];
    }
}
