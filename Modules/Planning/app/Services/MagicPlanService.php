<?php

namespace Modules\Planning\Services;

use Modules\Planning\Models\BnccHabilidade;

class MagicPlanService
{
    /**
     * Search for a BNCC skill by code and return mapped data for a lesson plan.
     *
     * @param string $code
     * @return array|null
     */
    public function getSkillByCode(string $code): ?array
    {
        $skill = BnccHabilidade::where('codigo', $code)->first();

        if (!$skill) {
            return null;
        }

        return [
            'skill_code' => $skill->codigo,
            'description' => $skill->descricao,
            'knowledge_objects' => $skill->objetos_conhecimento, // Already cast to array in model
            'grade_year' => $skill->ano_faixa,
            'component' => $skill->componente_curricular,
            // Additional structure for lesson plan
            'suggested_objectives' => [
                "Understand the concept of {$skill->descricao}",
                "Apply knowledge related to " . implode(', ', (array)$skill->objetos_conhecimento)
            ],
            'suggested_methodology' => [
                'Active Learning',
                'Group Discussion'
            ],
            'suggested_materials' => [
                'Textbook',
                'Whiteboard',
                'Projector'
            ]
        ];
    }
}
