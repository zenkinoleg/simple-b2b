<?php

namespace App\Domain\Account\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\User\Entity\User;
use App\Domain\Account\DTO\AccountData;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Account\Repository\AccountRepository")
 * @ORM\Table(name="accounts")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("account_number",message="Such account already exists.")
 */
class Account extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\User\Entity\User", inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     * @Assert\NotBlank(message="Invalid user")
     */
    private $user;

    /**
     * @ORM\Column(type="bigint")
     * @Assert\NotBlank()
     * @Assert\Regex("/^[\d]{16}$/",message="Invalid account number. Must be 16 digits format.")
     */
    private $account_number;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\PositiveOrZero()
     * @Assert\Regex("/^\d+(\.\d+)?$/")
     */
    private $amount;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\User\Entity\User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param  \App\Domain\User\Entity\User|null  $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    /**
     * @param  string  $account_number
     *
     * @return $this
     */
    public function setAccountNumber(string $account_number): self
    {
        $this->account_number = $account_number;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param  string  $amount
     *
     * @return $this
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param  \App\Domain\Account\DTO\AccountData  $dto
     *
     * @return \App\Domain\Account\Entity\Account
     */
    public function fill(AccountData $dto)
    {
        return $this
            ->setAccountNumber(
                $dto->getAccountNumber()
            )
            ->setAmount(
                $dto->getAmount()
            );
    }
}
