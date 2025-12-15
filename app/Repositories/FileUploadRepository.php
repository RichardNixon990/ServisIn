<?php

namespace App\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadRepository
{
    /**
     * Upload file ke storage dan kembalikan path-nya
     */
public function upload(UploadedFile $file, string $folder = 'uploads'): string
{
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs($folder, $filename, 'public');

    return $path;
}

    /**
     * Hapus file lama dari storage (jika ada)
     */
public function delete(?string $path): void
{
    if ($path && Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }
}
}
