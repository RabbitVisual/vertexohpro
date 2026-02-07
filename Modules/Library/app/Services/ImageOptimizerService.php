<?php

namespace Modules\Library\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageOptimizerService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimize and convert image to WebP.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string Path to the stored webp image
     */
    public function optimize(UploadedFile $file, string $directory = 'previews'): string
    {
        $image = $this->manager->read($file->getRealPath());

        // Resize to max width 800px, keeping aspect ratio
        $image->scale(width: 800);

        // Generate unique filename
        $filename = uniqid() . '.webp';
        $path = $directory . '/' . $filename;

        // Save to storage
        // Since Intervention saves to local path, we might need to handle storage disk.
        // For simplicity with Storage facade, we can get the encoded data.
        $encoded = $image->toWebp(quality: 75);

        Storage::disk('public')->put($path, (string)$encoded);

        return $path;
    }
}
