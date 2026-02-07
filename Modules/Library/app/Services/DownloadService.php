<?php

namespace Modules\Library\Services;

use Modules\Library\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
     * @param Material $material
     * @param User $user
     * @return string
     * @throws \Exception
     */
    public function getDownloadUrl(Material $material, User $user): string
    {
        if (!$this->hasPermission($material, $user)) {
            throw new \Exception("Unauthorized access to material. Please purchase or wait for approval.");
        }

        // Generate signed URL valid for 30 minutes
        return URL::temporarySignedRoute(
            'library.materials.download',
            Carbon::now()->addMinutes(30),
            [
                'material' => $material->id,
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
