<?php

namespace CallMe\WebBundle\Core;

abstract class AbstractManager
{
    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}