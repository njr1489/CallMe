<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 9/28/14
 * Time: 6:32 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Service;

use Aws\S3\S3Client;
use CallMe\WebBundle\Entity\Audio;
use CallMe\WebBundle\Entity\User;
use CallMe\WebBundle\Entity\Audio\AudioManager;

class UploadAudio
{
    /**
     * @var AudioManager
     */
    protected $audioManager;
    /**
     * @var S3Client
     */
    protected $s3Client;

    /**
     * @param AudioManager $audioManager
     * @param S3Client $s3Client
     */
    public function __construct(AudioManager $audioManager, S3Client $s3Client)
    {
        $this->audioManager = $audioManager;
        $this->s3Client = $s3Client;
    }

    /**
     * @param $name
     * @param $audioFile
     * @param User $user
     * @return Audio
     * @throws \InvalidArgumentException
     */
    public function uploadAudio($name, $audioFile, User $user)
    {
        $bucket = 'user-' . $user->getId();

        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);

        if ($fileInfo->file($audioFile) != 'audio/mpeg') {
            throw new \InvalidArgumentException('Audio file is not an mp3');
        }

        if (!$this->s3Client->doesBucketExist($bucket)) {
            $this->s3Client->createBucket(['Bucket' => $bucket]);
        }

        $response = $this->s3Client->putObject([
            'Bucket'       => $bucket,
            'Key'          => $name, // @TODO: Figure out randomized name
            'SourceFile'   => $audioFile,
            'ContentType'  => 'audio/x-mpeg-3'
        ]);

        return $this->audioManager->createAudio($user, $name, $response['ObjectURL']);
    }

    /**
     * @param Audio $audio
     * @return bool
     */
    public function deleteAudio(Audio $audio)
    {
        $response = $this->s3Client->deleteObject([
            'Bucket'        => 'user-' . $audio->getUser()->getId(),
            'Key'           => $audio->getName()
        ]);

        if ($response['DeleteMarker']) {
            $this->audioManager->deleteAudio($audio);
            return true;
        }
        return false;
    }
}
