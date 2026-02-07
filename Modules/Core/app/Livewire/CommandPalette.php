<?php

namespace Modules\Core\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\SchoolClass;

class CommandPalette extends Component
{
    public $query = '';
    public $results = [];
    public $activeIndex = 0;

    public function updatedQuery()
    {
        $this->activeIndex = 0;
        $this->results = [];

        if (strlen($this->query) < 2) {
            return;
        }

        $queryLower = strtolower($this->query);

        // 1. Actions (Quick Actions)
        $this->searchActions($queryLower);

        // 2. Search Navigation
        $this->searchNavigation($queryLower);

        // 3. Search Classes
        if (class_exists(SchoolClass::class)) {
            $classes = SchoolClass::where('name', 'like', "%{$this->query}%")
                ->orWhere('subject', 'like', "%{$this->query}%")
                ->take(3)
                ->get();

            foreach ($classes as $class) {
                $this->results[] = [
                    'title' => $class->name,
                    'subtitle' => 'Turma - ' . $class->subject,
                    'icon' => 'chalkboard-user',
                    'url' => route('classrecords.show', $class->id),
                    'group' => 'Turmas',
                    'type' => 'resource',
                ];
            }
        }

        // 4. Search Students
        if (class_exists(Student::class)) {
            $students = Student::where('name', 'like', "%{$this->query}%")
                ->take(3)
                ->get();

            foreach ($students as $student) {
                $this->results[] = [
                    'title' => $student->name,
                    'subtitle' => 'Aluno',
                    'icon' => 'user-graduate',
                    'url' => route('classrecords.show', $student->class_id), // Fallback
                    'group' => 'Alunos',
                    'type' => 'resource',
                ];
            }
        }
    }

    private function searchActions($query)
    {
        $actions = [
            [
                'title' => 'Criar Nova Turma',
                'keywords' => ['criar', 'nova', 'turma', 'adicionar'],
                'url' => route('classrecords.create'),
                'icon' => 'plus-circle',
                'group' => 'Ações Rápidas',
                'type' => 'action',
                'subtitle' => 'Novo Registro',
            ],
            [
                'title' => 'Lançar Falta',
                'keywords' => ['lançar', 'falta', 'chamada', 'frequência'],
                'url' => route('classrecords.index'),
                'icon' => 'user-xmark',
                'group' => 'Ações Rápidas',
                'type' => 'action',
                'subtitle' => 'Frequência',
            ],
            [
                'title' => 'Novo Plano de Aula',
                'keywords' => ['novo', 'plano', 'aula', 'planejamento'],
                'url' => '#',
                'icon' => 'file-signature',
                'group' => 'Ações Rápidas',
                'type' => 'action',
                'subtitle' => 'Planejamento',
            ],
        ];

        foreach ($actions as $action) {
            foreach ($action['keywords'] as $keyword) {
                if (Str::contains($query, $keyword) || Str::contains(strtolower($action['title']), $query)) {
                    $this->results[] = $action;
                    break;
                }
            }
        }
    }

    private function searchNavigation($query)
    {
        $navItems = [
            ['title' => 'Dashboard', 'url' => '/', 'icon' => 'chart-line'],
            ['title' => 'Diário de Classe', 'url' => route('classrecords.index'), 'icon' => 'book-open'],
            ['title' => 'Planejamento', 'url' => '#', 'icon' => 'calendar-lines-pen'],
            ['title' => 'Biblioteca', 'url' => '#', 'icon' => 'books'],
        ];

        foreach ($navItems as $item) {
            if (Str::contains(strtolower($item['title']), $query)) {
                $this->results[] = [
                    'title' => $item['title'],
                    'subtitle' => 'Navegação',
                    'icon' => $item['icon'],
                    'url' => $item['url'],
                    'group' => 'Sistema',
                    'type' => 'navigation',
                ];
            }
        }
    }

    public function render()
    {
        return view('core::livewire.command-palette');
    }
}
