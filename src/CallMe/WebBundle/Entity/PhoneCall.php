<?php

namespace CallMe\WebBundle\Entity;

class PhoneCall
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var user
     */
    protected $user;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var boolean
     */
    protected $isActive;

    /**
     * @param $id
     * @param $uuid
     * @param User $user
     * @param $name
     * @param \DateTime $createAt
     * @param \DateTime $updatedAt
        * @param $isActive
    * @throws \InvalidArgumentException
        */
    public function __construct($id, $uuid, User $user, $name,\DateTime $createAt,\DateTime $updatedAt, $isActive)
    {
        if ( count($name) > 50 ) {
            throw new \InvalidArgumentException('User name is greater than 50 characters');
        }

        $this->id = $id;
        $this->uuid = $uuid;
        $this->user = $user;
        $this->name = $name;
        $this->createdAt = $createAt;
        $this->updatedAt = $updatedAt;
        $this->isActive = $isActive;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }
}
