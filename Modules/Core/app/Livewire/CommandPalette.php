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

    public function updatedQuery()
    {
        $this->results = [];

        if (strlen($this->query) < 2) {
            return;
        }

        // 1. Search Modules / Navigation (Static for now)
        $this->searchNavigation();

        // 2. Search Classes
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
                ];
            }
        }

        // 3. Search Students
        if (class_exists(Student::class)) {
            $students = Student::where('name', 'like', "%{$this->query}%")
                ->take(3)
                ->get();

            foreach ($students as $student) {
                // Assuming we go to class record or student profile
                // For now, let's link to class record since we don't have a direct student profile route
                $this->results[] = [
                    'title' => $student->name,
                    'subtitle' => 'Aluno',
                    'icon' => 'user-graduate',
                    'url' => route('classrecords.show', $student->class_id), // Fallback to class view
                    'group' => 'Alunos',
                ];
            }
        }

        // 4. Search Lesson Plans (Mock for now as Planning module isn't fully set up in context)
        // $this->results[] = ...
    }

    private function searchNavigation()
    {
        $navItems = [
            ['title' => 'Dashboard', 'url' => '/', 'icon' => 'chart-line'],
            ['title' => 'Diário de Classe', 'url' => route('classrecords.index'), 'icon' => 'book-open'],
            ['title' => 'Planejamento', 'url' => '#', 'icon' => 'calendar-lines-pen'], // Placeholder
            ['title' => 'Biblioteca', 'url' => '#', 'icon' => 'books'], // Placeholder
        ];

        foreach ($navItems as $item) {
            if (Str::contains(strtolower($item['title']), strtolower($this->query))) {
                $this->results[] = [
                    'title' => $item['title'],
                    'subtitle' => 'Navegação',
                    'icon' => $item['icon'],
                    'url' => $item['url'],
                    'group' => 'Sistema',
                ];
            }
        }
    }

    public function render()
    {
        return view('core::livewire.command-palette');
    }
}
