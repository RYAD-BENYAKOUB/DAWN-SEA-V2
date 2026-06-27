<?php

namespace App\Actions\Program;

use App\Models\Program;
use App\Exceptions\BaseBusinessException;

class DeleteProgramAction
{
    /**
     * Exécute l'action de suppression d'un programme.
     * 
     * @param Program $program
     * @return bool
     * @throws BaseBusinessException
     */
    public function execute(Program $program): bool
    {
        if (!$program->delete()) {
            throw new BaseBusinessException("Impossible de supprimer le programme.", 500);
        }

        return true;
    }
}
