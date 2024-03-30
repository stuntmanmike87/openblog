<?php

declare(strict_types=1);

namespace App\Utils;

use Nette\Utils\Strings;
use Symfony\Component\Console\Exception\InvalidArgumentException;

use function Symfony\Component\String\u;

final class Validator
{
    public function validateNickname(?string $nickname): string
    {
        if (null === $nickname) {
            throw new InvalidArgumentException('The username can not be empty.');
        }

        if (null/* 1 */ !== Strings::match('/^[a-z_]+$/', $nickname)) {
            throw new InvalidArgumentException('The username must contain only lowercase latin characters and underscores.');
        }

        return $nickname;
    }

    public function validatePassword(?string $plainPassword): string
    {
        if (null === $plainPassword) {
            throw new InvalidArgumentException('The password can not be empty.');
        }

        if (u($plainPassword)->trim()->length() < 6) {
            throw new InvalidArgumentException('The password must be at least 6 characters long.');
        }

        return $plainPassword;
    }

    public function validateEmail(?string $email): string
    {
        if (null === $email) {
            throw new InvalidArgumentException('The email can not be empty.');
        }

        if (null === u($email)->indexOf('@')) {
            throw new InvalidArgumentException('The email should look like a real email.');
        }

        return $email;
    }

    /* public function validateFullName(?string $fullName): string
    {
        if ($fullName === null) {
            throw new InvalidArgumentException('The full name can not be empty.');
        }

        return $fullName;
    } */
}
