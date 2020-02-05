<?php

namespace App\Domain\Account\DTO;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Generic\DTO\DataTransferObject;

final class AccountData extends DataTransferObject
{
    /** @var int */
    private $user_id = 0;

    /** @var string */
    private $account_number = '';

    /** @var float */
    private $amount = 0;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param  int  $user_id
     *
     * @return \App\Domain\Account\DTO\AccountData
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->account_number;
    }

    /**
     * @param  string  $account_number
     *
     * @return \App\Domain\Account\DTO\AccountData
     */
    public function setAccountNumber(string $account_number): self
    {
        $this->account_number = $account_number;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param  float  $amount
     *
     * @return \App\Domain\Account\DTO\AccountData
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Facade
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     *
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        $dto  = new static;
        $data = $dto->requestToData($request);

        return $dto
            ->setUserId(
                $data->user_id ?? $dto->getUserId()
            )
            ->setAccountNumber(
                $data->account_number ?? $dto->getAccountNumber()
            )
            ->setAmount(
                $data->amount ?? $dto->getAmount()
            );
    }
}
