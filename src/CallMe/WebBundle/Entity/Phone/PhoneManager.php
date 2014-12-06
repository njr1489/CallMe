<?php

namespace CallMe\WebBundle\Entity\Phone;

use CallMe\WebBundle\Core\AbstractManager;
use CallMe\WebBundle\Entity\Phone;
use CallMe\WebBundle\Entity\User;
use Rhumsaa\Uuid\Uuid;

class PhoneManager extends AbstractManager
{
    /**
     * @var PhoneFactory
     */
    protected $phoneFactory;

    /**
     * @param \PDO $db
     * @param PhoneFactory $phoneFactory
     */
    public function __construct(\PDO $db, PhoneFactory $phoneFactory)
    {
        parent::__construct($db);
        $this->phoneFactory = $phoneFactory;
    }

    /**
     * @param $id
     * @return Phone|null
     */
    public function fetchById($id)
    {
        $statement = $this->db->prepare('SELECT * FROM phone WHERE id = :id');
        $statement->bindValue('id', $id);
        $statement->execute();

        $phone = null;
        if ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $phone = $this->phoneFactory->create($data);
        }

        return $phone;
    }

    public function createPhoneCall(User $user, $name, $filePath, $remove = false)
    {
        $dateTime = new \DateTime();
        $data = [
            'uuid' => Uuid::uuid4(),
            'user' => $user,
            'name' => $name,
            'file_path' => $filePath,
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
            'remove' => $remove
        ];
        $call = $this->phoneFactory->create($data);

        $statement = $this->db->prepare(
            'INSERT INTO phone (uuid, user_id, `name`, file_path, created_at, updated_at)
            VALUES (:uuid, :user_id, :name, :file_path, :created_at, :updated_at, :$remove)'
        );
        $statement->bindValue('uuid', $call->getUuid());
        //TODO getId is not showing up
        $statement->bindValue('user_id', $call->getUser()->getId());
        $statement->bindValue('name', $call->getName());
        $statement->bindValue('file_path', $call->getFilePath());
        $statement->bindValue('created_at', $call->getCreatedAt()->format('Y-m-d h:i:s'));
        $statement->bindValue('updated_at', $call->getUpdatedAt()->format('Y-m-d h:i:s'));
        $statement->bindValue('remove', $call->getRemove());
        $statement->execute();
        $call->setId($this->db->lastInsertId());

        return $call;
    }

    public function fetchPhoneByUser(User $user)
    {
        $statement = $this->db->prepare('SELECT * FROM phone WHERE user_id = :user');

        $statement->bindValue('user', $user->getId());
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
