<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class EnabledValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Enabled $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        /** @var string $value */
        $this->context->buildViolation($constraint/* ->message */->validatedBy())
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
