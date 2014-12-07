<?php

namespace CallMe\WebBundle\Tests\Entity;

use CallMe\WebBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var DateTime
     */
    protected $dateTime;

    protected function setUp()
    {
        $this->dateTime = new \DateTime('+2 days');
        $this->user = new User(1, 'Walter', 'Bermudez', 'WB@hotmail.com', 'password', true, '9496ktg', $this->dateTime);
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

    public function testSetPassword()
    {
        $this->user->setPassword('password');
        $this->assertTrue(password_verify('password', $this->user->getPassword()));
    }

    public function testGetRoles()
    {
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
    }

    public function testGetSalt()
    {
        $this->assertEmpty($this->user->getSalt());
    }

    public function testGetUsername()
    {
        $this->assertEquals('WB@hotmail.com', $this->user->getEmail());
    }

    public function testGetPasswordResetToken()
    {
        $this->assertEquals('9496ktg', $this->user->getPasswordResetToken());
    }

    public function testGetPasswordResetExpiration()
    {
        $this->assertEquals($this->dateTime, $this->user->getPasswordResetExpiration());
    }

    public function testSerialize()
    {
        $this->assertEquals(serialize(['id'=>1, 'first_name'=>'Walter', 'last_name'=>'Bermudez', 'email'=>'WB@hotmail.com', 'salt'=>'']), $this->user->serialize());
    }
}
