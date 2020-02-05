<?php

namespace App\Domain\Generic\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HumanNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (! preg_match('/^[a-zA-Z0-9 -.,]+$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                          ->setParameter('%string%', $value)
                          ->addViolation();
        }
    }
}
