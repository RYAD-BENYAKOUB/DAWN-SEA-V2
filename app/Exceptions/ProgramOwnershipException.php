<?php

namespace App\Exceptions;

class ProgramOwnershipException extends BaseBusinessException
{
    protected $httpStatusCode = 403;

    public function __construct(string $message = "Vous n'êtes pas autorisé à modifier ou supprimer ce programme.")
    {
        parent::__construct($message);
    }
}
