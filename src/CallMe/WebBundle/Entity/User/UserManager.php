<?php

namespace CallMe\WebBundle\Entity\User;

use CallMe\WebBundle\Core\AbstractManager;
use CallMe\WebBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Serializer\Exception\UnsupportedException;

class UserManager extends AbstractManager implements UserProviderInterface
{
    /** @var \CallMe\WebBundle\Entity\User\UserFactory */
    protected $userFactory;

    /**
     * @param \PDO $db
     * @param UserFactory $userFactory
     */
    public function __construct(\PDO $db, UserFactory $userFactory)
    {
        parent::__construct($db);
        $this->userFactory = $userFactory;
    }

    /**
     * @param $id
     * @return User|null
     */
    public function fetchById($id)
    {
        $smt = $this->db
            ->prepare('SELECT * FROM users WHERE id = :id');
        $smt->bindValue('id', $id);
        $smt->execute();

        $user = null;
        if ($data = $smt->fetch(\PDO::FETCH_ASSOC)) {
            $user = $this->userFactory->create($data);
        }
        return $user;
    }

    /**
     * @param array $data
     * @return \CallMe\WebBundle\Entity\User
     */
    public function createUser(array $data)
    {
        $user = $this->userFactory->create($data);

        $statement = $this->db->prepare(
            'INSERT INTO users (first_name, last_name, email, password)
            VALUES (:first_name, :last_name, :email, :password)'
        );
        $statement->bindValue('first_name', $user->getFirstName());
        $statement->bindValue('last_name', $user->getLastName());
        $statement->bindValue('email', $user->getEmail());
        $statement->bindValue('password', $user->getPassword());
        $statement->execute();
        $user->setId($this->db->lastInsertId());

        return $user;
    }

    /**
     * @param $username
     * @return User
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $statement = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue('email', $username);
        $statement->execute();

        if (!$data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        $data['encode_password'] = false;
        return $this->userFactory->create($data);
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     * @throws \Symfony\Component\Serializer\Exception\UnsupportedException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'CallMe\WebBundle\Entity\User';
    }
}
