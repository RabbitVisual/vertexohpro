<?php

namespace Modules\Library\Services;

use Illuminate\Support\Facades\URL;
use Modules\Library\Models\LibraryResource;

class DownloadService
{
    /**
     * Generate a temporary signed URL for downloading a resource.
     * The URL expires in 10 minutes.
     */
    public function getDownloadUrl(LibraryResource $resource): string
    {
        return URL::temporarySignedRoute(
            'library.stream',
            now()->addMinutes(10),
            ['id' => $resource->id]
        );
    }
}
