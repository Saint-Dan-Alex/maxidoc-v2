<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image as InterventionImage;

class Image
{
    public function handle(Request $request, $field, $table_slug, $options = null)
    {
        // dd($request->hasFile($field));
        if ($request->hasFile($field)) {
            $file = $request->file($field);

            $path = $table_slug.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;

            $filename = $this->generateFileName($file, $path, $options);

            $image = InterventionImage::make($file)->orientate();

            $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

            $resize_width = null;
            $resize_height = null;
            if (isset($options->resize) && (
                isset($options->resize->width) || isset($options->resize->height)
            )) {
                if (isset($options->resize->width)) {
                    $resize_width = $options->resize->width;
                }
                if (isset($options->resize->height)) {
                    $resize_height = $options->resize->height;
                }
            } else {
                $resize_width = $image->width();
                $resize_height = $image->height();
            }

            $resize_quality = isset($options->quality) ? intval($options->quality) : 75;

            $image = $image->resize(
                $resize_width,
                $resize_height,
                function (Constraint $constraint) use ($options) {
                    $constraint->aspectRatio();
                    if (isset($options->upsize) && !$options->upsize) {
                        $constraint->upsize();
                    }
                }
            )->encode($file->getClientOriginalExtension(), $resize_quality);

            if ($this->is_animated_gif($file)) {
                Storage::disk('public')->put($fullPath, file_get_contents($file), 'public');
                $fullPathStatic = $path.$filename.'-static.'.$file->getClientOriginalExtension();
                Storage::disk('public')->put($fullPathStatic, (string) $image, 'public');
            } else {
                Storage::disk('public')->put($fullPath, (string) $image, 'public');
            }

            if (isset($options->thumbnails)) {
                foreach ($options->thumbnails as $thumbnails) {
                    if (isset($thumbnails->name) && isset($thumbnails->scale)) {
                        $scale = intval($thumbnails->scale) / 100;
                        $thumb_resize_width = $resize_width;
                        $thumb_resize_height = $resize_height;

                        if ($thumb_resize_width != null && $thumb_resize_width != 'null') {
                            $thumb_resize_width = intval($thumb_resize_width * $scale);
                        }

                        if ($thumb_resize_height != null && $thumb_resize_height != 'null') {
                            $thumb_resize_height = intval($thumb_resize_height * $scale);
                        }

                        $image = InterventionImage::make($file)
                            ->orientate()
                            ->resize(
                                $thumb_resize_width,
                                $thumb_resize_height,
                                function (Constraint $constraint) use ($options) {
                                    $constraint->aspectRatio();
                                    if (isset($options->upsize) && !$options->upsize) {
                                        $constraint->upsize();
                                    }
                                }
                            )->encode($file->getClientOriginalExtension(), $resize_quality);
                    } elseif (isset($thumbnails->crop->width) && isset($thumbnails->crop->height)) {
                        $crop_width = $thumbnails->crop->width;
                        $crop_height = $thumbnails->crop->height;
                        $image = InterventionImage::make($file)
                            ->orientate()
                            ->fit($crop_width, $crop_height)
                            ->encode($file->getClientOriginalExtension(), $resize_quality);
                    }

                    Storage::disk('public')->put(
                        $path.$filename.'-'.$thumbnails->name.'.'.$file->getClientOriginalExtension(),
                        (string) $image,
                        'public'
                    );
                }
            }

            return $fullPath;
        }
        return null;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param $path
     *
     * @return string
     */
    public function generateFileName($file, $path, $options = null)
    {
        if (isset($options->preserveFileUploadName) && $options->preserveFileUploadName) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
            $filename_counter = 1;

            // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
            while (Storage::disk('public')->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
            }
        } else {
            $filename = Str::random(20);

            // Make sure the filename does not exist, if it does, just regenerate
            while (Storage::disk('public')->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                $filename = Str::random(20);
            }
        }

        return $filename;
    }

    private function is_animated_gif($filename)
    {
        $raw = file_get_contents($filename);

        $offset = 0;
        $frames = 0;
        while ($frames < 2) {
            $where1 = strpos($raw, "\x00\x21\xF9\x04", $offset);
            if ($where1 === false) {
                break;
            } else {
                $offset = $where1 + 1;
                $where2 = strpos($raw, "\x00\x2C", $offset);
                if ($where2 === false) {
                    break;
                } else {
                    if ($where1 + 8 == $where2) {
                        $frames++;
                    }
                    $offset = $where2 + 1;
                }
            }
        }

        return $frames > 1;
    }
}
