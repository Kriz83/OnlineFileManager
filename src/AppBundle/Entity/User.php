<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
    * @ORM\Column(type="string")
    */
    private $name;
	
	/**
    * @ORM\Column(type="string")
    */
    protected $username;
	
    public function getId()
    {
		
        return $this->id;
		
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
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * @var \AppBundle\Entity\UserData
     */
    private $userData;


    /**
     * Set userData
     *
     * @param \AppBundle\Entity\UserData $userData
     *
     * @return User
     */
    public function setUserData(\AppBundle\Entity\UserData $userData = null)
    {
        $this->userData = $userData;

        return $this;
    }

    /**
     * Get userData
     *
     * @return \AppBundle\Entity\UserData
     */
    public function getUserData()
    {
        return $this->userData;
    }
    /**
     * @var \AppBundle\Entity\UserData
     */
    private $groupData;


    /**
     * Set groupData
     *
     * @param \AppBundle\Entity\UserData $groupData
     *
     * @return User
     */
    public function setGroupData(\AppBundle\Entity\UserData $groupData = null)
    {
        $this->groupData = $groupData;

        return $this;
    }

    /**
     * Get groupData
     *
     * @return \AppBundle\Entity\UserData
     */
    public function getGroupData()
    {
        return $this->groupData;
    }
}
