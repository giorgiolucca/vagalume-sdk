<?php

namespace VagalumeSdk\Tests;

use VagalumeSdk\Enum\TypeEnum;
use VagalumeSdk\Vagalume;

class VagalumeTest extends \PHPUnit_Framework_TestCase
{
    private $apiKey = '660a4395f992ff67786584e238f501aa';
    private $sdk;

    public function setUp()
    {
        $this->sdk = new Vagalume($this->apiKey);
    }

    /**
     * @expectedException VagalumeSdk\Exception\VagalumeSdkNullOrEmptyException
     */
    public function testGetArtistWithoutName()
    {
        $this->getSdk()->getArtist('');
    }

    /**
     * @expectedException VagalumeSdk\Exception\VagalumeSdkNotFoundException
     */
    public function testGetArtistNotFound()
    {
        $this->getSdk()->getArtist('Lorem ipsum dat amet');
    }

    public function testGetArtistHasKey()
    {
        $response = json_decode($this->getSdk()->getArtist('u2'), true);

        $this->assertArrayHasKey('artist', $response);
    }

    public function testGetArtist()
    {
        $response = json_decode($this->getSdk()->getArtist('u2'), true);
        $artist = $response['artist'];

        $this->assertEquals($artist['id'], '3ade68b2g3b86eda3');
    }

    public function testGetDiscographyHasKey()
    {
        $response = json_decode($this->getSdk()->getDiscography('u2'), true);

        $this->assertArrayHasKey('discography', $response);
    }

    public function testGetHotspotsHasKey()
    {
        $response = json_decode($this->getSdk()->getHotspots(), true);

        $this->assertArrayHasKey('hotspots', $response);
    }

    public function testGetNewsHasKey()
    {
        $response = json_decode($this->getSdk()->getNews(), true);

        $this->assertArrayHasKey('news', $response);
    }

    /**
     * @expectedException VagalumeSdk\Exception\VagalumeSdkInvalidTypeException
     */
    public function testGetRadiosWithInvalidType()
    {
        $this->getSdk()->getRadios(['hello'], '98fm');
    }

    public function testGetRadios()
    {
        $types = [ TypeEnum::ARTIST ];
        $radioName = 'coca-cola-fm';

        $response = json_decode($this->getSdk()->getRadios($types, $radioName), true);

        $this->assertTrue(! empty($response['art']) && $response['status'] === 'success');
    }

    public function testGetArtistImage()
    {
        $artistId = '3ade68b3gdb86eda3';
        $limit = 10;
        $response = json_decode($this->getSdk()->getArtistImage($artistId, $limit), true);

        $this->assertArrayHasKey('images', $response);
    }

    /**
     * @return Vagalume
     */
    private function getSdk()
    {
        return $this->sdk;
    }
}