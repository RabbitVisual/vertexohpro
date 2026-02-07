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
            'knowledge_objects' => $skill->objetos_conhecimento,
            'grade_year' => $skill->ano_faixa,
            'component' => $skill->componente_curricular,
            // Enhanced structure for lesson plan
            'suggested_objectives' => $this->generateObjectives($skill),
            'suggested_assessment' => $this->generateAssessment($skill),
            'suggested_methodology' => [
                'Active Learning',
                'Group Discussion',
                'Peer Review'
            ],
            'suggested_materials' => [
                'Textbook',
                'Whiteboard',
                'Projector',
                'Digital Resources'
            ]
        ];
    }

    /**
     * Generate suggested learning objectives based on the skill description.
     *
     * @param BnccHabilidade $skill
     * @return array
     */
    protected function generateObjectives(BnccHabilidade $skill): array
    {
        $verb = strtok($skill->descricao, ' '); // Get the first word (usually the verb)
        return [
            "Compreender o conceito de {$skill->descricao}",
            "Identificar elementos relacionados a " . implode(', ', (array)$skill->objetos_conhecimento),
            "Aplicar o conhecimento de {$verb} em contextos práticos",
            "Discutir as implicações de " . implode(', ', (array)$skill->objetos_conhecimento)
        ];
    }

    /**
     * Generate suggested assessment methods.
     *
     * @param BnccHabilidade $skill
     * @return array
     */
    protected function generateAssessment(BnccHabilidade $skill): array
    {
        return [
            "Participação em discussões em grupo sobre {$skill->componente_curricular}",
            "Resolução de exercícios práticos envolvendo " . implode(', ', (array)$skill->objetos_conhecimento),
            "Apresentação oral ou escrita sobre o tema",
            "Autoavaliação do aprendizado"
        ];
    }
}
