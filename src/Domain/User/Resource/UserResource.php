<?php

namespace App\Domain\User\Resource;

use App\Domain\Account\Resource\AccountResource;
use App\Domain\User\Entity\User;

final class UserResource
{
    /**
     * @param  \App\Domain\User\Entity\User  $user
     *
     * @return array
     */
    public static function item(User $user)
    {
        $resource = [
            'id'         => $user->getId(),
            'name'       => $user->getName(),
            'email'      => $user->getEmail(),
            'created_at' => $user->getCreatedAt()
                                 ->format('Y-m-d h a'),
        ];
        if ( !empty($user->getAccounts()->toArray()) ) {
            $resource['accounts'] = AccountResource::collection(
                $user->getAccounts()->toArray()
            );
        }

        return $resource;
    }

    /**
     * @param  array  $users
     *
     * @return array
     */
    public static function collection(array $users)
    {
        return array_map(function($user){
            return static::item($user);
        },$users);
    }
}