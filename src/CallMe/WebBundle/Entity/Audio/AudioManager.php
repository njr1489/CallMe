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
use CallMe\WebBundle\Entity\User;
use CallMe\WebBundle\Entity\User\UserFactory;
use CallMe\WebBundle\Core\AbstractManager;
use \Rhumsaa\Uuid\Uuid;

class AudioManager extends AbstractManager
{
    /**
     * @var AudioFactory
     */
    protected $audioFactory;
    protected $userFactory;

    /**
     * @param \PDO $db
     * @param AudioFactory $audioFactory
     * @param UserFactory $userFactory
     */
    public function __construct(\PDO $db, AudioFactory $audioFactory, UserFactory $userFactory)
    {
        parent::__construct($db);
        $this->audioFactory = $audioFactory;
        $this->userFactory = $userFactory;
    }

    /**
     * @param $id
     * @return Audio|null
     */
    public function fetchById($id)
    {
        $statement = $this->db->prepare(
            'SELECT a.id AS audio_id, a.name, a.uuid, a.created_at AS audio_created_at, a.updated_at AS audio_updated_at, a.file_path,
            u.id AS user_id, u.first_name, u.last_name, u.email, u.password, u.created_at AS user_created_at,
            u.updated_at AS user_updated_at, u.password_reset_token, u.password_reset_expiration_date
            FROM audio a INNER JOIN users u ON u.id = a.user_id WHERE a.id = :id'
        );
        $statement->bindValue('id', $id);
        $statement->execute();

        $audio = null;
        if ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $user = $this->userFactory->create([
                'id' => $data['user_id'],
                'first_name' =>$data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'encode_password' => false,
                'password_reset_token' => $data['password_reset_token'],
                'password_reset_expiration_date' => $data['password_reset_expiration_date']
            ]);
            $audio = $this->audioFactory->create([
                'id' => $data['audio_id'],
                'uuid' => $data['user_id'],
                'user' => $user,
                'name' => $data['name'],
                'file_path' => $data['file_path'],
                'created_at' => new \DateTime($data['audio_created_at']),
                'updated_at' => new \DateTime($data['audio_updated_at'])
            ]);
        }

        return $audio;
    }

    /**
     * @param $user
     * @param $name
     * @param $filePath
     * @return Audio
     */
    public function createAudio(User $user, $name, $filePath)
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
            'INSERT INTO audio (uuid, user_id, `name`, file_path, created_at, updated_at)
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

    /**
     * @param Audio $audio
     */
    public function deleteAudio(Audio $audio)
    {
        $statement = $this->db->prepare('DELETE FROM audio WHERE id = :id');
        $statement->bindValue('id', $audio->getId());
        $statement->execute();
    }

    /**
     * @param User $user
     * @return array
     */
    public function fetchAudioByUser(User $user)
    {
        $statement = $this->db->prepare('SELECT * FROM audio WHERE user_id = :user');

        $statement->bindValue('user', $user->getId());
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
