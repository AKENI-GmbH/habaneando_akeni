<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;

/**
 * Shared configuration for all admin image uploads.
 *
 * - Images are resized in the browser before upload (max. 2000px on the
 *   longest side), so large phone/camera photos end up well below any
 *   upload limit and load faster on the website.
 * - Only JPG, PNG and WebP are accepted. HEIC (iPhone) and other formats
 *   are rejected with a clear message instead of failing silently.
 * - Originals up to 20 MB are accepted (checked before resizing).
 */
class ImageUpload
{
    public const MAX_DIMENSION = 2000;

    public const MAX_SIZE_KB = 20480;

    public const ACCEPTED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    public static function make(string $name): FileUpload
    {
        return FileUpload::make($name)
            ->image()
            ->acceptedFileTypes(self::ACCEPTED_TYPES)
            ->maxSize(self::MAX_SIZE_KB)
            ->imageResizeMode('contain')
            ->imageResizeTargetWidth((string) self::MAX_DIMENSION)
            ->imageResizeTargetHeight((string) self::MAX_DIMENSION)
            ->imageResizeUpscale(false)
            ->helperText('JPG, PNG oder WebP, max. 20 MB. Große Bilder werden automatisch verkleinert.');
    }
}
