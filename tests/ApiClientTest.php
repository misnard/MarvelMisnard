<?php

use \Marvel\Model\MarvelApiClientModel;

/**
 * Class ApiClientTest
 */
class ApiClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test Method Bad url format
     */
    public function testApiWithBadUrlError()
    {
        $this->expectExceptionMessage('Invalid Url : Bad format');
        $marvelApiModel = new MarvelApiClientModel();
        $marvelApiModel->apiConnector('badUrl');
    }

    /**
     * Test Method Bad api key
     */
    public function testApiWithoutApiKeyError()
    {
        $this->expectExceptionMessage('Invalid Url : Missed Api key');
        $marvelApiModel = new MarvelApiClientModel();
        $marvelApiModel->apiConnector('https://badUrl?hash=fake&ts=fake');
    }

    /**
     * Test Method Bad timestamp
     */
    public function testApiWithoutTimeStampError()
    {
        $this->expectExceptionMessage('Invalid Url : Missed TimeStamp');
        $marvelApiModel = new MarvelApiClientModel();
        $marvelApiModel->apiConnector('https://badUrl?hash=fake&apikey=fake');
    }

    /**
     * Test Method Bad hash
     */
    public function testApiWithoutHashError()
    {
        $this->expectExceptionMessage('Invalid Url : Missed Hash');
        $marvelApiModel = new MarvelApiClientModel();
        $marvelApiModel->apiConnector('https://badUrl?ts=fake&apikey=fake');
    }

    /**
     * Test Method Success Api call
     */
    public function testApiWithCallUrlSuccess()
    {
        $marvelApiModel = new MarvelApiClientModel();
        $apiResponce = $marvelApiModel->apiConnector($marvelApiModel->constructUrl('characters',
            array('limit' => '20', 'offset' => '100')));
        $this->assertEquals(200, $apiResponce->code);
        $this->assertEquals('Ok', $apiResponce->status);
    }

    /**
     * Test Method Error Api call
     */
    public function testApiWithCallUrlError()
    {
        $this->expectExceptionMessage('Error on api response code : ResourceNotFound');
        $marvelApiModel = new MarvelApiClientModel();
        $marvelApiModel->apiConnector($marvelApiModel->constructUrl('badType',
            array('limit' => '20', 'offset' => '100')));
    }
}
