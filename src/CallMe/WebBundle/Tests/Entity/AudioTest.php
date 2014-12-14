<?php

namespace CallMe\WebBundle\Tests\Entity;

use CallMe\WebBundle\Entity\Audio;
use CallMe\WebBundle\Entity\User;

class AudioTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Audio
     */
    protected $audio;
    /**
     * @var userMock
     */
    protected $userMock;

    protected function setUp()
    {
        $this->userMock = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $this->audio = new Audio(
            1,
            'hfj45dj3-fjf4-jg88-fjg830jd873e',
            $this->userMock,
            'audio',
            '/audio/test',
            new \DateTime('2014-10-10 00:00:00'),
            new \DateTime('2014-10-10 00:00:00')
        );
    }

    public function testSetId()
    {
        $this->audio->setId(10);
        $this->assertEquals(10, $this->audio->getId());
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->audio->getId());
    }

    public function testGetUuId()
    {
        $this->assertEquals('hfj45dj3-fjf4-jg88-fjg830jd873e', $this->audio->getUuid());
    }

    public function testGetUser()
    {
        $this->assertEquals($this->userMock, $this->audio->getUser());
    }

    public function testGetName()
    {
        $this->assertEquals('audio', $this->audio->getName());
    }

    public function testGetFilePath()
    {
        $this ->assertEquals('/audio/test', $this->audio->getFilePath());
    }
}
