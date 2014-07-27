<?php

namespace CallMe\WebBundle\Entity\User;

use CallMe\WebBundle\Entity\User;

class UserFactory
{
    /**
     * @param array $params
     * @return User
     */
    public function create(array $params)
    {
        return new User(
            isset($params['id']) ? $params['id'] : null,
            $params['first_name'],
            $params['last_name'],
            $params['email'],
            $params['password'],
            isset($params['encode_password']) ? $params['encode_password'] : true
        );
    }
}
