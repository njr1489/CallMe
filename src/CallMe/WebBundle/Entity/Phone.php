<?php

namespace CallMe\WebBundle\Entity;

use Symfony\Bridge\Doctrine\Tests\Fixtures\User;

class Phone
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
     * @var string
     */
    protected $filePath;

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
    protected $delete;

    /**
     * @param $id
     * @param $uuid
     * @param User $user
     * @param $name
     * @param $filePath
     * @param $createAt
     * @param $updatedAt
     * @param $delete
     */
    public function __construct($id, $uuid, User $user, $name, $filePath, $createAt, $updatedAt, $delete)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->user = $user;
        $this->name = $name;
        $this->filePath = $filePath;
        $this->createdAt = $createAt;
        $this->updatedAt = $updatedAt;
        $this->delete = $delete;
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
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
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
     * @param boolean $delete
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;
    }

    /**
     * @return boolean
     */
    public function getDelete()
    {
        return $this->delete;
    }
}
