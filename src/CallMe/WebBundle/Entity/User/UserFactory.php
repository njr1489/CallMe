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
            isset($params['encode_password']) ? $params['encode_password'] : true,
            isset($params['password_reset_token']) ? $params['password_reset_token'] : null,
            isset($params['password_reset_expiration_date']) ? new \DateTime($params['password_reset_expiration_date']) : null
        );
    }
}
