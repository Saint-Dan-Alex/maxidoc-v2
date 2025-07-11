<?php

namespace App\Services;

use Illuminate\Http\Request;

class File 
{
    /**
     * Stocke un fichier uploadé depuis une requête dans un dossier donné
     * 
     * @param Request $request
     * @param string $fieldName Le nom du champ fichier dans la requête
     * @param string $folder Dossier où stocker (ex: 'documents')
     * @return string|null Le chemin du fichier stocké (relatif à storage/app) ou null
     */
    public function handle(Request $request, string $fieldName, string $folder): ?string
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $path = $file->store($folder);
            return $path;
        }
        return null;
    }
}
