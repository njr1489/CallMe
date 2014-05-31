<?php

namespace CallMe\WebBundle\Entity\User;

use CallMe\WebBundle\Core\AbstractManager;

class UserManager extends AbstractManager
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
     * @return \CallMe\WebBundle\Entity\User|null
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
}
