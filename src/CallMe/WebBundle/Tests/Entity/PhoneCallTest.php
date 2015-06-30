<?php

namespace CallMe\WebBundle\Tests\Entity;

use CallMe\WebBundle\Entity\PhoneCall;
use CallMe\WebBundle\Entity\User;

class PhoneCallTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneCall
     */
    protected $phonecall;

    /**
     * @var User|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $userMock;

    protected function setUp()
    {
        $this->userMock = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $this->phonecall = new PhoneCall(
            1,
            '3c9d22c8-83f4-11e4-b116-123b93f75cba',
            $this->userMock,
            'phone call',
            new \DateTime('2014-12-14 00:00:00'),
            new \DateTime('2014-12-14 00:00:00'),
            true
        );
    }

    public function testSetId()
    {
        $this->phonecall->setId(11);
        $this->assertEquals(11, $this->phonecall->getId());
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->phonecall->getId());
    }

    public function testGetUuid()
    {
        $this->assertEquals('3c9d22c8-83f4-11e4-b116-123b93f75cba', $this->phonecall->getUuid());
    }

    public function testGetUser()
    {
        $this->assertEquals($this->userMock, $this->phonecall->getUser());
    }

    public function testGetName()
    {
        $this->assertEquals('phone call', $this->phonecall->getName());
    }
}
