<?php

namespace App\Domain\Account\Resource;

use App\Domain\Account\Entity\Account;

final class AccountResource
{
    /**
     * @param  \App\Domain\Account\Entity\Account  $account
     *
     * @return array
     */
    public static function item(Account $account): array
    {
        return [
            'id'      => $account->getId(),
            'user'    => $account->getUser()
                                 ->getEmail(),
            'account' => $account->getAccountNumber(),
            'amount'  => $account->getAmount(),
        ];
    }

    /**
     * @param  array  $accounts
     *
     * @return array
     */
    public static function collection(array $accounts)
    {
        return array_map(function ($account) {
            return static::item($account);
        }, $accounts);
    }
}