<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Services\ClassExportService;

class SchoolClassController extends Controller
{
    protected $exportService;

    public function __construct(ClassExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::classes.index', compact('classes'));
    }

    public function show($id)
    {
        $class = SchoolClass::findOrFail($id);
        return view('classrecord::classes.show', compact('class'));
    }

    public function export($id)
    {
        try {
            $content = $this->exportService->export($id);
            $filename = 'backup_turma_' . $id . '_' . date('Ymd_His') . '.csv';

            return response($content)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', "attachment; filename=\"$filename\"");
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao exportar: ' . $e->getMessage());
        }
    }
}
