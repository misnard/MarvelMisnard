<?php

use \Marvel\Model\MarvelApiClientModel;

class ApiClientTest extends PHPUnit_Framework_TestCase
{


    public function testApiWithError()
    {
        try {
            (new MarvelApiClientModel())
                    ->apiConnector('test');
        } catch (Exception $e) {
            $this->fail($e);
        }
    }

    public function testApiWithSuccess()
    {


        //$this->assertEquals(4, "");
    }

    public function testConstructUrl()
    {

    }

}
