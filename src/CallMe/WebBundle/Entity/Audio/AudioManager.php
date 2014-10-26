<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 10/20/14
 * Time: 7:48 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Entity\Audio;

use CallMe\WebBundle\Entity\Audio;
use CallMe\WebBundle\Core\AbstractManager;
use \Rhumsaa\Uuid\Uuid;

class AudioManager extends AbstractManager
{
    /**
     * @var AudioFactory
     */
    protected $audioFactory;

    /**
     * @param \PDO $db
     * @param AudioFactory $audioFactory
     */
    public function __construct(\PDO $db, AudioFactory $audioFactory)
    {
        parent::__construct($db);
        $this->audioFactory = $audioFactory;
    }

    /**
     * @param $id
     * @return Audio|null
     */
    public function fetchById($id)
    {
        $statement = $this->db->prepare('SELECT * FROM audio WHERE id = :id');
        $statement->bindValue('id', $id);
        $statement->execute();

        $audio = null;
        if ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $audio = $this->audioFactory->create($data);
        }

        return $audio;
    }

    /**
     * @param $user
     * @param $name
     * @param $filePath
     * @return Audio
     */
    public function createAudio($user, $name, $filePath)
    {
        $dateTime = new \DateTime();
        $data = [
            'uuid' => Uuid::uuid4(),
            'user'=> $user,
            'name' => $name,
            'file_path' => $filePath,
            'created_at' => $dateTime,
            'updated_at' => $dateTime
        ];
        $audio = $this->audioFactory->create($data);

        $statement = $this->db->prepare(
            'INSERT INTO audio (uuid, user_id, name, file_path, created_at, updated_at)
            VALUES (:uuid, :user_id, :name, :file_path, :created_at, :updated_at)'
        );
        $statement->bindValue('uuid', $audio->getUuid());
        $statement->bindValue('user_id', $audio->getUser()->getId());
        $statement->bindValue('name', $audio->getName());
        $statement->bindValue('file_path', $audio->getFilePath());
        $statement->bindValue('created_at', $audio->getCreatedAt()->format('Y-m-d h:i:s'));
        $statement->bindValue('updated_at', $audio->getUpdatedAt()->format('Y-m-d h:i:s'));
        $statement->execute();
        $audio->setId($this->db->lastInsertId());

        return $audio;
    }

}