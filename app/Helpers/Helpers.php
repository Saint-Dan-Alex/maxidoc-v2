<?php

use App\Helpers\MyPagination;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TCG\Voyager\Facades\Voyager;

// use stdClass;

if (!function_exists('image')) {
    function image($link, string $thumbnail = null)
    {
        $img = null;
        $link = str_replace('\\', '/', $link);
        $ext = Str::afterLast($link, '.');

        if ($thumbnail != null) {
            $img = Str::beforeLast($link, '.') . '-' . $thumbnail . '.' . $ext;
        } else {
            $img = $link;
        }

        return asset('storage') . '/' . $img;
    }
}

if (!function_exists('imageOrDefault')) {
    function imageOrDefault($subject, string $thumbnail = null)
    {
        if (!empty($subject) && $subject !== null) {
            if (Storage::disk('public')->exists($subject)) {
                return image($subject, $thumbnail);
            }
        }

        return asset('assets/regidoc/default.png');
    }
}

if (!function_exists('dateEnFrancais')) {
    function dateEnFrancais($created_at)
    {
        if (empty($created_at) || $created_at == null) {
            return "";
        }
        //  à H\hi
        // return Carbon::parse($created_at)->translatedFormat('d F Y');
        return Carbon::parse($created_at)->isoFormat('ddd l');
    }
}

if (!function_exists('isoDate')) {
    function isoDate($created_at)
    {
        //  à H\hi
        return Str::replaceLast(' ', ' à ', Carbon::parse($created_at)->isoFormat('LLLL'));
    }
}

if (!function_exists('myTime')) {
    function myTime($time)
    {
        //  à H\hi
        if (App::isLocale('en')) {
            return Carbon::parse($time)->translatedFormat('h:m A');
        } elseif (App::isLocale('fr')) {
            return Carbon::parse($time)->translatedFormat('H\hi');
        } else {
            return Carbon::parse($time)->translatedFormat('h:m');
        }
    }
}

if (!function_exists('getYear')) {
    function getYear($created_at)
    {
        return Carbon::parse($created_at)->year;
    }
}

// if (!function_exists('label')) {
//     function label($key)
//     {
//         $label = Label::where('key', $key)->first();
//         return $label ? $label->value : '';
//     }
// }

if (!function_exists('files')) {
    /**
     * Transforme un champ 'document' (JSON ou string) en objet ou collection d'objets
     * contenant l'URL publique et le nom du fichier.
     * 
     * @param mixed $file  JSON, string ou array représentant un ou plusieurs fichiers
     * @param bool  $multiple  Si true, retourne une collection même pour un seul fichier
     * @return \stdClass|Collection  Objet (si !multiple) ou collection de fichiers
     */
    function files($file, $multiple = false)
    {
        // 1. Si c'est un tableau PHP, on l'encode en JSON
        if (is_array($file)) {
            $file = json_encode($file, JSON_UNESCAPED_SLASHES);
        }

        // 2. Si ce n'est pas une chaîne, on ne peut pas traiter
        if (!is_string($file) || empty(trim($file))) {
            return $multiple ? collect() : (object)['link' => '', 'name' => ''];
        }

        // 3. Décodage du JSON
        $decoded = json_decode($file);

        // 4. Gestion des erreurs de décodage ou format brut
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Cas : chaîne brute (ex: "documents/August2025/file.pdf")
            $fileObj = new stdClass;
            $fileObj->download_link = trim($file);
            $fileObj->original_name = basename($fileObj->download_link);
            $decoded = [$fileObj];
        } elseif (is_object($decoded) && isset($decoded->download_link)) {
            // Cas : objet unique
            $decoded = [$decoded];
        } elseif (!is_array($decoded)) {
            // Cas inattendu
            $decoded = [];
        }

        $results = collect();

        foreach ($decoded as $item) {
            if (!isset($item->download_link) || empty(trim($item->download_link))) {
                continue;
            }

            $link = trim($item->download_link);
            $name = $item->original_name ?? basename($link);

            // 🔧 Normalisation du chemin
            $link = str_replace(['\\/', '\\\\', '\\'], '/', $link);  // Remplace les séparateurs échappés
            $link = urldecode($link);                                // Décodage des %20
            $link = preg_replace('#^[/]+#', '', $link);              // Supprime les / en début
            $link = preg_replace('#^storage[/]#i', '', $link);       // Évite storage/storage

            // 📁 Chemin dans le disque 'public'
            $storagePath = rtrim($link, '/');

            // 🔍 Vérifie que le fichier existe physiquement dans storage/app/public
            if (!Storage::disk('public')->exists($storagePath)) {
                \Log::warning("Fichier introuvable : storage/app/public/{$storagePath}");
                continue; // Ignore si le fichier n'existe pas
            }

            // ✅ Construit l'URL publique
            // En production sur Hostinger, utiliser FILESYSTEM_URL si disponible
            if (config('app.env') === 'production' && env('FILESYSTEM_URL')) {
                $url = env('FILESYSTEM_URL') . '/' . $storagePath;
            } else {
                // En local, utiliser asset()
                $url = asset('storage/' . $storagePath);
            }

            $fichier = new stdClass;
            $fichier->link = $url;
            $fichier->name = $name;
            $results->push($fichier);
        }

        // 🔚 Retourne le premier élément si !multiple
        if (!$multiple && $results->isNotEmpty()) {
            return $results->first();
        }

        // Retourne la collection ou un objet vide
        return $results->isNotEmpty() ? $results : (object)['link' => '', 'name' => ''];
    }
}

