<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Jobs\SendReportCardJob;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classrecord::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('classrecord::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('classrecord::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    /**
     * Send report card via email.
     */
    public function emailReportCard(Student $student)
    {
        SendReportCardJob::dispatch($student);

        return back()->with('success', 'Boletim enviado para processamento!');
    }
}
