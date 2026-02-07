<?php

namespace Modules\Library\Services;

use Modules\Library\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\URL;
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

        // Check if purchased
        return $material->purchasers()->where('user_id', $user->id)->exists();
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
            throw new \Exception("Unauthorized access to material.");
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
}
