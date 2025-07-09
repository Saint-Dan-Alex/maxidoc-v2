<?php

namespace App\Http\Controllers\RH;

use App\Models\Poste;
use App\Models\Statut;
use Illuminate\Http\Request;
use App\Models\PosteCategorie;
use App\Models\PosteClassification;
use App\Http\Controllers\Controller;

class PosteController extends Controller
{
    public function index()
    {
        $postes = Poste::orderBy('libelle', 'asc')->get();
        $statuts = Statut::all();
        $postecategories = PosteCategorie::orderBy('libelle', 'asc')->get();
        $posteclassifications = PosteClassification::orderBy('libelle', 'asc')->get();

        session()->flash('menu', '4');

        return view('pages.rh.postes.index', compact('postes', 'postecategories', 'posteclassifications', 'statuts'));
    }

    public function store(Request $request)
    {
        $poste = Poste::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'poste_categorie_id' => $request->poste_categorie_id,
            'poste_classification_id' => $request->poste_classification_id,
            'statut_id' => '1',
        ]);

        if($poste->id != null){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'L\'ajout du poste a réussi avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'L\'ajout du poste a échoué !',
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
        $poste = Poste::where('id', $request->poste_id)->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'poste_categorie_id' => $request->poste_categorie_id,
            'poste_classification_id' => $request->poste_classification_id,
            'statut_id' => $request->statut_id,
        ]);

        if($poste == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La modification du poste a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La modification du poste a échouée !',
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
        $poste = Poste::where('id', $id)->update([
            'statut_id' => '4',
        ]);

        if($poste == 1){
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'success',
                'message' => 'La suppression du poste a réussie avec succès !',
            ]);
        } else {
            $content = json_encode([
                'name' => 'Ressources humaines',
                'statut' => 'error',
                'message' => 'La suppression du poste a échouée !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
