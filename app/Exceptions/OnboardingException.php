<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

final class OnboardingException extends Exception
{
    public static function notAuthorized() :self
    {
        return new self(
            'Não Autorizado',
            Response::HTTP_UNAUTHORIZED,
        );
    }
}
