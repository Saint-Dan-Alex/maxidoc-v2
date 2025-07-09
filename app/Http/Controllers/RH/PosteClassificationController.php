<?php

namespace App\Http\Controllers\RH;

use Illuminate\Http\Request;
use App\Models\PosteClassification;
use App\Http\Controllers\Controller;

class PosteClassificationController extends Controller
{
    public function store(Request $request)
    {
        $posteclassification = PosteClassification::create([
            'libelle' => $request->libelle,
            'statut_id' => '1',
        ]);

        if($posteclassification->id != null){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'L\'ajout de la classification du poste a réussi avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'L\'ajout de la classification du poste a échoué !',
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
        $posteclassification = PosteClassification::where('id', $request->posteclassification_id)->update([
            'libelle' => $request->libelle,
            'statut_id' => $request->statut_id,
        ]);

        if($posteclassification == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La modification de classification du poste a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification de classification du poste a échouée !',
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
        $posteclassification = PosteClassification::where('id', $id)->update([
            'statut_id' => '4',
        ]);

        if($posteclassification == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La suppression de classification du poste a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La suppression de classification du poste a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
