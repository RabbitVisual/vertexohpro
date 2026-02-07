<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Library\Models\ResourceVersion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LibraryResourceController extends Controller
{
    public function index()
    {
        $resources = LibraryResource::approved()->paginate(12);
        return view('library::index', compact('resources'));
    }

    public function create()
    {
        return view('library::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'file' => 'required|file|max:10240', // 10MB
            'tags' => 'nullable|string', // Comma separated
        ]);

        $filePath = $request->file('file')->store('library_resources', 'private');
        $tags = $validated['tags'] ? explode(',', $validated['tags']) : [];

        $resource = LibraryResource::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'file_path' => $filePath,
            'tags' => $tags,
            'status' => 'pending',
            'version' => '1.0',
        ]);

        // Create initial version
        ResourceVersion::create([
            'library_resource_id' => $resource->id,
            'version' => '1.0',
            'file_path' => $filePath,
            'changelog' => 'Initial release',
        ]);

        return redirect()->route('library.index')->with('success', 'Material enviado para aprovação.');
    }

    public function edit($id)
    {
        $resource = LibraryResource::findOrFail($id);

        if ($resource->user_id !== auth()->id()) {
            abort(403);
        }

        return view('library::edit', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $resource = LibraryResource::findOrFail($id);

        if ($resource->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'file' => 'nullable|file|max:10240',
            'tags' => 'nullable|string',
            'version' => 'nullable|string', // Only required if file is uploaded
            'changelog' => 'nullable|string',
            'free_until' => 'nullable|date|after:now',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'tags' => $validated['tags'] ? explode(',', $validated['tags']) : [],
            'free_until' => $validated['free_until'],
        ];

        DB::transaction(function () use ($resource, $request, $validated, $updateData) {
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('library_resources', 'private');

                // Increment version logic if not provided? Or enforce user input.
                // Assuming user provides new version string like '1.1'
                $newVersion = $validated['version'] ?? number_format((float)$resource->version + 0.1, 1);

                $updateData['file_path'] = $filePath;
                $updateData['version'] = $newVersion;
                $updateData['status'] = 'pending'; // Re-review required on file update? Let's say yes for safety.

                ResourceVersion::create([
                    'library_resource_id' => $resource->id,
                    'version' => $newVersion,
                    'file_path' => $filePath,
                    'changelog' => $validated['changelog'] ?? 'Update',
                ]);

                // Notify purchasers logic here (e.g., dispatch job)
                // For this task, we assume the notification is passive via Toast on login
            }

            $resource->update($updateData);
        });

        return redirect()->route('author.dashboard')->with('success', 'Material atualizado com sucesso.');
    }

    public function show($id)
    {
        $resource = LibraryResource::findOrFail($id);
        return view('library::show', compact('resource'));
    }

    public function destroy($id)
    {
         $resource = LibraryResource::findOrFail($id);
         if ($resource->user_id !== auth()->id()) {
             abort(403);
         }
         $resource->delete();
         return redirect()->route('author.dashboard')->with('success', 'Material removido.');
    }
}
