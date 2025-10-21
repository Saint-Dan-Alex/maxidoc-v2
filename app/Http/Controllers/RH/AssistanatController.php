<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Assistanat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssistanatController extends Controller
{
    public function index()
    {
        return view('regidoc.pages.systems.assistanat');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'responsable_id' => 'required|exists:agents,id',
            'for' => 'required|in:1,2,3'
        ]);

        if ($validator->fails()) {
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Veuillez vérifier les champs du formulaire.',
            ];
            return back()->withErrors($validator)->withInput()->with('session', json_encode($content));
        }

        // Vérification des doublons
        $exists = Assistanat::where('titre', $request->titre)
            ->orWhere('responsable_id', $request->responsable_id)
            ->exists();

        if ($exists) {
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Un assistant avec ce nom ou ce responsable existe déjà.',
            ];
            return back()->with('session', json_encode($content));
        }

        DB::beginTransaction();
        
        try {
            // Création de l'assistanat
            $assistant = Assistanat::create([
                "titre" => $request->titre,
                "direction_id" => $request->direction_id,
                "responsable_id" => $request->responsable_id,
                "for_dg" => $request->for == 1 ? 1 : 0,
                "for_dga" => $request->for == 2 ? 1 : 0,
            ]);

            // ⚠️ On ne crée plus de fonction automatiquement

            DB::commit();

            $content = [
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Assistant ajouté avec succès",
            ];
            
            return back()->with('session', json_encode($content));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de l\'assistant: ' . $e->getMessage());
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Une erreur est survenue lors de l\'ajout de l\'assistant.',
            ];
            
            return back()->with('session', json_encode($content));
        }
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'responsable_id' => 'required|exists:agents,id',
            'for' => 'required|in:1,2,3'
        ]);

        if ($validator->fails()) {
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Veuillez vérifier les champs du formulaire.',
            ];
            return back()->withErrors($validator)->withInput()->with('session', json_encode($content));
        }

        // Vérification des doublons (sauf l'enregistrement actuel)
        $exists = Assistanat::where('id', '!=', $id)
            ->where(function($query) use ($request) {
                $query->where('titre', $request->titre)
                      ->orWhere('responsable_id', $request->responsable_id);
            })
            ->exists();

        if ($exists) {
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Un assistant avec ce nom ou ce responsable existe déjà.',
            ];
            return back()->with('session', json_encode($content));
        }

        DB::beginTransaction();

        try {
            $assistant = Assistanat::findOrFail($id);
            $ancienResponsableId = $assistant->responsable_id;

            // Mise à jour de l'assistanat
            $assistant->update([
                "titre" => $request->titre,
                "direction_id" => $request->direction_id,
                "responsable_id" => $request->responsable_id,
                "for_dg" => $request->for == 1 ? 1 : 0,
                "for_dga" => $request->for == 2 ? 1 : 0,
            ]);

            // ⚠️ On ne modifie plus les fonctions des agents

            DB::commit();

            $content = [
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Assistant modifié avec succès",
            ];
            
            return back()->with('session', json_encode($content));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de l\'assistant: ' . $e->getMessage());
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Une erreur est survenue lors de la modification de l\'assistant.',
            ];
            
            return back()->with('session', json_encode($content));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $assistant = Assistanat::findOrFail($id);
            
            // Suppression de l'assistant
            $assistant->delete();
            
            // ⚠️ On ne touche plus aux fonctions des agents
            
            DB::commit();
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Assistant supprimé avec succès',
            ];
            
            return back()->with('session', json_encode($content));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression de l\'assistant: ' . $e->getMessage());
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression de l\'assistant.',
            ];
            
            return back()->with('session', json_encode($content));
        }
    }
}
