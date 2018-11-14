<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CertificateApiTest extends TestCase
{

    public function testGenerate()
    {
        $data = $this->loadJSON('generate.json');
        //die($this->json('POST', '/certificates', $data)->response->getContent());
        $this->json('POST', '/certificates', $data)
            ->seeJson([
               'success' => true,
            ]);
    }


    public function testToggle()
    {
        $data = $this->loadJSON('toggle.json');
        //die($this->json('PATCH', '/certificates/1', $data)->response->getContent());
        $this->json('PATCH', '/certificates/1', $data)
            ->seeJson([
               'success' => true,
            ]);
    }

/*
    public function testList()
    {
        $this->json('GET', '/public_certificates/1/1')
            ->seeJson([

            ]);
    }
*/

    private function loadJSON($file) {
        $json = file_get_contents(__DIR__.'/json/'.$file);
        return json_decode($json, true);
    }
}
