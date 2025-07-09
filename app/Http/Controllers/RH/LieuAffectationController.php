<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\LieuAffectation;
use Illuminate\Http\Request;

class LieuAffectationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = [
        //     'lieus' => LieuAffectation::select('id','titre')->orderBy('titre')->paginate(10),
        // ];
        return view('regidoc.pages.systems.lieu');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            LieuAffectation::create([
                "titre" => $request->titre,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Lieu d'Affectation ajoutée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout du Lieu Affectation a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $LieuAffectation = LieuAffectation::findOrFail($id);

            $LieuAffectation->update([
                "titre" => $request->titre,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Lieu Affectation modifiée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification du Lieu Affectation a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $LieuAffectation = LieuAffectation::findOrFail($id);

            $LieuAffectation->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "LieuAffectation Supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression du LieuAffectation a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}