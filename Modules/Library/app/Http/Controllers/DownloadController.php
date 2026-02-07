<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Library\Models\LibraryResource;
use Modules\Library\Services\DownloadService;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    protected $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    /**
     * Public entry point. Checks permissions and redirects to signed URL.
     */
    public function download(Request $request, $id)
    {
        $resource = LibraryResource::findOrFail($id);
        $user = auth()->user();

        // Check permission: Owner OR Purchased OR Free
        $hasPermission = false;

        if ($resource->user_id === $user->id) {
            $hasPermission = true;
        } elseif ($resource->isFree()) {
            $hasPermission = true;
        } elseif ($user->purchases()->where('library_resource_id', $id)->exists()) {
            $hasPermission = true;
        }

        if (!$hasPermission) {
            abort(403, 'Você não possui permissão para baixar este arquivo.');
        }

        // Generate signed URL
        $url = $this->downloadService->getDownloadUrl($resource);

        return redirect($url);
    }

    /**
     * Signed route target. Streams the file.
     */
    public function stream(Request $request, $id)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Link de download expirado ou inválido.');
        }

        $resource = LibraryResource::findOrFail($id);

        // Ensure file exists
        if (!Storage::disk('private')->exists($resource->file_path)) {
            abort(404, 'Arquivo não encontrado no servidor.');
        }

        return Storage::disk('private')->download($resource->file_path, $resource->title . '.' . pathinfo($resource->file_path, PATHINFO_EXTENSION));
    }
}
