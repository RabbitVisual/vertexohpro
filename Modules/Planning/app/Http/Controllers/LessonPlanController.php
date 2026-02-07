<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonPlanController extends Controller
{
    public function index()
    {
        return view('planning::lesson-plans.index');
    }

    public function create()
    {
        return view('planning::lesson-plans.create');
    }

    public function store(Request $request)
    {
        // Validation and store logic
    }

    public function show($id)
    {
        return view('planning::lesson-plans.show');
    }

    public function edit($id)
    {
        return view('planning::lesson-plans.edit');
    }

    public function update(Request $request, $id)
    {
        // Update logic
    }

    public function destroy($id)
    {
        // Destroy logic
    }
}
