<?php

namespace AppBundle\Entity;

/**
 * FileToUpload
 */
class FileToUpload
{
    /**
     * @var int
     */
    private $id;


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
     * @var string
     */
    private $description;

    /**
     * Set description
     *
     * @param string $description
     *
     * @return FilesToUpload
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
     * @var string
     */
    private $newFile;

    /**
     * Set newFile
     *
     * @param string $newFile
     *
     * @return FilesToUpload
     */
    public function setNewFile($newFile)
    {
        $this->newFile = $newFile;
    
        return $this;
    }

    /**
     * Get newFile
     *
     * @return string
     */
    public function getNewFile()
    {
        return $this->newFile;
    }
}

