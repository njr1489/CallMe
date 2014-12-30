<?php

namespace CallMe\WebBundle\Entity\Phone;

use CallMe\WebBundle\Core\AbstractManager;
use CallMe\WebBundle\Entity\PhoneCall;
use CallMe\WebBundle\Entity\User;
use Rhumsaa\Uuid\Uuid;

class PhoneCallManager extends AbstractManager
{
    /**
     * @var PhoneCallFactory
     */
    protected $phoneFactory;

    /**
     * @param \PDO $db
     * @param PhoneCallFactory $phoneFactory
     */
    public function __construct(\PDO $db, PhoneCallFactory $phoneFactory)
    {
        parent::__construct($db);
        $this->phoneFactory = $phoneFactory;
    }

    /**
     * @param $id
     * @return PhoneCall|null
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

    /**
     * @param User $user
     * @param $name
     * @param array $audioIds
     * @return PhoneCall
     */
    public function createPhoneCall(User $user, $name, array $audioIds)
    {
        $dateTime = new \DateTime();
        $data = [
            'uuid' => Uuid::uuid4(),
            'user' => $user,
            'name' => $name,
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
            'is_active' => true
        ];
        $call = $this->phoneFactory->create($data);

        $this->db->beginTransaction();
        $statement = $this->db->prepare(
            'INSERT INTO phone_calls (uuid, user_id, `name`, created_at, updated_at, is_active)
            VALUES (:uuid, :user_id, :name, :created_at, :updated_at, :is_active)'
        );
        $statement->bindValue('uuid', $call->getUuid());
        $statement->bindValue('user_id', $call->getUser()->getId());
        $statement->bindValue('name', $call->getName());
        $statement->bindValue('created_at', $call->getCreatedAt()->format('Y-m-d h:i:s'));
        $statement->bindValue('updated_at', $call->getUpdatedAt()->format('Y-m-d h:i:s'));
        $statement->bindValue('is_active', $call->isActive());
        $statement->execute();
        $call->setId($this->db->lastInsertId());

        $rows = [];
        foreach ($audioIds as $index => $audioId) {
            $rows[] = sprintf('(%d, %s, %d)', $user->getId(), $this->db->quote($audioId), $index + 1);
        }

        $this->db->query('INSERT INTO phone_call_audio (user_id, audio_id, position) VALUES ' . implode(',', $rows));
        $this->db->commit();

        return $call;
    }

    /**
     * @param User $user
     * @return array
     */
    public function fetchPhoneByUser(User $user)
    {
        $statement = $this->db->prepare('SELECT * FROM phone WHERE user_id = :user');

        $statement->bindValue('user', $user->getId());
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
