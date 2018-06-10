<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Catalogue
 */
class Catalogue
{
    /**
     * @var int
     */
    private $id;

   
    /**
     * @ORM\Column(type="string")
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Nazwa katalogu jest za krótka",
     *     maxMessage="Nazwa katalogu jest za długa",
	 * )
	 * @Assert\Regex(
	 *     pattern="/[^A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ_\-\s][^0-9]/",
     *     match=false,
     *     message="Nazwa katalogu powinna składać się wyłącznie z liter i cyfr"
     * )
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    
    /**
     * @var string
     */
    private $groupName;


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
     * @var integer
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $document;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->document = new \Doctrine\Common\Collections\ArrayCollection();
		$this->setCreatedAt(new \DateTime());
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Catalogue
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
     * Set path
     *
     * @param array $path
     *
     * @return Catalogue
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return array
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     *
     * @return Catalogue
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set groupName
     *
     * @param array $groupName
     *
     * @return Catalogue
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return array
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Add document
     *
     * @param \AppBundle\Entity\Document $document
     *
     * @return Catalogue
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
     * @var \DateTime
     */
    private $createdAt;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Catalogue
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
