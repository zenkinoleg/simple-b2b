<?php

namespace App\Tests\Controller;

use App\Domain\User\Action\CreateUserAction;
use App\Domain\User\DTO\UserData;
use App\Domain\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPersistenceTest extends KernelTestCase
{
    /**
     * We're actually gonna test all persistence's related actions:
     * validate,persist and remove
     *
     * @dataProvider usersDataSet
     *
     * @param $data
     */
    public function testCreateUserAction($data)
    {
        self::bootKernel();

        /** @var CreateUserAction $action */
        $action = $this::$container->get(CreateUserAction::class);
        $user   = (new User)->fill(
            UserData::fromArray($data)
        );

        // validate, then persist, then remove
        $action->removeEntity(
            $action->persistEntity(
                $action->validateEntity($user)
            )
        );

        $this->assertCount(
            $data['errors'],
            $user->getValidatorErrors(),
            'Invalid User: '.
            json_encode(
                $user->getValidatorErrors()
            )
        );
    }

    /**
     * List of all cases
     *
     * @return array
     */
    public function usersDataSet()
    {
        return [
            // invalid case, valid test
            [
                [
                    'errors' => 3
                ],
            ],
            // invalid case, valid test
            [
                [
                    'name'   => 'good user',
                    'email'  => 'bad#email',
                    'errors' => 1,
                ],
            ],
            // invalid case, valid test
            [
                [
                    'name'   => 'b@d user',
                    'email'  => 'good@email.com',
                    'errors' => 1,
                ],
            ],
            // invalid case, valid test
            [
                [
                    'name'   => 'b@d user',
                    'email'  => 'bad#email',
                    'errors' => 2,
                ],
            ],
            // valid case, valid test
            [
                [
                    'name'   => 'good user',
                    'email'  => 'good@email.com',
                    'errors' => 0,
                ],
            ],
        ];
    }
}