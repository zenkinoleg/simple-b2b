<?php

namespace App\Domain\Transaction\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Domain\Account\Entity\Account;
use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\Transaction\DTO\TransactionData;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Domain\Transaction\Repository\TransactionRepository")
 * @ORM\Table(name="transactions")
 */
class Transaction extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\Expression(
     *     "this.getAccountFromAmount()-value>=0",
     *     message="Not enough money on account"
     * )
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Account\Entity\Account")
     * @ORM\JoinColumn(
     *     name="account_from",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     * @Assert\NotBlank(message="No account exists.")
     */
    private $account_from;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Account\Entity\Account")
     * @ORM\JoinColumn(name="account_to",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     * @Assert\NotBlank(message="No account exists.")
     * @Assert\Expression(
     *     "this.getAccountFrom()!=value",
     *     message="You cannot transact to the same account."
     * )
     */
    private $account_to;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param  string|null  $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \App\Domain\Account\Entity\Account|null
     */
    public function getAccountFrom(): ?Account
    {
        return $this->account_from;
    }

    /**
     * @param  \App\Domain\Account\Entity\Account|null  $account
     *
     * @return $this
     */
    public function setAccountFrom(?Account $account): self
    {
        $this->account_from = $account;

        return $this;
    }

    /**
     * @return \App\Domain\Account\Entity\Account|null
     */
    public function getAccountTo(): ?Account
    {
        return $this->account_to;
    }

    /**
     * @param  \App\Domain\Account\Entity\Account|null  $account_to
     *
     * @return $this
     */
    public function setAccountTo(?Account $account_to): self
    {
        $this->account_to = $account_to;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param  \DateTimeInterface|null  $created_at
     *
     * @return $this
     */
    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @param  \DateTimeInterface|null  $updated_at
     *
     * @return $this
     */
    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param  int  $status
     *
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return float
     */
    public function getAccountFromAmount() : float
    {
        $account = $this->getAccountFrom();
        return $account ? $account->getAmount() : 0;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(
            new DateTime('now')
        );
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(
            new DateTime('now')
        );
    }

    /**
     * @param  \App\Domain\Transaction\DTO\TransactionData  $dto
     *
     * @return $this
     */
    public function fill(TransactionData $dto) : self
    {
        return $this
            ->setAmount(
                $dto->getAmount()
            )
            ->setDescription(
                $dto->getDescription()
            )
            ->setStatus(
                $dto->getStatus()
            );
    }

}
