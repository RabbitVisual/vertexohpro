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
            'knowledge_objects' => $skill->objetos_conhecimento ?: $skill->objeto_conhecimento,
            'grade_year' => $skill->ano_faixa,
            'component' => $skill->componente_curricular ?: $skill->componente,
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
        $verb = strtok($skill->descricao, ' '); // Get the first word
        $objects = $skill->objetos_conhecimento ?: (array)$skill->objeto_conhecimento;
        return [
            "Compreender o conceito de {$skill->descricao}",
            "Identificar elementos relacionados a " . implode(', ', (array)$objects),
            "Aplicar o conhecimento de {$verb} em contextos práticos",
            "Discutir as implicações de " . implode(', ', (array)$objects)
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
        $objects = $skill->objetos_conhecimento ?: (array)$skill->objeto_conhecimento;
        $component = $skill->componente_curricular ?: $skill->componente;
        return [
            "Participação em discussões em grupo sobre {$component}",
            "Resolução de exercícios práticos envolvendo " . implode(', ', (array)$objects),
            "Apresentação oral ou escrita sobre o tema",
            "Autoavaliação do aprendizado"
        ];
    }
}
