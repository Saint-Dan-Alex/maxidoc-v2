<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'grades' => Grade::all()
        ];
        return view('regidoc.pages.systems.grade', $data);
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
            Grade::create([
                "titre" => $request->titre,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Grade ajouté avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout du Grade a échoué !',
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
            $Grade = Grade::findOrFail($id);

            $Grade->update([
                "titre" => $request->titre,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Grade modifiée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification du Grade a échoué !',
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
            $Grade = Grade::findOrFail($id);

            $Grade->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Grade Supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression du Grade a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}