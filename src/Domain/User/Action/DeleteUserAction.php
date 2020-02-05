<?php

namespace App\Domain\User\Action;

use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Generic\Action\EntityPersistAction;
use App\Domain\User\Entity\User;

class DeleteUserAction extends EntityPersistAction
{
    /**
     * @param  \App\Domain\User\Entity\User  $user
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function execute(User $user): BaseEntity
    {
        return $this->removeEntity($user);
    }
}
