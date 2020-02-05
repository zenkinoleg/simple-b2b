<?php

namespace App\Domain\User\DTO;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Generic\DTO\DataTransferObject;

final class UserData extends DataTransferObject
{
    /** @var string */
    private $name = '';

    /** @var string */
    private $email = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     *
     * @return \App\Domain\User\DTO\UserData
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param  string  $email
     *
     * @return \App\Domain\User\DTO\UserData
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     *
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        $dto  = new static;
        $data = $dto->requestToData($request);

        return $dto
            ->setName($data->name ?? $dto->getName())
            ->setEmail($data->email ?? $dto->getEmail());
    }
}
