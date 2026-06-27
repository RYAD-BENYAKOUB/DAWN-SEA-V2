<?php

namespace App\Actions\Program;

use App\DTOs\Program\UpdateProgramDTO;
use App\Models\Program;
use App\Exceptions\BaseBusinessException;

class UpdateProgramAction
{
    /**
     * Exécute l'action de mise à jour d'un programme.
     * 
     * @param UpdateProgramDTO $dto
     * @param Program $program
     * @return Program
     * @throws BaseBusinessException
     */
    public function execute(UpdateProgramDTO $dto, Program $program): Program
    {
        $program->fill([
            'title' => $dto->title,
            'description' => $dto->description,
            'location' => $dto->location,
            'duration' => $dto->duration,
            'price' => $dto->price,
            'max_participants' => $dto->maxParticipants,
            'difficulty' => $dto->difficulty,
            'is_active' => $dto->isActive,
        ]);

        if ($dto->imageUrl !== null) {
            $program->image = $dto->imageUrl;
        }

        if (!$program->save()) {
            throw new BaseBusinessException("Impossible de mettre à jour le programme.", 500);
        }

        return $program;
    }
}
