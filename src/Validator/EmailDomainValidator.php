<?php

namespace App\Validator;

use App\Repository\ConfigRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailDomainValidator extends ConstraintValidator
{
    private $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }


    public function validate($value, Constraint $constraint)
    {
        /* @var EmailDomain $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $domain = substr($value, strpos($value, '@') + 1);
        if(in_array($domain, $constraint->blocked)){
            // TODO: implement the validation here
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
        }

        
    }
}
