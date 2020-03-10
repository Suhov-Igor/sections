<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * ExternalSocialNetworks
 *
 * @ORM\Entity
 */
class ExternalSocialNetworks extends Block
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SocialNetwork", mappedBy="block", cascade={"persist"})
     */
    private $socialNetworks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->socialNetworks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add socialNetwork.
     *
     * @param \AppBundle\Entity\SocialNetwork $socialNetwork
     *
     * @return ExternalSocialNetworks
     */
    public function addSocialNetwork(\AppBundle\Entity\SocialNetwork $socialNetwork)
    {
        $this->socialNetworks[] = $socialNetwork;

        return $this;
    }

    /**
     * Remove socialNetwork.
     *
     * @param \AppBundle\Entity\SocialNetwork $socialNetwork
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSocialNetwork(\AppBundle\Entity\SocialNetwork $socialNetwork)
    {
        return $this->socialNetworks->removeElement($socialNetwork);
    }

    /**
     * Get socialNetworks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSocialNetworks()
    {
        return $this->socialNetworks;
    }

    public function toArray() {
        $socialNetworks = $this->socialNetworks->getIterator();
        $socialNetworks->uasort(function ($a, $b) {
            return ($a->getPosition() >= $b->getPosition()) ? 1 : -1;
        });
        $socialNetworksCollection = new ArrayCollection(iterator_to_array($socialNetworks));

        $socialNetworksResult = [];
        foreach($socialNetworksCollection as $SocialNetwork) {
            $socialNetworksResult[] = $SocialNetwork->toArray();
        }
        return [
            "name" => self::class,
            "props" => [
                "socialNetworks" => $socialNetworksResult,
            ]
        ];
    }
}
