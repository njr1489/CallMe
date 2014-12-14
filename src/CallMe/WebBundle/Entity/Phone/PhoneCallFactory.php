<?php

namespace CallMe\WebBundle\Entity\Phone;

use CallMe\WebBundle\Entity\PhoneCall;

class PhoneCallFactory
{
    /**
     * @param array $data
     * @return PhoneCall
     */
    public function create(array $data)
    {
        return new PhoneCall(
            isset($data['id']) ? $data['id'] : null,
            $data['uuid'],
            $data['user'],
            $data['name'],
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at']),
            $data['is_active']
        );
    }
}
