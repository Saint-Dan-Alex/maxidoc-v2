<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Secretariat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SecretariatController extends Controller
{
    public function index()
    {
        return view('regidoc.pages.systems.secretariat');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
            'responsable_id' => 'required|exists:agents,id',
            'for' => 'nullable|in:1,2,3'
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
        $exists = Secretariat::where('titre', $request->titre)
            ->orWhere('responsable_id', $request->responsable_id)
            ->exists();

        if ($exists) {
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Un secrétariat avec ce nom ou ce responsable existe déjà.',
            ];
            return back()->with('session', json_encode($content));
        }

        DB::beginTransaction();
        
        try {
            // Création du secrétariat
            Secretariat::create([
                'titre' => $request->titre,
                'direction_id' => $request->direction_id,
                'responsable_id' => $request->responsable_id,
                'for_dg' => $request->for == 1 ? 1 : 0,
                'for_dga' => $request->for == 2 ? 1 : 0,
            ]);

            // ⚠️ On ne crée plus de fonction automatiquement

            DB::commit();

            $content = [
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Secrétariat ajouté avec succès',
            ];
            
            return back()->with('session', json_encode($content));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création du secrétariat: ' . $e->getMessage());
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Une erreur est survenue lors de l\'ajout du secrétariat.',
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
            'for' => 'nullable|in:1,2,3'
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
        $exists = Secretariat::where('id', '!=', $id)
            ->where(function($query) use ($request) {
                $query->where('titre', $request->titre)
                      ->orWhere('responsable_id', $request->responsable_id);
            })
            ->exists();

        if ($exists) {
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Un secrétariat avec ce nom ou ce responsable existe déjà.',
            ];
            return back()->with('session', json_encode($content));
        }

        DB::beginTransaction();

        try {
            $secretariat = Secretariat::findOrFail($id);

            // Mise à jour du secrétariat
            $secretariat->update([
                'titre' => $request->titre,
                'direction_id' => $request->direction_id,
                'responsable_id' => $request->responsable_id,
                'for_dg' => $request->for == 1 ? 1 : 0,
                'for_dga' => $request->for == 2 ? 1 : 0,
            ]);

            // ⚠️ On ne modifie plus les fonctions des agents

            DB::commit();

            $content = [
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Secrétariat modifié avec succès',
            ];
            
            return back()->with('session', json_encode($content));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour du secrétariat: ' . $e->getMessage());
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Une erreur est survenue lors de la modification du secrétariat.',
            ];
            
            return back()->with('session', json_encode($content));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $secretariat = Secretariat::findOrFail($id);
            
            // Suppression du secrétariat
            $secretariat->delete();
            
            // ⚠️ On ne touche plus aux fonctions des agents
            
            DB::commit();
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => 'Secrétariat supprimé avec succès',
            ];
            
            return back()->with('session', json_encode($content));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression du secrétariat: ' . $e->getMessage());
            
            $content = [
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'Une erreur est survenue lors de la suppression du secrétariat.',
            ];
            
            return back()->with('session', json_encode($content));
        }
    }
}
