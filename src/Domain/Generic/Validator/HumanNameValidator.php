<?php

namespace App\Domain\Generic\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HumanNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $pattern = '/^[a-zA-Z0-9 -.,]+$/';
        if (! preg_match($pattern, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                          ->setParameter('%string%', $value)
                          ->addViolation();
        }
    }
}
