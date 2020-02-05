<?php

namespace App\Domain\Account\Action;

use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Generic\Action\EntityPersistAction;
use App\Domain\Account\Entity\Account;

class DeleteAccountAction extends EntityPersistAction
{
    public function execute(Account $Account): BaseEntity
    {
        return $this->removeEntity($Account);
    }
}
