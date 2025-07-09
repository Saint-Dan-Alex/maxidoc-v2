<?php

namespace App\Http\Controllers\RH;

use Illuminate\Http\Request;
use App\Models\PosteCategorie;
use App\Http\Controllers\Controller;

class PosteCategorieController extends Controller
{
    public function store(Request $request)
    {
        $postecategorie = PosteCategorie::create([
            'libelle' => $request->libelle,
            'statut_id' => '1',
        ]);

        if($postecategorie->id != null){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'L\'ajout de la catégorie du poste a réussi avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'L\'ajout de la catégorie du poste a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function update(Request $request)
    {
        $postecategorie = PosteCategorie::where('id', $request->postecategorie_id)->update([
            'libelle' => $request->libelle,
            'statut_id' => $request->statut_id,
        ]);

        if($postecategorie == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La modification de catégorie du poste a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification de catégorie du poste a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function destroy($id)
    {
        $postecategorie = PosteCategorie::where('id', $id)->update([
            'statut_id' => '4',
        ]);

        if($postecategorie == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La suppression de catégorie du poste a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La suppression de catégorie du poste a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
