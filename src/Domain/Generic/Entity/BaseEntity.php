<?php

namespace App\Domain\Generic\Entity;

/**
 * Class BaseEntity
 */
class BaseEntity
{
    /** @var array | null */
    private $validatorErrors = [];

    /**
     * @return array|null
     */
    public function getValidatorErrors(): ?array
    {
        return $this->validatorErrors;
    }

    /**
     * @param  array|null  $validatorErrors
     */
    public function setValidatorErrors(?array $validatorErrors): void
    {
        $this->validatorErrors = $validatorErrors;
    }
}