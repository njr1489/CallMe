<?php

namespace CallMe\WebBundle\Tests\Entity;
use CallMe\WebBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $user;

    protected function setUp()
    {
        $this->user = new User(1, 'Walter', 'Bermudez', 'WB@hotmail.com', 'password');
    }
    public function testGetId()
    {
        $this-> assertEquals(1, $this->user->getId());
    }

    public function testSetId()
    {
        $this->user->setId(2);

        $this->assertEquals(2, $this->user->getId());
    }

    public function testGetFirstName()
    {
        $this->assertEquals('Walter', $this->user->getFirstName());
    }

    public function testGetLastName()
    {
        $this->assertEquals('Bermudez', $this->user->getLastName());
    }

    public function testGetEmail()
    {
        $this->assertEquals('WB@hotmail.com', $this->user->getEmail());
    }

    public function testGetPassword()
    {
        $this->assertTrue(password_verify('password', $this->user->getPassword()));
    }
}
