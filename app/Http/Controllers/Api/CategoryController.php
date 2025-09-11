<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourrierCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Récupère les catégories en fonction du type de document
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriesByType(Request $request)
    {
        $typeId = $request->input('type_id');
        
        // Si type_id est null, on récupère toutes les catégories sans type spécifique
        $categories = CourrierCategory::query()
            ->where('type_id', $typeId)
            ->select('id', 'title as text')
            ->orderBy('title')
            ->get();
            
        return response()->json($categories);
    }
}
