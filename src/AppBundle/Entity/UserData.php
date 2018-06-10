<?php

namespace AppBundle\Entity;

/**
 * UserData
 */
class UserData
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
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $groupData;


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
     * @return UserData
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
     * Set surname
     *
     * @param string $surname
     *
     * @return UserData
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return UserData
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set groupData
     *
     * @param integer $groupData
     *
     * @return UserData
     */
    public function setGroupData($groupData)
    {
        $this->groupData = $groupData;

        return $this;
    }

    /**
     * Get groupData
     *
     * @return int
     */
    public function getGroupData()
    {
        return $this->groupData;
    }
    /**
     * @var integer
     */
    private $active;


    /**
     * Set active
     *
     * @param integer $active
     *
     * @return UserData
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @var \AppBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserData
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \AppBundle\Entity\User
     */
    private $userDetails;


    /**
     * Set userDetails
     *
     * @param \AppBundle\Entity\User $userDetails
     *
     * @return UserData
     */
    public function setUserDetails(\AppBundle\Entity\User $userDetails = null)
    {
        $this->userDetails = $userDetails;

        return $this;
    }

    /**
     * Get userDetails
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserDetails()
    {
        return $this->userDetails;
    }
    /**
     * @var \AppBundle\Entity\User
     */
    private $userId;


    /**
     * Set userId
     *
     * @param \AppBundle\Entity\User $userId
     *
     * @return UserData
     */
    public function setUserId(\AppBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
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
     * @return UserData
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
}
