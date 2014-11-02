<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 10/20/14
 * Time: 7:46 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Entity;

class Audio
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
     * @var User
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
     * @param $id
     * @param $uuid
     * @param User $user
     * @param $name
     * @param $filePath
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     */
    public function __construct($id, $uuid, User $user, $name, $filePath, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->user = $user;
        $this->name = $name;
        $this->filePath = $filePath;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param $id
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
}
