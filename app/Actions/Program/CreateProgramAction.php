<?php

namespace App\Actions\Program;

use App\DTOs\Program\CreateProgramDTO;
use App\Models\Program;
use App\Models\Guide;
use App\Exceptions\BaseBusinessException;

class CreateProgramAction
{
    /**
     * Exécute l'action de création d'un programme.
     * 
     * @param CreateProgramDTO $dto
     * @param Guide $guide
     * @return Program
     * @throws BaseBusinessException
     */
    public function execute(CreateProgramDTO $dto, Guide $guide): Program
    {
        $program = tap(new Program([
            'title' => $dto->title,
            'description' => $dto->description,
            'location' => $dto->location,
            'duration' => $dto->duration,
            'price' => $dto->price,
            'max_participants' => $dto->maxParticipants,
            'difficulty' => $dto->difficulty,
        ]), function (Program $program) use ($dto, $guide) {
            $program->guide_id = $guide->id;
            $program->is_active = $dto->isActive;
            
            if ($dto->imageUrl) {
                $program->image = $dto->imageUrl;
            }
        });

        if (!$program->save()) {
            throw new BaseBusinessException("Impossible de créer le programme.", 500);
        }

        return $program;
    }
}
