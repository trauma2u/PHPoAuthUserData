<?php

namespace OAuth\Unit\UserData\Extractor;

use OAuth\UserData\Extractor\Instagram;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-02-10 at 16:20:53.
 */
class InstagramTest extends \PHPUnit_Framework_TestCase
{
    const PROFILE_RESPONSE =
'{
  "meta":  {
    "code": 200
  },
  "data":  {
    "username": "johnnydonny",
    "bio": "A life on the edge",
    "website": "http://blog.johnnydonny.com",
    "profile_picture": "http://images.ak.instagram.com/profiles/profile_weird_numbers.jpg",
    "full_name": "John Doe",
    "counts":  {
      "media": 131,
      "followed_by": 80,
      "follows": 64
    },
    "id": "1111222333"
  }
}';

    /**
     * @var Instagram
     */
    protected $extractor;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->extractor = new Instagram();
        $service = $this->getMockBuilder('\\OAuth\\OAuth2\\Service\\Instagram')
            ->disableOriginalConstructor()
            ->getMock();
        $service->expects($this->any())
            ->method('request')
            ->with(Instagram::REQUEST_PROFILE)
            ->will($this->returnValue(InstagramTest::PROFILE_RESPONSE));
        /**
         * @var \OAuth\Common\Service\ServiceInterface $service
         */
        $this->extractor->setService($service);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testDoesNotSupportEmail()
    {
        $this->assertFalse($this->extractor->supportsEmail());
        $this->assertNull($this->extractor->getEmail());
    }

    public function testDoesNotSupportVerifiedEmail()
    {
        $this->assertFalse($this->extractor->supportsVerifiedEmail());
        $this->assertNull($this->extractor->isEmailVerified());
    }

    public function testDoesNotSupportLocation()
    {
        $this->assertFalse($this->extractor->supportsLocation());
        $this->assertNull($this->extractor->getLocation());
    }

    public function testGetUniqueId()
    {
        $this->assertEquals('1111222333', $this->extractor->getUniqueId());
    }

    public function testUsername()
    {
        $this->assertEquals('johnnydonny', $this->extractor->getUsername());
    }

    public function testGetFirstName()
    {
        $this->assertEquals('John', $this->extractor->getFirstName());
    }

    public function testGetLastName()
    {
        $this->assertEquals('Doe', $this->extractor->getLastName());
    }

    public function testGetFullName()
    {
        $this->assertEquals('John Doe', $this->extractor->getFullName());
    }

    public function testGetDescription()
    {
        $this->assertEquals('A life on the edge', $this->extractor->getDescription());
    }

    public function testGetImageUrl()
    {
        $this->assertEquals('http://images.ak.instagram.com/profiles/profile_weird_numbers.jpg', $this->extractor->getImageUrl());
    }

    public function testGetProfileUrl()
    {
        $this->assertEquals('http://instagram.com/johnnydonny', $this->extractor->getProfileUrl());
    }

    public function testGetWebsites()
    {
        $expected = array(
            'http://blog.johnnydonny.com'
        );
        $this->assertEquals($expected, $this->extractor->getWebsites());
    }

    public function testGetExtras()
    {
        $extras = $this->extractor->getExtras();
        $this->assertArrayHasKey('counts', $extras);

        $this->assertArrayNotHasKey('id', $extras);
        $this->assertArrayNotHasKey('bio', $extras);
        $this->assertArrayNotHasKey('website', $extras);
    }
}
