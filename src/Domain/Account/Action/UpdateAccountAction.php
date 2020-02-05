<?php

namespace App\Domain\Account\Action;

use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Generic\Action\EntityPersistAction;
use App\Domain\Account\Entity\Account;
use App\Domain\Account\DTO\AccountData;
use App\Domain\User\Entity\User;

class UpdateAccountAction extends EntityPersistAction
{
    /**
     * @param  \App\Domain\Account\DTO\AccountData  $accountData
     * @param  \App\Domain\Account\Entity\Account  $account
     * @param  \App\Domain\User\Entity\User  $user
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function execute(AccountData $accountData, Account $account, ?User $user): BaseEntity
    {
        return $this->persistEntity(
            $this->validateEntity(
                $account
                    ->fill($accountData)
                    ->setUser($user)
            )
        );
    }
}
