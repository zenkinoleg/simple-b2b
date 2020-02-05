<?php

namespace App\Domain\Generic\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HumanName extends Constraint
{
    public $message = 'Given string contains an illegal character: it can only be a human name.';

    public function validatedBy() {
        return 'App\Domain\Generic\Validator\HumanNameValidator';
    }
}