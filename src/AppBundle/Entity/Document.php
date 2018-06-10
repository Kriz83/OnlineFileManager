<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 */
class Document
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
     *     minMessage="Nazwa pliku jest za krótka",
     *     maxMessage="Nazwa pliku jest za długa",
	 * )
	 * @Assert\Regex(
	 *     pattern="/[^A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ_\-\s][^0-9]/",
     *     match=false,
     *     message="Nazwa pliku powinna składać się wyłącznie z liter i cyfr"
     * )
     */
    private $fileName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $fileExtension;

    /**
     * @var \AppBundle\Entity\Catalogue
     */
    private $catalogs;
    
    /**
     * Constructor
     */
    public function __construct()
    {
		$this->setCreatedAt(new \DateTime());
    }

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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Document
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set catalogs
     *
     * @param \AppBundle\Entity\Catalogue $catalogs
     *
     * @return Document
     */
    public function setCatalogs(\AppBundle\Entity\Catalogue $catalogs = null)
    {
        $this->catalogs = $catalogs;

        return $this;
    }

    /**
     * Get catalogs
     *
     * @return \AppBundle\Entity\Catalogue
     */
    public function getCatalogs()
    {
        return $this->catalogs;
    }

    /**
     * Set fileExtension
     *
     * @param string $fileExtension
     *
     * @return Document
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Get fileExtension
     *
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }
    /**
     * @var \AppBundle\Entity\GroupName
     */
    private $groupName;


    /**
     * Set groupName
     *
     * @param \AppBundle\Entity\GroupName $groupName
     *
     * @return Document
     */
    public function setGroupName(\AppBundle\Entity\GroupName $groupName = null)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return \AppBundle\Entity\GroupName
     */
    public function getGroupName()
    {
        return $this->groupName;
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
     * @return Document
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
