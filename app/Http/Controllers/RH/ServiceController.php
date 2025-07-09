<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Service;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            // 'services' => Service::all(),
            // 'users' => User::select('name', 'id')->get(),
            // 'divisions' => Division::select('libelle', 'id')->get(),
            // 'statuts' => Statut::select('libelle', 'id')->get(),

        ];
        return view('regidoc.pages.systems.service', $data);
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
            Service::create([
                "titre" => $request->libelle,
                "responsable_id" => $request->responsable_id,
                "statut_id" => $request->statut_id,
                "direction_id" => $request->direction_id,
                "division_id" => $request->division_id,
                "description" => $request->description,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Service ajouté avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout du Service a échoué !',
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
            $Service = Service::findOrFail($id);

            $Service->update([
                "titre" => $request->libelle,
                "responsable_id" => $request->responsable_id,
                "statut_id" => $request->statut_id,
                "direction_id" => $request->direction_id,
                "division_id" => $request->division_id,
                "description" => $request->description,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Service modifié avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification du Service a échoué !',
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
            $Service = Service::findOrFail($id);

            $Service->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Service Supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression du Service a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }
}
