<?php

namespace App\Domain\User\Action;

use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Generic\Action\EntityPersistAction;
use App\Domain\User\Entity\User;
use App\Domain\User\DTO\UserData;

class UpdateUserAction extends EntityPersistAction
{
    /**
     * @param  \App\Domain\User\Entity\User  $user
     * @param  \App\Domain\User\DTO\UserData  $userData
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function execute(User $user,UserData $userData): BaseEntity
    {
        return $this->persistEntity(
            $this->validateEntity(
                $user->fill($userData)
            )
        );
    }
}
