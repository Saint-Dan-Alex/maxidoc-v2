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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $lieuId = $request->input('lieu_id');

    $directionsQuery = Direction::with('lieu', 'responsable')
                        ->select('id', 'titre', 'lieu_id', 'responsable_id', 'code', 'adjoint_id');

    if ($lieuId) {
        $directionsQuery->where('lieu_id', $lieuId);
    }

    $directions = $directionsQuery->get();

    $lieus = LieuAffectation::select('titre', 'id')->get();

    $agents = Agent::orderBy('prenom')->get();

    return view('regidoc.pages.systems.direction', compact('directions', 'lieus', 'agents', 'lieuId'));
}


    // public function getAgents(Request $request){
    //     return $this->relation($request, 'agent');
    // }
    public function getAgents(Request $request)
    {
        
        $lieus = LieuAffectation::all();

        // Si tu as un filtre lieu_id dans la requête
        $lieuId = $request->input('lieu_id');

        $directions = Direction::query();

        if ($lieuId) {
            $directions->where('lieu_id', $lieuId);
        }

        $directions = $directions->get();

        $agents = Agent::orderBy('prenom')->get();

        return view('regidoc.pages.systems.direction', compact('directions', 'lieus', 'agents', 'lieuId'));


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
            $validated = $request->validate([
                'code' => 'nullable|string|max:50',
                'libelle' => 'required|string|max:255',
                'responsable_id' => 'nullable|exists:agents,id',
                'adjoint_id' => 'nullable|exists:agents,id',
                'lieu_id' => 'required|exists:lieu_affectations,id',
                'description' => 'nullable|string',
            ]);

            // Création de la direction
            $direction = Direction::create([
                'code' => $validated['code'] ?? null,
                'titre' => $validated['libelle'],
                'responsable_id' => $validated['responsable_id'] ?? null,
                'adjoint_id' => $validated['adjoint_id'] ?? null,
                'lieu_id' => $validated['lieu_id'],
                'description' => $validated['description'] ?? null,
            ]);

            // Création automatique d'une division avec le même nom
            $direction->divisions()->create([
                'libelle' => $validated['libelle'],
                'description' => $validated['description'] ?? null,
                'responsable_id' => $validated['responsable_id'] ?? null,
                'statut_id' => 1, // Statut actif par défaut
            ]);

            $fonction = Fonction::firstOrCreate([
                'titre' => 'Adjoint Responsable ' . $validated['libelle'],
            ], [
                'direction_id' => $direction->id,
            ]);

            if (!empty($validated['responsable_id'])) {
                $agent = Agent::find($validated['responsable_id']);
                if ($agent) {
                    $agent->update([
                        'fonction_id' => $fonction->id,
                        'direction_id' => $direction->id
                    ]);
                }
            }

            if (!empty($validated['adjoint_id'])) {
                $agentAdjoint = Agent::find($validated['adjoint_id']);
                if ($agentAdjoint) {
                    $agentAdjoint->update([
                        'fonction_id' => $fonction->id,
                        'direction_id' => $direction->id
                    ]);
                }
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Direction ajoutée avec succès',
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Direction ajoutée avec succès',
                    'data' => $direction,
                ]);
            }

            return redirect()->route('regidoc.directions.index')->with('session', $content);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La validation a échoué. Veuillez vérifier le formulaire.',
            ]);
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création de la Direction'], 500);
            }
            return back()->with('session', $content)->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de la Direction',
                ], 500);
            }
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "L'ajout de la Direction a échoué !",
            ]);
            return back()->with('session', $content);
        }
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

            $validated = $request->validate([
                'code' => 'nullable|string|max:50',
                'libelle' => 'required|string|max:255',
                'responsable_id' => 'nullable|exists:agents,id',
                'adjoint_id' => 'nullable|exists:agents,id',
                'lieu_id' => 'required|exists:lieu_affectations,id',
                'description' => 'nullable|string',
            ]);

            $direction->update([
                'code' => $validated['code'] ?? null,
                'titre' => $validated['libelle'],
                'responsable_id' => $validated['responsable_id'] ?? null,
                'adjoint_id' => $validated['adjoint_id'] ?? null,
                'lieu_id' => $validated['lieu_id'],
                'description' => $validated['description'] ?? null,
            ]);

            // Mise à jour de la division principale
            $division = $direction->divisions()->first();
            if ($division) {
                $division->update([
                    'libelle' => $validated['libelle'],
                    'description' => $validated['description'] ?? null,
                    'responsable_id' => $validated['responsable_id'] ?? null,
                ]);
            } else {
                // Si aucune division n'existe, on en crée une nouvelle
                $direction->divisions()->create([
                    'libelle' => $validated['libelle'],
                    'description' => $validated['description'] ?? null,
                    'responsable_id' => $validated['responsable_id'] ?? null,
                    'statut_id' => 1, // Statut actif par défaut
                ]);
            }

            $direction->code = $validated['code'] ?? null;
            $direction->save();
            // dd($direction->responsable_id != $request->responsable_id);

            if ($direction->responsable_id != ($validated['responsable_id'] ?? null)) {
                # code...
                $ancienAgent = Agent::find($direction->responsable_id);
                if ($ancienAgent) {
                    $ancienAgent->update([
                        'fonction_id' => null
                    ]);
                }
                $fonction = Fonction::firstOrCreate([
                    'titre' => 'Responsable ' . $validated['libelle'],
                ], [
                    "direction_id" => $id,
                ]);

                $agent = Agent::find($validated['responsable_id'] ?? null);
                if ($agent) {
                    $agent->update([
                        'fonction_id' => $fonction->id,
                        'direction_id' => $direction->id
                    ]);
                }
            }
            if ($direction->adjoint_id != ($validated['adjoint_id'] ?? null)) {
                # code...
                $ancienAgentAdjoint = Agent::find($direction->adjoint_id);
                if ($ancienAgentAdjoint) {
                    $ancienAgentAdjoint->update([
                        'fonction_id' => null
                    ]);
                }
                $fonction = Fonction::firstOrCreate([
                    'titre' => 'Adjoint Responsable ' . $validated['libelle'],
                ], [
                    "direction_id" => $id,
                ]);

                $agentAjoint = Agent::find($validated['adjoint_id'] ?? null);
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
                'message' => 'Direction modifiée avec succès',
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Direction modifiée avec succès',
                    'data' => $direction,
                ]);
            }

            return redirect()->route('regidoc.directions.index')->with('session', $content);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La validation a échoué. Veuillez vérifier le formulaire.',
            ]);
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour'], 500);
            }
            return back()->with('session', $content)->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification de la Direction a échoué ...!',
            ]);
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour'], 500);
            }
            return back()->with('session', $content);
        }
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
            $direction = Direction::findOrFail($id);
            $direction->delete();

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Direction supprimée avec succès',
            ]);

            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Direction supprimée avec succès']);
            }

            return redirect()->route('regidoc.directions.index')->with('session', $content);
        } catch (\Throwable $th) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La suppression de la Direction a échoué !',
            ]);
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
            }
            return back()->with('session', $content);
        }
    }

    // public function relation(Request $request, $slug)
    // {
    //     $page = $request->input('page');
    //     $on_page = 30;
    //     $search = $request->input('search', false);

    //     $method = $request->input('method', 'add');

    //     $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($slug))));

    //     // if ($method != 'add') {
    //     //     $model = $model->find($request->input('id'));
    //     // }
    //     // dd($request->input('id'));


    //     // $model = app('\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($request->input('model')))));
    //     $skip = $on_page * ($page - 1);

    //     $additional_attributes = $model->additional_attributes ?? [];

    //     $labels = explode(',', $request->input('label'));

    //     // If search query, use LIKE to filter results depending on field label
    //     if ($search) {
    //         $data = null;
    //         foreach($labels as $key => $label){
    //             if($key == 0){
    //                 $data = $model->where($label, 'LIKE', '%' . $search . '%');
    //             }else{
    //                 $data = $data?->orWhere($label, 'LIKE', '%' . $search . '%');
    //             }
    //         }
    //         $total_count = $data->count();

    //         $relationshipOptions = $model->take($on_page)->skip($skip);
    //         foreach($labels as $key => $label){
    //             if($key == 0){
    //                 $relationshipOptions = $relationshipOptions->where($label, 'LIKE', '%' . $search . '%');
    //             }else{
    //                 $relationshipOptions = $relationshipOptions->orWhere($label, 'LIKE', '%' . $search . '%');
    //             }
    //         }

    //         $relationshipOptions = $relationshipOptions->get();
    //     } else {
    //         $total_count = $model->count();
    //         $relationshipOptions = $model->take($on_page)->skip($skip)->get();
    //     }

    //     $results = [];

    //     if (!$search && $page == 1) {
    //         $results[] = [
    //             'id' => '',
    //             'text' => 'aucune donnée trouvée',
    //         ];
    //     }

    //     $relationshipOptions = $relationshipOptions->sortBy($labels[0]);

    //     foreach ($relationshipOptions as $relationshipOption) {
    //         $text = '';
    //         foreach($labels as $key => $label){
    //             $text .= $relationshipOption->{$label}.' ';
    //         }
    //         $results[] = [
    //             'id' => $relationshipOption->id,
    //             'text' => trim($text),
    //         ];
    //     }

    //     return response()->json([
    //         'results' => $results,
    //         'pagination' => [
    //             'more' => ($total_count > ($skip + $on_page)),
    //         ],
    //     ]);

    //     // No result found, return empty array
    //     // return response()->json([], 404);
    // }
    public function relation(Request $request, $slug)
{
    $page = $request->input('page', 1);
    $on_page = 30;
    $search = $request->input('search', false);
    $method = $request->input('method', 'add');
    $labels = explode(',', $request->input('label', 'nom'));

    $modelClass = '\App\Models\\' . Str::ucfirst(Str::camel(Str::singular($slug)));

    if (!class_exists($modelClass)) {
        return response()->json([
            'results' => [],
            'pagination' => ['more' => false],
        ]);
    }

    $query = app($modelClass)::query();

    // Si on demande des agents et qu'un filtre "relative_id" est fourni,
    // filtrer par service (service_id)
    if (strtolower($slug) === 'agent') {
        $relativeId = $request->input('relative_id');
        if (!empty($relativeId)) {
            $query->where('service_id', $relativeId);
        }
    }

    if ($search) {
        foreach ($labels as $index => $label) {
            if ($index === 0) {
                $query->where($label, 'LIKE', '%' . $search . '%');
            } else {
                $query->orWhere($label, 'LIKE', '%' . $search . '%');
            }
        }
    }

    $total_count = $query->count();

    $results = [];

    if (!$search && $page == 1) {
        $results[] = [
            'id' => '',
            'text' => 'aucune donnée trouvée',
        ];
    }

    $relationshipOptions = $query->skip(($page - 1) * $on_page)
                                 ->take($on_page)
                                 ->get()
                                 ->sortBy($labels[0]);

    foreach ($relationshipOptions as $item) {
        $text = '';
        foreach ($labels as $label) {
            // Sécuriser l'accès aux attributs inexistants
            $value = isset($item->{$label}) ? $item->{$label} : '';
            $text .= $value . ' ';
        }

        // Si on liste des agents, ajouter le service entre parenthèses si disponible
        if (strtolower($slug) === 'agent') {
            try {
                $serviceName = $item->service->titre ?? $item->service->nom ?? null;
            } catch (\Throwable $e) {
                $serviceName = null;
            }
            if (!empty($serviceName)) {
                $text = trim($text) . ' (' . $serviceName . ')';
            }
        }

        $results[] = [
            'id' => $item->id,
            'text' => trim($text),
        ];
    }

    return response()->json([
        'results' => $results,
        'pagination' => [
            'more' => ($total_count > ($page * $on_page)),
        ],
    ]);
}

}
