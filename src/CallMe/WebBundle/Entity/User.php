<?php

namespace CallMe\WebBundle\Entity;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable, EquatableInterface
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

    /** @var string */
    protected $salt = '';

    /**
     * @param int $id
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $encodePassword
     * @throws \InvalidArgumentException
     */
    public function __construct($id, $firstName, $lastName, $email, $password, $encodePassword = true)
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
        $this->setPassword($password, $encodePassword);
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
     * @param bool $encodePassword
     */
    protected function setPassword($password, $encodePassword = true)
    {
        if ($encodePassword) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->password = $password;
    }

    /**
     * @return array|\Symfony\Component\Security\Core\Role\Role[]
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return null|string|void
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'salt' => ''
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->id = $data['id'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->email = $data['email'];
        $this->salt = '';
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        return $this->id === $user->getId();
    }
}
