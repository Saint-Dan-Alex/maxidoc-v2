<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Direction;
use App\Models\Fonction;
use App\Models\LieuAffectation;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'directions' => Direction::with('lieu','responsable')->select('id','titre','lieu_id','responsable_id','code', 'adjoint_id'),
            // 'users' => User::select('name', 'id')->get(),
            'lieus' => LieuAffectation::select('titre', 'id')->get(),
        ];
        return view('regidoc.pages.systems.direction')->with($data);
    }

    public function getAgents(Request $request){
        return $this->relation($request, 'agent');
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
            $direction = Direction::create([
                "code" => $request->code,
                "titre" => $request->libelle,
                "responsable_id" => $request->responsable_id,
                "adjoint_id" => $request->adjoint_id,
                "lieu_id" => $request->lieu_id,
                "description" => $request->description,
            ]);

            $fonction = Fonction::firstOrCreate([
                'titre' => 'Adjoint Responsable ' . $request->libelle,
            ], [
                "direction_id" => $direction->id,
            ]);

            $agent = Agent::find($request->responsable_id);
            if ($agent) {
                $agent->update([
                    'fonction_id' => $fonction->id,
                    'direction_id' => $direction->id
                ]);
            }

            $agentAdjoint = Agent::find($request->adjoint_id);
            if ($agentAdjoint) {
                $agent->update([
                    'fonction_id' => $fonction->id,
                    'direction_id' => $direction->id
                ]);
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Direction ajouté avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout de la Direction a échoué !',
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
            $direction = Direction::findOrFail($id);

            $direction->update([
                "code" => $request->code,
                "titre" => $request->libelle,
                "responsable_id" => $request->responsable_id,
                "adjoint_id" => $request->adjoint_id,
                "lieu" => $request->lieu_id,
                "description" => $request->description,
            ]);

            $direction->code = $request->code;
            $direction->save();
            // dd($direction->responsable_id != $request->responsable_id);

            if ($direction->responsable_id != $request->responsable_id) {
                # code...
                $ancienAgent = Agent::find($direction->responsable_id);
                if ($ancienAgent) {
                    $ancienAgent->update([
                        'fonction_id' => null
                    ]);
                }
                $fonction = Fonction::firstOrCreate([
                    'titre' => 'Responsable ' . $request->libelle,
                ], [
                    "direction_id" => $id,
                ]);

                $agent = Agent::find($request->responsable_id);
                if ($agent) {
                    $agent->update([
                        'fonction_id' => $fonction->id,
                        'direction_id' => $direction->id
                    ]);
                }
            }
            if ($direction->adjoint_id != $request->adjoint_id) {
                # code...
                $ancienAgentAdjoint = Agent::find($direction->adjoint_id);
                if ($ancienAgentAdjoint) {
                    $ancienAgentAdjoint->update([
                        'fonction_id' => null
                    ]);
                }
                $fonction = Fonction::firstOrCreate([
                    'titre' => 'Adjoint Responsable ' . $request->libelle,
                ], [
                    "direction_id" => $id,
                ]);

                $agentAjoint = Agent::find($request->adjoint_id);
                if ($agentAjoint) {
                    $agentAjoint->update([
                        'fonction_id' => $fonction->id,
                        'direction_id' => $direction->id
                    ]);
                }
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Direction modifiée avec succès",
            ]);

        } catch (\Throwable $th) {
            // dd($th);
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la Direction a échoué ...!',
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
            $Direction = Direction::find($id);

            $Direction->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Direction Supprimée avec succès",
            ]);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Direction a échoué !',
            ]);
        }

        session()->flash(
            'session',
            $content
        );

        return back();
    }

    public function relation(Request $request, $slug)
    {
        $page = $request->input('page');
        $on_page = 30;
        $search = $request->input('search', false);

        $method = $request->input('method', 'add');

        $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($slug))));

        // if ($method != 'add') {
        //     $model = $model->find($request->input('id'));
        // }
        // dd($request->input('id'));


        // $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($request->input('model')))));
        $skip = $on_page * ($page - 1);

        $additional_attributes = $model->additional_attributes ?? [];

        $labels = explode(',', $request->input('label'));

        // If search query, use LIKE to filter results depending on field label
        if ($search) {
            $data = null;
            foreach($labels as $key => $label){
                if($key == 0){
                    $data = $model->where($label, 'LIKE', '%' . $search . '%');
                }else{
                    $data = $data?->orWhere($label, 'LIKE', '%' . $search . '%');
                }
            }
            $total_count = $data->count();

            $relationshipOptions = $model->take($on_page)->skip($skip);
            foreach($labels as $key => $label){
                if($key == 0){
                    $relationshipOptions = $relationshipOptions->where($label, 'LIKE', '%' . $search . '%');
                }else{
                    $relationshipOptions = $relationshipOptions->orWhere($label, 'LIKE', '%' . $search . '%');
                }
            }

            $relationshipOptions = $relationshipOptions->get();
        } else {
            $total_count = $model->count();
            $relationshipOptions = $model->take($on_page)->skip($skip)->get();
        }

        $results = [];

        if (!$search && $page == 1) {
            $results[] = [
                'id' => '',
                'text' => 'aucune donnée trouvée',
            ];
        }

        $relationshipOptions = $relationshipOptions->sortBy($labels[0]);

        foreach ($relationshipOptions as $relationshipOption) {
            $text = '';
            foreach($labels as $key => $label){
                $text .= $relationshipOption->{$label}.' ';
            }
            $results[] = [
                'id' => $relationshipOption->id,
                'text' => trim($text),
            ];
        }

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($total_count > ($skip + $on_page)),
            ],
        ]);

        // No result found, return empty array
        // return response()->json([], 404);
    }
}
