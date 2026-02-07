<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Grade;
use Modules\ClassRecord\Models\CycleClosure;

class ClassRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('classrecord::index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('classrecord::show');
    }

    /**
     * Close a specific cycle for a class, locking all grades.
     *
     * @param Request $request
     * @param int $classId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeCycle(Request $request, $classId)
    {
        $validated = $request->validate([
            'cycle' => 'required|integer|min:1|max:4',
            'signature' => 'required|string', // Base64 signature
        ]);

        $cycle = $validated['cycle'];
        $signature = $validated['signature'];

        // Find all grades for this class and cycle that are not locked
        $grades = Grade::whereHas('student', function ($query) use ($classId) {
            $query->where('school_class_id', $classId);
        })->where('cycle', $cycle)->whereNull('locked_at')->get();

        foreach ($grades as $grade) {
            $grade->update(['locked_at' => now()]);
        }

        // Create CycleClosure record
        CycleClosure::updateOrCreate(
            ['school_class_id' => $classId, 'cycle' => $cycle],
            ['signature' => $signature, 'signed_at' => now()]
        );

        return back()->with('success', "Ciclo {$cycle} fechado com sucesso. Notas bloqueadas e assinatura registrada.");
    }

    /**
     * Display the class overview with charts.
     */
    public function overview($classId)
    {
        $schoolClass = SchoolClass::with('students.grades')->findOrFail($classId);

        // Prepare data for Chart.js
        // Compare average grade per cycle
        $cycleAverages = [];
        for ($i = 1; $i <= 4; $i++) {
            $grades = $schoolClass->students->flatMap(function ($student) use ($i) {
                return $student->grades->where('cycle', $i)->pluck('value');
            });

            if ($grades->count() > 0) {
                $cycleAverages[$i] = round($grades->avg(), 2);
            } else {
                $cycleAverages[$i] = 0;
            }
        }

        return view('classrecord::overview', [
            'schoolClass' => $schoolClass,
            'cycleAverages' => $cycleAverages,
        ]);
    }
}
