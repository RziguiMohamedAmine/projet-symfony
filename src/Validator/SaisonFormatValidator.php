<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SaisonFormatValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\SaisonFormat $constraint */

        if (null === $value || '' === $value) {
            return;
        }
        $firstYear = intval(substr($value, 0, 4));
        $secndYear = intval(substr($value, 5, 4));
        if (!($firstYear + 1 == $secndYear)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}
