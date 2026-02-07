<?php

namespace Modules\ClassRecord\Livewire;

use Livewire\Component;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Attendance;
use Modules\ClassRecord\Models\Student;
use Carbon\Carbon;

class QuickAttendance extends Component
{
    public $classId;
    public $date;
    public $students = [];
    public $attendanceData = []; // [student_id => status]
    public $observations = []; // [student_id => observation]

    public function mount($classId)
    {
        $this->classId = $classId;
        $this->date = Carbon::today()->format('Y-m-d');
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $schoolClass = SchoolClass::with('students')->find($this->classId);
        if ($schoolClass) {
            $this->students = $schoolClass->students;

            // Load existing attendance for today
            foreach ($this->students as $student) {
                $attendance = Attendance::where('student_id', $student->id)
                    ->where('class_id', $this->classId)
                    ->where('date', $this->date)
                    ->first();

                $this->attendanceData[$student->id] = $attendance ? $attendance->status : null;
                $this->observations[$student->id] = $attendance ? $attendance->observation : '';
            }
        }
    }

    public function setStatus($studentId, $status)
    {
        // Update local state
        $this->attendanceData[$studentId] = $status;

        // Persist
        $this->saveAttendance($studentId);
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'observations.')) {
            $studentId = explode('.', $propertyName)[1];
            $this->saveAttendance($studentId);
        }
    }

    protected function saveAttendance($studentId)
    {
        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'class_id' => $this->classId,
                'date' => $this->date
            ],
            [
                'status' => $this->attendanceData[$studentId] ?? null,
                'observation' => $this->observations[$studentId] ?? null,
            ]
        );
    }

    public function render()
    {
        return view('classrecord::livewire.quick-attendance')
            ->layout('classrecord::components.layouts.master');
    }
}
