<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ScanFile
{
    public $slug;
    public $options;

    /**
     * @return string
     */
    public function handle($table_slug, $options = null)
    {
        $this->slug = $table_slug;
        $this->options = $options;

        $filesPath = [];
        $path = $this->generatePath();
        $file = Storage::files('public/tmp_scanne')[0];

        $filename = $this->generateFileName($file, $path);

        Storage::move($file, 'public/' . $path . $filename . '.' . Str::afterLast($file, '.'));

        array_push($filesPath, [
            'download_link' => $path . $filename . '.' . Str::afterLast($file, '.'),
            'original_name' => 'Scan ' . now()->format('dmYhms'),
        ]);

        return json_encode($filesPath);
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->slug . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    protected function generateFileName($file, $path)
    {
        $filename = Str::random(20);

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::disk('public')->exists($path . $filename . '.' . Str::afterLast($file, '.'))) {
            $filename = Str::random(20);
        }

        return $filename;
    }
}