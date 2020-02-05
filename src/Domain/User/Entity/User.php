<?php

namespace App\Domain\User\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use App\Domain\Account\Entity\Account;
use App\Domain\Generic\Entity\BaseEntity;
use App\Domain\User\DTO\UserData;
use App\Domain\Generic\Constraint as GenericAssert;

/**
 * @ORM\Entity(repositoryClass="App\Domain\User\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("email",message="This email has already been taken.")
 */
class User extends BaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @GenericAssert\HumanName()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Domain\Account\Entity\Account",
     *     mappedBy="user",
     *     cascade={"remove"}
     * )
     */
    private $accounts;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param  string  $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param  \DateTimeInterface|null  $created_at
     *
     * @return $this
     */
    public function setCreatedAt(?DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    /**
     * @param  \App\Domain\Account\Entity\Account  $account
     *
     * @return $this
     */
    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setUser($this);
        }

        return $this;
    }

    /**
     * @param  \App\Domain\Account\Entity\Account  $account
     *
     * @return $this
     */
    public function removeAccount(Account $account): self
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);
            // set the owning side to null (unless already changed)
            if ($account->getUser() === $this) {
                $account->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(
            new DateTime('now')
        );
    }

    /**
     * @param  \App\Domain\User\DTO\UserData  $dto
     *
     * @return \App\Domain\User\Entity\User
     */
    public function fill(UserData $dto)
    {
        return $this
            ->setName($dto->getName())
            ->setEmail($dto->getEmail());
    }
}
