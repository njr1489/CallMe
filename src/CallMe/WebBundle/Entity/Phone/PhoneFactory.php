<?php

namespace CallMe\WebBundle\Entity\Phone;

use CallMe\WebBundle\Entity\Phone;

class PhoneFactory
{
    /**
     * @param array $data
     * @return Phone
     */
    public function create(array $data)
    {
        return new Phone(
            isset($data['id']) ? $data['id'] : null,
            $data['uuid'],
            $data['user'],
            $data['name'],
            $data['file_path'],
            $data['created_at'],
            $data['updated_at'],
            $data['remove']
        );
    }
}