if (!function_exists('voyagerSaveImageToWebp')) {
    function voyagerSaveImageToWebp($data, $dataType, $field = 'image', $qualite = 80)
    {

        // making Original image (the big one)
        $originalImg = str_replace('\\', '/', Str::replaceFirst('/', '', Storage::url($data->{$field})));

        if (
            Str::afterLast($originalImg, '.') == 'webp' || Str::afterLast($originalImg, '.') == 'WEBP'
            || Str::afterLast($originalImg, '.') == '.webp' || Str::afterLast($originalImg, '.') == '.WEBP'
        ) {
            return;
        }

        $imgWidth = Image::make($originalImg)->width();
        // $imgHeight = Image::make($webpImg)->height();

        $finalType = 'webp';
        $finalUrl = Str::beforeLast($originalImg, '.');
        $finalUrl .= '.' . $finalType;

        $finalImg = Image::make($originalImg)
            ->resize($imgWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($finalUrl, $qualite, $finalType);
        // end making Original image

        // making thumbnails images
        $thumbnails = null;
        try {
            $thumbnails = $dataType->editRows->where('type', 'image')->first()->details->thumbnails;
        } catch (\Throwable $th) {
            // Delete Images
            Storage::disk('public')->delete(Str::replaceFirst('storage', '', $originalImg));

            $basename = $finalImg->basename;
            $originalFinalFileName = Str::after($finalImg->dirname, '/') . "/" . $basename;

            $data->image = $originalFinalFileName;
            $data->save();

            return;
        }

        foreach ($thumbnails as $key => $value) {

            $originalImg1 = str_replace('\\', '/', Str::replaceFirst('/', '', Storage::url($data->image)));
            // dd(isset($value->resize));
            $imgWidth1 = isset($value->crop) ? $value->crop->width : $value->resize->width;
            $imgHeight1 = isset($value->crop) ? $value->crop->height : $value->resize->height;
            $thumbnailName = $value->name;

            $finalUrl = Str::beforeLast($originalImg1, '.') . '-' . $thumbnailName;
            $finalUrl .= '.' . $finalType;

            if ($thumbnailName == "mobile") {
                $finalImg1 = Image::make($originalImg1)
                    ->resize($imgWidth1, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($finalUrl, $qualite, $finalType);
            } else {
                $finalImg1 = Image::make($originalImg1)
                    ->resize($imgWidth1, $imgHeight1, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($finalUrl, $qualite, $finalType);
            }
        }
        // end making thumbnails images

        // Delete thumbnails Images
        foreach ($thumbnails as $key => $value) {
            $toDelete = str_replace('\\', '/', Str::replaceFirst('/', '', Storage::url($data->thumbnail($value->name))));
            Storage::disk('public')->delete(Str::replaceFirst('storage', '', $toDelete));
        }

        // Delete Images
        Storage::disk('public')->delete(Str::replaceFirst('storage', '', $originalImg));

        $basename = $finalImg->basename;
        $originalFinalFileName = Str::after($finalImg->dirname, '/') . "/" . $basename;

        $data->image = $originalFinalFileName;
        $data->save();
    }
}

if (!function_exists('voyagerSaveMultipleImageToWebp')) {
    function voyagerSaveMultipleImageToWebp($data, $dataType, $field = 'images', $qualite = 80)
    {
        foreach (json_decode($data->{$field}) as $image) {
            // making Original image (the big one)
            $originalImg = str_replace('\\', '/', Str::replaceFirst('/', '', Storage::url($image)));

            if (
                Str::afterLast($originalImg, '.') == 'webp' || Str::afterLast($originalImg, '.') == 'WEBP'
                || Str::afterLast($originalImg, '.') == '.webp' || Str::afterLast($originalImg, '.') == '.WEBP'
            ) {
                return;
            }

            $imgWidth = Image::make($originalImg)->width();
            // $imgHeight = Image::make($webpImg)->height();

            $finalType = 'webp';
            $finalUrl = Str::beforeLast($originalImg, '.');
            $finalUrl .= '.' . $finalType;

            $finalImg = Image::make($originalImg)
                ->resize($imgWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($finalUrl, $qualite, $finalType);
            // end making Original image

            // making thumbnails images
            $thumbnails = null;
            try {
                $thumbnails = $dataType->editRows->where('type', 'image')->first()->details->thumbnails;
            } catch (\Throwable $th) {
                // Delete Images
                Storage::disk('public')->delete(Str::replaceFirst('storage', '', $originalImg));

                $basename = $finalImg->basename;
                $originalFinalFileName = Str::after($finalImg->dirname, '/') . "/" . $basename;

                $data->image = $originalFinalFileName;
                $data->save();

                return;
            }

            foreach ($thumbnails as $key => $value) {

                $originalImg1 = str_replace('\\', '/', Str::replaceFirst('/', '', Storage::url($data->image)));
                // dd(isset($value->resize));
                $imgWidth1 = isset($value->crop) ? $value->crop->width : $value->resize->width;
                $imgHeight1 = isset($value->crop) ? $value->crop->height : $value->resize->height;
                $thumbnailName = $value->name;

                $finalUrl = Str::beforeLast($originalImg1, '.') . '-' . $thumbnailName;
                $finalUrl .= '.' . $finalType;

                if ($thumbnailName == "mobile") {
                    $finalImg1 = Image::make($originalImg1)
                        ->resize($imgWidth1, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save($finalUrl, $qualite, $finalType);
                } else {
                    $finalImg1 = Image::make($originalImg1)
                        ->resize($imgWidth1, $imgHeight1, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save($finalUrl, $qualite, $finalType);
                }
            }
            // end making thumbnails images

            // Delete thumbnails Images
            foreach ($thumbnails as $key => $value) {
                $toDelete = str_replace('\\', '/', Str::replaceFirst('/', '', Storage::url($data->thumbnail($value->name))));
                Storage::disk('public')->delete(Str::replaceFirst('storage', '', $toDelete));
            }

            // Delete Images
            Storage::disk('public')->delete(Str::replaceFirst('storage', '', $originalImg));

            $basename = $finalImg->basename;
            $originalFinalFileName = Str::after($finalImg->dirname, '/') . "/" . $basename;

            $data->image = $originalFinalFileName;
            $data->save();
        }
    }
}

if (!function_exists('changeAllImageToWebp')) {
    function changeAllImageToWebp($datas, $table_slug, $qualite = 80)
    {

        $dataType = Voyager::model('DataType')->where('slug', '=', $table_slug)->first();

        foreach ($datas as $key => $data) {
            if (Storage::disk('public')->exists(Str::replaceFirst('storage', '', $data->image))) {
                if (Str::afterLast($data->image, '.') != 'webp') {
                    voyagerSaveImageToWebp($data, $dataType, $qualite);
                }
            } else {
                $data->image = "";
                $data->save();
            }
        }
    }
}

if (!function_exists('fileIcon')) {
    function fileIcon($file)
    {
        if (!$file) {
            return asset('assets/images/icons/file.png');

        }

        $file = files($file);
        if (!$file || (is_countable($file) && count($file) < 1)) {
            return asset('assets/images/icons/docs.png');
        }

        $fileName = $file->name ?? '';
        $fileLink = $file->link ?? '';
        $icon = '';

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'docx':
                $icon = asset('assets/images/icons/docs.png');
                break;

            case 'pdf':
                $icon = asset('assets/images/icons/Fichier-pdf.svg');
                break;

            case 'xlsx':
                $icon = 'bi file-earmark-excel-fill text-success';
                break;

            case 'pptx':
                $icon = 'bi file-earmark-ppt-fill text-danger';
                break;

            case 'zip':
                $icon = 'bi file-earmark-zip-fill text-darck';
                break;

            case 'rar':
                $icon = 'bi file-earmark-zip-fill text-darck';
                break;

            default:
                $icon = asset('assets/images/icons/Fichier-image.svg');
                break;
        }

        return $icon;
    }
}

if (!function_exists('cutByLetters')) {
    function cutByLetters($contentText, int $limit = 0)
    {

        $contentText = html_entity_decode($contentText);

        $contentText = strip_tags($contentText);

        if (Str::length($contentText) <= $limit) {
            return $contentText;
        } else {
            return Str::limit($contentText, $limit);
        }
    }
}

if (!function_exists('socialShareCount')) {
    function socialShareCount($provider_name, $url)
    {
        $provider_api = '#';
        $outputKey = '';
        if (Str::lower($provider_name) == 'facebook') {
            $provider_api = 'https://graph.facebook.com/?id';
            $outputKey = 'id';
        } elseif (Str::lower($provider_name) == 'twitter') {
            // https://counts.twitcount.com/counts.php?url
            // https://cdn.api.twitter.com/1/urls/count.json?url
            $provider_api = 'https://counts.twitcount.com/counts.php?url';
            $outputKey = 'count';
        }

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $provider_api . '=' . $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return json_decode($output)->{$outputKey} ?? 0;
    }
}

if (!function_exists('cutText')) {
    function cutText($contenu, $limit)
    {
        if (strlen($contenu) < $limit) {
            $resultat = $contenu;
        } else {
            $resultat = substr($contenu, 0, strpos($contenu, ' ', $limit)) . ' ...';
        }

        return $resultat;
    }
}

if (!function_exists('cutTextAndCloseTags')) {
    function cutTextAndCloseTags($text, $limit)
    {

        $html = cutText($text, $limit);

        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];

        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</' . $openedtags[$i] . '>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }
}

if (!function_exists('wrapWord')) {
    function wrapWord($str, int $lenth = 0, $remove_html = true, $pad = " ...")
    {
        $str = html_entity_decode($str);
        if ($remove_html) {
            $str = strip_tags($str);
        }
        $str = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $str);
        if (strlen($str) <= $lenth) {
            return $str;
        }
        $newstring = substr($str, 0, strrpos(substr($str, 0, $lenth), ' '));
        return $newstring . $pad;
    }
}

if (!function_exists('tempsLecture')) {
    function tempsLecture($content)
    {
        $word_count = str_word_count(strip_tags($content));

        $minutes = floor($word_count / 230);
        $seconds = floor($word_count % 230 / (230 / 60));

        $str_minutes = ($minutes == 1) ? "minute" : "minutes";
        $str_seconds = ($seconds == 1) ? "seconde" : "secondes";

        if ($minutes == 0) {
            return "{$seconds} {$str_seconds}";
        } else {
            return "{$minutes} {$str_minutes} et {$seconds} {$str_seconds}";
        }
    }
}

if (!function_exists('convertUnit')) {
    function convertUnit($nombre)
    {
        if ($nombre == 0 || $nombre == null || $nombre == '') {
            return 0;
        }

        $nombre = abs($nombre);
        $def = [
            [1, ''],
            [1000, 'k'],
            [1000 * 1000, 'M'],
            [1000 * 1000 * 1000, 'b'],
            [1000 * 1000 * 1000 * 1000, 'T'],
        ];
        for ($i = 0; $i < count($def); $i++) {
            if ($nombre < $def[$i][0]) {
                return ($nombre / $def[$i - 1][0]) . '' . $def[$i - 1][1];
            }

        }
    }
}

if (!function_exists('customPagination')) {
    function customPagination($items, $perPage)
    {
        $pageStart = request('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($items->all(), $offSet, $perPage);

        return new LengthAwarePaginator(
            $itemsForCurrentPage,
            count($items),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}

if (!function_exists('isBirthday')) {
    function isBirthday($date_from = "", $date_to = "")
    {

        if ($date_from = "" && $date_to = "") {
            return null;
        }

        if ($date_from != "" || $date_from != null) {
            if (Carbon::parse($date_from)->isBirthday()) {
                return "date_from";
            }
        }

        if ($date_to != "" || $date_to != null) {
            if (Carbon::parse($date_to)->isBirthday()) {
                return "date_to";
            }
        }
    }
}

if (!function_exists('customPagination2')) {
    function customPagination2($items, $perPage)
    {
        $pageStart = request('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage);

        return new LengthAwarePaginator(
            $itemsForCurrentPage,
            count($items),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath() . '?term=' . $_GET['term']]
        );
    }
}

if (!function_exists('clickPaginate')) {
    function clickPaginate($items, $perPage = 6)
    {

        if (!is_array($items->all())) {
            return $items;
        }

        $pageStart = request('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($items->all() ?? [], $offSet, $perPage);

        return new MyPagination(
            $itemsForCurrentPage,
            count($items),
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}

if (!function_exists('dateHeureEnFrancais')) {
    function dateHeureEnFrancais($created_at)
    {
        //  à H\hi
        return Carbon::parse($created_at)->translatedFormat('d F, Y H\:i');
    }
}

if (!function_exists('customPaginate')) {

    function customPaginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

if (!function_exists('differenceDateFromNow')) {
    function differenceDateFromNow($date_cloture, $limit = 0)
    {
        $today = Carbon::today();

        if ($today > $date_cloture) {
            $resultat = 'Expired';
            $bgcolor = '#FF0000';
        } else {
            $reste = $today->diffInDays($date_cloture);
            if ($reste <= $limit) {
                if ($reste == 0) {
                    $resultat = 'Expire today';
                    $bgcolor = '#FFA500';
                } else {
                    $resultat = 'Reste ' . $reste . ' jours';
                    $bgcolor = '#FFFF00';
                }
            } else {
                $resultat = 'En cours';
                $bgcolor = '#008000';
            }
        }

        return compact('resultat', 'bgcolor');
    }
}

if (!function_exists('expireStat')) {
    function expireStat($date_cloture, $limit = 0)
    {
        $today = Carbon::today();

        if ($today > $date_cloture) {
            $resultat = 'Expired';
            $bgcolor = 'bg-danger text-white';
        } else {
            $reste = $today->diffInDays($date_cloture);
            if ($reste <= $limit) {
                if ($reste == 0) {
                    $resultat = 'Expire today';
                    $bgcolor = 'bg-yellow-500';
                } else {
                    $resultat = 'Reste ' . $reste . ' jours';
                    $bgcolor = 'bg-warning';
                }
            } else {
                $resultat = 'En cours';
                $bgcolor = 'bg-success';
            }
        }

        $expiration = new stdClass;
        $expiration->bg = $bgcolor;
        $expiration->text = $resultat;

        return $expiration;
    }
}

if (!function_exists('extraireDownloadLink')) {
    function extraireDownloadLink($link)
    {
        $result = json_decode($link);

        if (count($result) != 0) {
            $download_link = $result[0]->download_link;
        } else {
            $download_link = "";
        }

        return $download_link;
    }
}

if (!function_exists('saveImage')) {
    function saveImage(UploadedFile $file, Model $model, $field = 'image')
    {
        deleteImage($model, $field);
        $image = Image::make($file);
        $image_name = Str::slug($model->getTable()) . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
        $image_name .= Str::random(20) . '.webp';
        $category = $model->category;

        $width = $category ? ($category->width ? $category->width : null) : null;
        $height = $category ? ($category->height ? $category->height : null) : null;

        if ($width === null || $height === null) {
            $image->resize($image->width(), $image->height(), function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public') . '/' . $image_name, 80, 'webp');
        } else {
            $image->resize($width, $height)
                ->save(storage_path('app/public') . '/' . $image_name, 80, 'webp');
        }

        // Storage::disk('public')->put($image_name, $image->stream()->__toString(), 'public');

        $model->{$field} = $image_name;
        $model->save();
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage(Model $model, $field)
    {
        $storage = Storage::disk('public');

        if ($storage->exists($model->{$field})) {
            $storage->delete($model->{$field});
        }
    }
}

if (!function_exists('cutTextWell')) {
    function cutTextWell($text, $max)
    {
        if (empty($text)) {
            return '';
        }

        $text = strip_tags($text);
        $text = str_replace('&nbsp;', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        $text = explode(' ', $text);
        $text = implode(' ', array_slice($text, 0, $max));
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        $text = $text . '...';

        return $text;
    }
}

if (!function_exists('getFirstParagraph')) {
    function getFirstParagraph($text)
    {
        $start = strpos($text, '<p>');
        $end = strpos($text, '</p>', $start);
        $paragraph = substr($text, $start, $end - $start + 4);

        return $paragraph;
    }
}

if (!function_exists('exceptFirstParagraph')) {
    function exceptFirstParagraph($text)
    {
        $paragraphs = array_slice(explode("\r\n", $text), 1);
        // Str::replaceFirst('[','',json_encode();
        // $paragraphs = Str::replaceLast(']','',$paragraphs);
        // $paragraphs = Str::replace('\\','',$paragraphs);

        return implode($paragraphs);
    }
}
if (!function_exists('parseUA')) {
    /**
     * Parse un User Agent brut pour retourner une chaîne lisible : "Système (Navigateur)"
     */
    function parseUA($ua)
    {
        if (empty($ua)) return "Inconnu";
        
        $platform = "Appareil Inconnu";
        $browser = "Navigateur Inconnu";

        // Détection du Système / Plateforme
        if (preg_match('/windows|win32/i', $ua)) {
            $platform = 'Windows';
            if (preg_match('/NT 10.0/i', $ua)) $platform = 'Windows 10/11';
            elseif (preg_match('/NT 6.3/i', $ua)) $platform = 'Windows 8.1';
            elseif (preg_match('/NT 6.2/i', $ua)) $platform = 'Windows 8';
            elseif (preg_match('/NT 6.1/i', $ua)) $platform = 'Windows 7';
        }
        elseif (preg_match('/android/i', $ua)) $platform = 'Android';
        elseif (preg_match('/iphone|ipad|ipod/i', $ua)) $platform = 'iOS';
        elseif (preg_match('/macintosh|mac os x/i', $ua)) $platform = 'macOS';
        elseif (preg_match('/linux/i', $ua)) $platform = 'Linux';

        // Détection du Navigateur
        if (preg_match('/edg/i', $ua)) $browser = 'Edge';
        elseif (preg_match('/firefox/i', $ua)) $browser = 'Firefox';
        elseif (preg_match('/chrome/i', $ua)) $browser = 'Chrome';
        elseif (preg_match('/safari/i', $ua)) $browser = 'Safari';
        elseif (preg_match('/msie|trident/i', $ua)) $browser = 'IE';

        return "$platform ($browser)";
    }
}
