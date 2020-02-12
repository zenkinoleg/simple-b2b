<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private const USER_CREATE = '{"name":"Charles Bronson","email":"good.email@mail.com"}';
    private const USER_UPDATE = '{"name":"Charles Bronson Jr.","email":"good.email@mail.com"}';
    private const NON_EXISTING_ID = 8972634;

    public static $user_id;

    public function testUsersList()
    {
        $this->setName('Users list endpoint return array');
        $client = static::createClient();

        $client->request('GET', '/users');

        $data = json_decode(
            $client->getResponse()
                   ->getContent(),
            true
        );

        $this->assertIsArray(
            $data['Data'] ?? null
        );
    }

    /**
     * @dataProvider invalidUsersDataSet
     *
     * @param $data
     */
    public function testCreateInvalidUser($data)
    {
        $this->setName('Create invalid user');
        $client = static::createClient();

        $client->request(
            'POST',
            '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertEquals(
            400,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function testCreateValidUser()
    {
        $this->setName('Create valid user');
        $client = static::createClient();

        $client->request(
            'POST',
            '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            self::USER_CREATE
        );
        $data = json_decode(
            $client->getResponse()
                   ->getContent(),
            true
        );
        self::$user_id = $data['Data']['id'] ?? 0;

        $this->assertEquals(
            201,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function testUpdateExistingUser()
    {
        $this->setName('Update existing user');
        $client = static::createClient();
        $client->request(
            'PUT',
            '/users/'.self::$user_id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            self::USER_UPDATE
        );

        $this->assertEquals(
            201,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function testCreateExistingUser()
    {
        $this->setName('Create existing user');
        $client = static::createClient();

        $client->request(
            'POST',
            '/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            self::USER_UPDATE
        );

        $this->assertEquals(
            400,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function testDeleteExistingUser()
    {
        $this->setName('Delete existing user');
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/users/'.self::$user_id
        );

        $this->assertEquals(
            204,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function testUpdateNonExistingUser()
    {
        $this->setName('Update non-existing user');
        $client = static::createClient();
        $client->request(
            'PUT',
            '/users/'.self::NON_EXISTING_ID,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            self::USER_UPDATE
        );

        $this->assertEquals(
            404,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function testDeleteNonExistingUser()
    {
        $this->setName('Delete non-existing user');
        $client = static::createClient();

        $client->request(
            'DELETE',
            '/users/'.self::NON_EXISTING_ID
        );

        $this->assertEquals(
            404,
            $client->getResponse()
                   ->getStatusCode()
        );
    }

    public function invalidUsersDataSet()
    {
        return [
            [
                [
                ],
            ],
            [
                [
                    'name' => 'good name',
                ],
            ],
            [
                [
                    'email' => 'good@email.com',
                ],
            ],
            [
                [
                    'name'  => 'good user',
                    'email' => 'bad#email',
                ],
            ],
            [
                [
                    'name'  => 'b@d user',
                    'email' => 'good@email.com',
                ],
            ],
            [
                [
                    'name'  => 'b@d user',
                    'email' => 'bad#email',
                ],
            ],
        ];
    }
}
