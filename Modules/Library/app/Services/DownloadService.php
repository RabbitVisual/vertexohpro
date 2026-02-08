<?php

namespace Modules\Library\Services;

use Modules\Library\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Modules\Library\Models\LibraryResource;

class DownloadService
{
    /**
     * Check if the user has permission to download the material.
     */
    public function hasPermission(Material $material, User $user): bool
    {
        // Owner always has permission
        if ($material->user_id === $user->id) {
            return true;
        }

        // Check if purchased and approved
        return $material->purchasers()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'approved')
            ->exists();
    }

    /**
     * Generate a signed temporary download URL.
     *
     * @param Material|LibraryResource $resource
     * @param User|null $user
     * @return string
     * @throws \Exception
     */
    public function getDownloadUrl($resource, User $user = null): string
    {
        // If it's a LibraryResource, we use the simpler logic mentioned at the end of the file
        if ($resource instanceof LibraryResource) {
            return URL::temporarySignedRoute(
                'library.stream',
                now()->addMinutes(10),
                ['id' => $resource->id]
            );
        }

        // For Material, we check permissions
        if (!$user || !$this->hasPermission($resource, $user)) {
            throw new \Exception("Unauthorized access to material. Please purchase or wait for approval.");
        }

        // Generate signed URL valid for 30 minutes
        return URL::temporarySignedRoute(
            'library.materials.download',
            Carbon::now()->addMinutes(30),
            [
                'material' => $resource->id,
                'user' => $user->id
            ]
        );
    }

    /**
     * Serve the file via stream.
     *
     * @param Material $material
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function streamDownload(Material $material)
    {
        if (!Storage::disk('private')->exists($material->file_path)) {
            abort(404, 'File not found');
        }

        $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
        $filename = \Illuminate\Support\Str::slug($material->title) . '.' . $extension;

        // Use Storage::download which streams the file
        return Storage::disk('private')->download($material->file_path, $filename);
    }
}
