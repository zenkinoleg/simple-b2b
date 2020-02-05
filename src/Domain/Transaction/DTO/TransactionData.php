<?php

namespace App\Domain\Transaction\DTO;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Generic\DTO\DataTransferObject;

final class TransactionData extends DataTransferObject
{
    /** @var int */
    private $account_from = 0;

    /** @var int */
    private $account_to = 0;

    /** @var float */
    private $amount = 0;

    /** @var string */
    private $description = '';

    /** @var int */
    private $status = 0;

    /**
     * @return int
     */
    public function getAccountFrom(): int
    {
        return $this->account_from;
    }

    /**
     * @param  int  $account_from
     *
     * @return \App\Domain\Transaction\DTO\TransactionData
     */
    public function setAccountFrom(int $account_from): self
    {
        $this->account_from = $account_from;

        return $this;
    }

    /**
     * @return int
     */
    public function getAccountTo(): int
    {
        return $this->account_to;
    }

    /**
     * @param  int  $account_to
     *
     * @return \App\Domain\Transaction\DTO\TransactionData
     */
    public function setAccountTo(int $account_to): self
    {
        $this->account_to = $account_to;

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
     * @return \App\Domain\Transaction\DTO\TransactionData
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string  $description
     *
     * @return \App\Domain\Transaction\DTO\TransactionData
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param  int  $status
     *
     * @return \App\Domain\Transaction\DTO\TransactionData
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Facade
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     *
     * @return static
     */
    public static function fromRequest(Request $request)
    {
        $dto  = new static;
        $data = $dto->requestToData($request);

        return $dto
            ->setAccountFrom(
                $data->account_from ?? $dto->getAccountFrom()
            )
            ->setAccountTo(
                $data->account_to ?? $dto->getAccountTo()
            )
            ->setAmount(
                $data->amount ?? $dto->getAmount()
            )
            ->setDescription(
                $data->description ?? $dto->getDescription()
            )
            ->setStatus(
                $data->status ?? $dto->getStatus()
            );
    }
}
