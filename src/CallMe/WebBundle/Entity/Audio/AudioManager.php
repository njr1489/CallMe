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

    public function createAudio(array $data)
    {
        $audio = $this->audioFactory->create($data);

        $statement = $this->db->prepare(
            'INSERT INTO audio(uuid, user_id, name, file_path)
            VALUES (:uuid, :user_id, :name, :file_path)'
        );
        $statement->bindValue('uuid', $audio->getUuid());
        $statement->bindValue('user_id', $audio->getUser()->getId());
        $statement->bindValue('name', $audio->getName());
        $statement->bindValue('file_path', $audio->getFilePath());
        $statement->execute();
        $audio->setId($this->db->lastInsertId());

        return $audio;
    }

}