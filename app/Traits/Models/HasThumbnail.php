<?php

namespace App\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    public function makeThumbnail(string $size, string $method = 'resize')
    {
        return route('thumbnail', [
            'size' => $size,
            'dir' => $this->thumbnailDir(),
            'method' => $method,
            'file' => File::basename($this->{$this->thumbnailColumn()}),
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
