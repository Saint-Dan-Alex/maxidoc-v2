<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Service;
use App\Models\Statut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Agent;
use Illuminate\Validation\ValidationException;

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
                'services' => Service::all(),
                'users' => User::select('name', 'id')->get(),
                'divisions' => Division::select('libelle', 'id')->get(),
                'statuts' => Statut::select('libelle', 'id')->get(),
                'agents' => Agent::select('prenom', 'id', 'nom')->get(),

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
        Log::info('Données reçues : ', $request->all());
        
        try {
            // Validation des données
            $validated = $request->validate([
                'libelle' => 'required|string|max:255',
                'description' => 'nullable|string',
                'responsable_id' => 'nullable|exists:agents,id',
                'direction_id' => 'required|exists:directions,id',
                'statut_id' => 'nullable|exists:statuts,id',
            ]);

            Log::info('Données validées : ', $validated);

            // Création du service
            $serviceData = [
                'titre' => $validated['libelle'],
                'direction_id' => $validated['direction_id'],
                'division_id' => $validated['direction_id'], // Utilisation de direction_id comme division_id
                'description' => $validated['description'] ?? null,
                'statut_id' => $validated['statut_id'] ?? 1, // Valeur par défaut si non spécifiée
            ];

            // Ajout du responsable_id s'il est fourni
            if (!empty($validated['responsable_id'])) {
                $serviceData['responsable_id'] = $validated['responsable_id'];
            }

            Log::info('Données du service à créer : ', $serviceData);
            
            $service = Service::create($serviceData);
            Log::info('Service créé avec succès : ', $service->toArray());

            // Création automatique d'une section liée au service
            $sectionData = [
                'titre' => $validated['libelle'],
                'description' => $validated['description'] ?? null,
                'division_id' => $validated['direction_id'], // Utilisation de direction_id comme division_id
                'statut_id' => $validated['statut_id'] ?? 1, // Même statut que le service
            ];

            // Ajout du responsable_id à la section s'il est fourni
            if (!empty($validated['responsable_id'])) {
                $sectionData['responsable_id'] = $validated['responsable_id'];
            }

            $section = $service->sections()->create($sectionData);
            Log::info('Section créée avec succès : ', $section->toArray());

            // Mise à jour de l'agent responsable si un responsable est fourni
            if (!empty($validated['responsable_id'])) {
                $agent = \App\Models\Agent::find($validated['responsable_id']);
                if ($agent) {
                    $agent->update([
                        'direction_id' => $validated['direction_id'],
                        'service_id' => $service->id
                    ]);
                    Log::info('Agent mis à jour avec succès : ', $agent->toArray());
                }
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Service créé avec succès",
            ]);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "La validation a échoué. Veuillez vérifier le formulaire.",
            ]);
            session()->flash('session', $content);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création du service : ' . $th->getMessage(), [
                'exception' => $th,
                'trace' => $th->getTraceAsString()
            ]);
            
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'L\'ajout du Service a échoué : ' . $th->getMessage(),
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
        Log::info('Mise à jour du service - Données reçues : ', $request->all());
        
        try {
            // Validation des données
            $validated = $request->validate([
                'libelle' => 'required|string|max:255',
                'description' => 'nullable|string',
                'responsable_id' => 'nullable|exists:agents,id',
                'direction_id' => 'required|exists:directions,id',
                'statut_id' => 'nullable|exists:statuts,id',
            ]);

            Log::info('Mise à jour du service - Données validées : ', $validated);

            // Récupération du service
            $service = Service::findOrFail($id);
            $ancienResponsableId = $service->responsable_id;

            // Préparation des données de mise à jour du service
            $serviceData = [
                'titre' => $validated['libelle'],
                'direction_id' => $validated['direction_id'],
                'division_id' => $validated['direction_id'], // Utilisation de direction_id comme division_id
                'description' => $validated['description'] ?? $service->description,
                'statut_id' => $validated['statut_id'] ?? $service->statut_id,
            ];

            // Ajout du responsable_id s'il est fourni
            if (!empty($validated['responsable_id'])) {
                $serviceData['responsable_id'] = $validated['responsable_id'];
            } else {
                $serviceData['responsable_id'] = null;
            }

            Log::info('Mise à jour du service - Données du service à mettre à jour : ', $serviceData);
            
            // Mise à jour du service
            $service->update($serviceData);
            Log::info('Service mis à jour avec succès : ', $service->toArray());

            // Préparation des données de la section
            $sectionData = [
                'titre' => $validated['libelle'],
                'description' => $validated['description'] ?? $service->description,
                'division_id' => $validated['direction_id'], // Utilisation de direction_id comme division_id
                'statut_id' => $validated['statut_id'] ?? $service->statut_id ?? 1,
            ];

            // Ajout du responsable_id à la section s'il est fourni
            if (!empty($validated['responsable_id'])) {
                $sectionData['responsable_id'] = $validated['responsable_id'];
            }

            // Mise à jour ou création de la section associée
            if ($service->sections()->exists()) {
                $section = $service->sections()->first();
                $section->update($sectionData);
                Log::info('Section mise à jour avec succès : ', $section->toArray());
            } else {
                $section = $service->sections()->create($sectionData);
                Log::info('Nouvelle section créée avec succès : ', $section->toArray());
            }

            // Mise à jour des agents responsables si le responsable a changé
            if ($ancienResponsableId != ($validated['responsable_id'] ?? null)) {
                // Réinitialisation de l'ancien responsable s'il existait
                if (!empty($ancienResponsableId)) {
                    $ancienResponsable = \App\Models\Agent::find($ancienResponsableId);
                    if ($ancienResponsable) {
                        $ancienResponsable->update([
                            'service_id' => null,
                            'direction_id' => null
                        ]);
                        Log::info('Ancien responsable mis à jour avec succès : ', $ancienResponsable->toArray());
                    }
                }

                // Mise à jour du nouveau responsable s'il est fourni
                if (!empty($validated['responsable_id'])) {
                    $nouveauResponsable = \App\Models\Agent::find($validated['responsable_id']);
                    if ($nouveauResponsable) {
                        $nouveauResponsable->update([
                            'service_id' => $service->id,
                            'direction_id' => $validated['direction_id']
                        ]);
                        Log::info('Nouveau responsable mis à jour avec succès : ', $nouveauResponsable->toArray());
                    }
                }
            }

            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'success',
                'message' => "Service et section associée mis à jour avec succès",
            ]);
        } catch (ValidationException $e) {
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => "La validation a échoué. Veuillez vérifier le formulaire.",
            ]);
            session()->flash('session', $content);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du service : ' . $th->getMessage(), [
                'exception' => $th,
                'trace' => $th->getTraceAsString()
            ]);
            
            $content = json_encode([
                'name' => 'Systèmes',
                'statut' => 'error',
                'message' => 'La modification du Service a échoué : ' . $th->getMessage(),
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

        return redirect()->back()->with('session', $content);
    }
}
