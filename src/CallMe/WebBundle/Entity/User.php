<?php

namespace CallMe\WebBundle\Entity;

class User
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $email;

    /** @var string */
    protected $password;

    /**
     * @param int $id
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @throws \InvalidArgumentException
     */
    public function __construct($id, $firstName, $lastName, $email, $password)
    {
        $this->id = $id;

        if (!$firstName) {
            throw new \InvalidArgumentException('The User\'s first name cannot be empty');
        }
        $this->firstName = $firstName;

        if (!$lastName) {
            throw new \InvalidArgumentException('The User\'s last name cannot be empty');
        }
        $this->lastName = $lastName;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('This is not a valid email address');
        }
        $this->email = $email;

        if (strlen($password) < 5) {
            throw new \InvalidArgumentException('The password must be five characters long');
        }
        $this->setPassword($password);
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    protected function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
