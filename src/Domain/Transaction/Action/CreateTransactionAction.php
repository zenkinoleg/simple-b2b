<?php

namespace App\Domain\Transaction\Action;

use App\Domain\Account\Entity\Account;
use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Generic\Action\EntityPersistAction;
use App\Domain\Transaction\Entity\Transaction;
use App\Domain\Transaction\DTO\TransactionData;

class CreateTransactionAction extends EntityPersistAction
{
    /**
     * @param  \App\Domain\Transaction\DTO\TransactionData  $transactionData
     * @param  \App\Domain\Account\Entity\Account|null  $accountFrom
     * @param  \App\Domain\Account\Entity\Account|null  $accountTo
     *
     * @return \App\Domain\Generic\Entity\BaseEntity
     */
    public function execute(
        TransactionData $transactionData,
        ?Account $accountFrom,
        ?Account $accountTo
    ): BaseEntity {
        /** @var Transaction $transaction */
        $transaction = $this->persistEntity(
            $this->validateEntity(
                (new Transaction)
                    ->fill($transactionData)
                    ->setAccountFrom($accountFrom)
                    ->setAccountTo($accountTo)
            )
        );

        if ($transaction->getValidatorErrors()) {
            return $transaction;
        }

        $this->persistEntity(
            $accountFrom->setAmount(
                $accountFrom->getAmount() - $transactionData->getAmount()
            )
        );

        $this->persistEntity(
            $accountTo->setAmount(
                $accountFrom->getAmount() + $transactionData->getAmount()
            )
        );

        return $transaction
            ->setAccountFrom($accountFrom)
            ->setAccountTo($accountTo);
    }
}
