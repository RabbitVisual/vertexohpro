<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\SchoolClass;

class ClassRecordController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::where('user_id', auth()->id())->get();
        return view('classrecord::index', compact('classes'));
    }

    public function create()
    {
        return view('classrecord::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'year' => 'required|string|max:50',
        ]);

        $class = SchoolClass::create([
            'name' => $validated['name'],
            'subject' => $validated['subject'],
            'year' => $validated['year'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('classrecords.index')->with('success', 'Class created successfully.');
    }

    public function show($id)
    {
        $class = SchoolClass::where('user_id', auth()->id())
            ->with(['students.grades', 'attendances'])
            ->findOrFail($id);

        return view('classrecord::show', compact('class'));
    }

    public function edit($id)
    {
        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($id);
        return view('classrecord::edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'year' => 'required|string|max:50',
        ]);

        $class->update($validated);

        return redirect()->route('classrecords.index')->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $class = SchoolClass::where('user_id', auth()->id())->findOrFail($id);
        $class->delete();

        return redirect()->route('classrecords.index')->with('success', 'Class deleted successfully.');
    }
}
