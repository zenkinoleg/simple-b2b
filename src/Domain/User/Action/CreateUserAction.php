<?php

namespace App\Domain\User\Action;

use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Generic\Action\EntityPersistAction;
use App\Domain\User\Entity\User;
use App\Domain\User\DTO\UserData;

class CreateUserAction extends EntityPersistAction
{
    /**
     * @param  \App\Domain\User\DTO\UserData  $userData
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function execute(UserData $userData): BaseEntity
    {
        return $this->persistEntity(
            $this->validateEntity(
                (new User)->fill($userData)
            )
        );
    }
}
