<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Fonction;
use App\Models\Section;
use App\Models\Agent;
use App\Models\Service;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            // 'sections' => Section::all(),
            // 'users' => User::select('name', 'id')->get(),
            // 'services' => Service::select('titre', 'id')->get(),
            // 'statuts' => Statut::select('libelle', 'id')->get(),

        ];
        return view('regidoc.pages.systems.section', $data);
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
            $section = Section::create([
                "titre" => $request->libelle,
                "service_id" => $request->service_id,
                "responsable_id" => $request->responsable_id,
                "description" => $request->description,
                "statut_id" => $request->statut_id,
            ]);

            $fonction = Fonction::firstOrCreate([
                'titre' => 'Chef ' . $request->libelle,
            ], [
                "direction_id" => $section->service->division->direction->id,
                "division_id" => $section->service->division->id,
                "service_id" => $section->service_id,
                "section_id" => $section->id,
            ]);
            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                "direction_id" => $section->service->division->direction->id,
                "division_id" => $section->service->division->id,
                "service_id" => $section->service_id,
                "section_id" => $section->id,
                "fonction_id" => $fonction->id,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "section ajoutée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout du section a échoué !',
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
            $section = Section::findOrFail($id);

            $ancienAgent = Agent::findOrFail($section->responsable_id);
            $ancienAgent->update([
                'fonction_id' => null
            ]);

            $section->update([
                "titre" => $request->libelle,
                "service_id" => $request->service_id,
                "responsable_id" => $request->responsable_id,
                "description" => $request->description,
                "statut_id" => $request->statut_id,
            ]);

            $fonction = Fonction::firstOrCreate([
                'titre' => 'Responsable ' . $request->libelle,
            ], [
                "direction_id" => $section->service->division->direction->id,
                "division_id" => $section->service->division->id,
                "service_id" => $section->service_id,
                "section_id" => $section->id,
            ]);
            $agent = Agent::findOrFail($request->responsable_id);
            $agent->update([
                "direction_id" => $section->service->division->direction->id,
                "division_id" => $section->service->division->id,
                "service_id" => $section->service_id,
                "section_id" => $section->id,
                "fonction_id" => $fonction->id,
            ]);

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Section ajoutée avec succès",
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la section a échoué !',
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
        //
    }
}
