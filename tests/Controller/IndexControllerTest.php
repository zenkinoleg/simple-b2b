<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testAbout()
    {
        $this->setName('About endpoint status 200');
        $client = static::createClient();

        $client->request('GET', '/');
/*
        $data = json_decode(
            $client->getResponse()->getContent(),
            true
        );
        dd($data['Data']['Application']);
*/
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testNonExistingUrl()
    {
        $this->setName('Non-existing endpoint status 404');
        $client = static::createClient();

        $client->request('GET', '/non-existing/url');

        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}
