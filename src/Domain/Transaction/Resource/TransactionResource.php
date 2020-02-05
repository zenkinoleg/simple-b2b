<?php

namespace App\Domain\Transaction\Resource;

use App\Domain\Account\Resource\AccountResource;
use App\Domain\Transaction\Entity\Transaction;

final class TransactionResource
{
    /**
     * @param  \App\Domain\Transaction\Entity\Transaction  $transaction
     *
     * @return array
     */
    public static function item(Transaction $transaction)
    {
        return [
            'id'           => $transaction->getId(),
            'amount'       => $transaction->getAmount(),
            'description'  => $transaction->getDescription(),
            'created_at'   => $transaction->getCreatedAt()
                                          ->format('Y-m-d h:i:s'),
            'account_from' => AccountResource::item($transaction->getAccountFrom()),
            'account_to'   => AccountResource::item($transaction->getAccountTo()),
        ];
    }

    /**
     * @param  array  $transactions
     *
     * @return array
     */
    public static function collection(array $transactions)
    {
        return array_map(function ($transaction) {
            return static::item($transaction);
        }, $transactions);
    }
}