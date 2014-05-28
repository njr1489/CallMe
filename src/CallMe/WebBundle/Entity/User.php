<?php

namespace CallMe\WebBundle\Entity;

class User
{
    /** @var int */
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }
}