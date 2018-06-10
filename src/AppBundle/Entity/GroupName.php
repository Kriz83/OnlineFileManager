<?php

namespace AppBundle\Entity;

/**
 * GroupName
 */
class GroupName
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return GroupName
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userData;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userData = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userDatum
     *
     * @param \AppBundle\Entity\UserData $userDatum
     *
     * @return GroupName
     */
    public function addUserDatum(\AppBundle\Entity\UserData $userDatum)
    {
        $this->userData[] = $userDatum;

        return $this;
    }

    /**
     * Remove userDatum
     *
     * @param \AppBundle\Entity\UserData $userDatum
     */
    public function removeUserDatum(\AppBundle\Entity\UserData $userDatum)
    {
        $this->userData->removeElement($userDatum);
    }

    /**
     * Get userData
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserData()
    {
        return $this->userData;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $document;


    /**
     * Add document
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return GroupName
     */
    public function addDocument(\AppBundle\Entity\Document $document)
    {
        $this->document[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \AppBundle\Entity\Document $document
     */
    public function removeDocument(\AppBundle\Entity\Document $document)
    {
        $this->document->removeElement($document);
    }

    /**
     * Get document
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocument()
    {
        return $this->document;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $catalogue;


    /**
     * Add catalogue
     *
     * @param \AppBundle\Entity\Catalogue $catalogue
     *
     * @return GroupName
     */
    public function addCatalogue(\AppBundle\Entity\Catalogue $catalogue)
    {
        $this->catalogue[] = $catalogue;

        return $this;
    }

    /**
     * Remove catalogue
     *
     * @param \AppBundle\Entity\Catalogue $catalogue
     */
    public function removeCatalogue(\AppBundle\Entity\Catalogue $catalogue)
    {
        $this->catalogue->removeElement($catalogue);
    }

    /**
     * Get catalogue
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }
}
