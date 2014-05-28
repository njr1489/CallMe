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
        return new User($params['id']);
    }
}