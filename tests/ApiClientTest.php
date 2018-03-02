<?php

use \Marvel\Model\MarvelApiClientModel;

class ApiClientTest extends PHPUnit_Framework_TestCase
{


    public function testApiWithError()
    {
        try {
            (new MarvelApiClientModel())
                    ->getCharactersCollection();
        } catch (Exception $e) {
            $this->fail(sprintf("Failed asserting that element: %s does exist on page: %s",
                'ok', 'ok'
            ));
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
