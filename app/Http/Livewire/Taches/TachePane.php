<?php

namespace App\Http\Livewire\Taches;

use Illuminate\Support\Facades\Log;

use App\Events\TacheCreated;
use App\Http\Controllers\File;
use App\Models\Classeur;
use App\Models\Commentaire;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Tache;
use App\Models\TacheObjectif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Historique;

class TachePane extends Component
{
    use WithFileUploads;

    public $tache;
    public $pourcentage;
    public $fichiers;
    public $commentaires;
    public $file;
    public $message;
    public $activec = true;
    public $activef = true;
    public $pan = 1;
    protected $listeners = [
        'reloadPane' => '$refresh',
        'participantUpdated' => 'handleParticipantUpdated',
        'participantAdded' => 'handleParticipantAdded'
    ];
    protected $rules = [
        'message' => 'required|string',
        'file' => 'required|file',
    ];
    public function mount($tache, $pan = null)
    {
        $this->tache = $tache;
        $this->pourcentage = $tache->pourcentage;
    }
    
    public function refreshTacheData()
    {
        $this->tache->refresh();
        $this->pourcentage = $this->tache->pourcentage;
    }

    public function handleParticipantUpdated()
    {
        $this->refreshTacheData();
        $this->emit('reloadPane');
    }
    
    public function handleParticipantAdded()
    {
        $this->refreshTacheData();
        $this->emit('reloadPane');
    }

    public function objetcifChangeStatut($id)
    {
        try {
            //code...
            $objectif = TacheObjectif::findOrFail($id);
            $statut = $objectif->statut;

            $objectif->update([
                'statut' => !$statut
            ]);
            $tache = Tache::findOrFail($objectif->tache_id);
            $a = TacheObjectif::where('tache_id',$this->tache->id)->count();
            $b = TacheObjectif::where('tache_id',$this->tache->id)->where('statut',1)->count();
            $pourcentage = ($b / $a) * 100;
            $tache->pourcentage = $pourcentage;
            $tache->save();

            $this->tache = $tache;
            $this->pourcentage = $pourcentage;

            Historique::create([
                "key" => "Mise à jour objectif",
                "historiquecable_id" => $tache->id,
                "historiquecable_type" => Tache::class,
                "description" => Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . " a réalisé l\’objectif de la tâche que vou lui avez assigné.",
                "user_id" => Auth::user()->id,
            ]);
            // $this->emit('reloadPane');
            $this->emit('alert', 'success', 'Objectif mis à jour avec succès');
            event(new TacheCreated($tache, $tache->user->agent->id, 'Objectif ' . $objectif->libelle . ' est mis à jour pour la tâche ' . $tache->titre));
        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('alert', 'error', 'Echec de l\`opération');
        }

    }

    public function addCommentaire()
    {
        try {
            //code...
            $this->validate([
                'message' => 'required', // Ajoutez ici les règles de validation pour le champ 'message'
            ]);
            Commentaire::create([
                'tache_id' => $this->tache->id,
                'user_id' => Auth::id(),
                'message' => $this->message,
            ]);

            $this->message = '';

            $this->emit('reloadPane');
            $this->pan = 2;
            $this->emit('alert', 'success', Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ' a ajouté un commentaire à la tâche');
            Historique::create([
                "key" => "Ajout d'un commentaire",
                "historiquecable_id" => $this->tache->id,
                "historiquecable_type" => Tache::class,
                "description" => Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . " a ajouté un commentaire à la tâche.",
                "user_id" => Auth::user()->id,
            ]);
            $this->emit('alert', 'success', Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . ' a ajouté un commentaire à la tâche');
            event(new TacheCreated($this->tache, $this->tache->user->agent->id, 'La tâche ' . $this->tache->titre . ' a un nouveau commentaire'));
        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('alert', 'error', 'Echec de l\`opération');
        }

    }
    public function addFichier()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        try {
            if (!$this->file) {
                $this->emit('alert', 'error', 'Aucun fichier sélectionné');
                return;
            }

            // Vérifier si le fichier est valide
            if (!$this->file->isValid()) {
                $this->emit('alert', 'error', 'Le fichier est invalide : ' . $this->file->getErrorMessage());
                return;
            }

            // Vérifier la taille du fichier (10MB max)
            if ($this->file->getSize() > 10 * 1024 * 1024) {
                $this->emit('alert', 'error', 'Le fichier est trop volumineux (max 10MB)');
                return;
            }

            // Vérifier l'extension du fichier
            $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];
            $extension = strtolower($this->file->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                $this->emit('alert', 'error', 'Type de fichier non autorisé. Types autorisés : ' . implode(', ', $allowedExtensions));
                return;
            }

            // Créer ou récupérer le classeur "Documents partagés"
            $classer = Classeur::firstOrCreate(
                [
                    'direction_id' => Auth::user()->agent?->direction_id,
                    'titre' => 'Documents partagés',
                ],
                [
                    'reference' => 'CLS-PARTAGES-' . strtoupper(Str::random(8)),
                    'description' => 'Classeur pour les documents partagés (issus des tâches)',
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );

            // Créer ou récupérer le dossier "Documents partagés" sous ce classeur
            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => 'Documents partagés',
                ],
                [
                    'reference' => 'DOCS-PARTAGES/' . (Auth::user()->agent?->matricule ?? ''),
                    'description' => 'Dossier des documents partagés (issus des tâches) pour l\'agent ' . (Auth::user()->agent?->nom . ' ' . (Auth::user()->agent?->post_nom ?? '')),
                    'confidentiel' => 0,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );

            // Traiter le fichier
            $fileHandler = new File();
            $fileData = $fileHandler->handle($this->file, 'file', 'documents');
            
            if (!$fileData) {
                throw new \Exception("Échec du traitement du fichier. Veuillez réessayer.");
            }
            
            // Créer le document
            $document = Document::create([
                'dossier_id' => $dossier->id,
                'libelle' => Str::beforeLast($this->file->getClientOriginalName(), '.'),
                'category_id' => 5, // Correspond à la catégorie des tâches
                'reference' => 'DT/' . Auth::user()->agent->matricule, // Même format que dans le contrôleur
                'type' => 3, // Type pour les pièces jointes
                'document' => $fileData,
                'user_id' => Auth::user()->id,
                'statut_id' => 5, // Même statut que dans le contrôleur
                'created_by' => Auth::user()->id,
                'is_piece_jointe' => 1,
            ]);

            // Associer le document à la tâche avec les champs supplémentaires
            $tache = Tache::findOrFail($this->tache->id);
            Log::info('Avant attach document->tache (TachePane)', [
                'tache_id' => $tache->id,
                'document_id' => $document->id,
            ]);
            $tache->attachDocumentAndPropagate($document->id, [
                'type_relation' => 'piece_jointe',
                'commentaire' => 'Document joint à la tâche',
                'version_document' => '1.0',
                'created_by' => Auth::id()
            ]);
            Log::info('Après attach document->tache OK (TachePane)', [
                'tache_id' => $tache->id,
                'document_id' => $document->id,
            ]);
            
            // Réinitialiser le champ de fichier
            $this->reset('file');
            
            // Rafraîchir la liste des fichiers
            $this->emit('refreshFiles');
            
            // Afficher un message de succès
            $this->emit('alert', 'success', 'Le document a été ajouté avec succès à la tâche');
            
            // Déclencher l'événement: propriétaire + agents assignés (hors auteur)
            event(new TacheCreated($tache, $tache->user->agent->id, 'La tâche ' . $tache->titre . ' a un nouveau fichier'));
            $auteurId = Auth::user()->agent->id;
            $agentsAssignes = $tache->agents()->get();
            foreach ($agentsAssignes as $agent) {
                if ($agent->id != $auteurId) {
                    event(new TacheCreated($tache, $agent->id, 'La tâche ' . $tache->titre . ' a un nouveau fichier'));
                }
            }
            $this->mount($this->tache, 3);

            try {
                Log::info('Historique::create avant (TachePane)', [
                    'key' => "Ajout d'une pièce jointe",
                    'tache_id' => $tache->id,
                    'user_id' => Auth::id(),
                ]);
                Historique::create([
                    "key" => "Ajout d'une pièce jointe",
                    "historiquecable_id" => $tache->id,
                    "historiquecable_type" => Tache::class,
                    "description" => Auth::user()->agent->nom . " " . Auth::user()->agent->prenom . " a ajouté une pièce jointe à cette tâche.",
                    "user_id" => Auth::user()->id,
                ]);
                Log::info('Historique::create OK (TachePane)', [
                    'tache_id' => $tache->id,
                ]);
            } catch (\Throwable $e) {
                Log::error('Historique::create KO (TachePane)', [
                    'tache_id' => $tache->id,
                    'error' => $e->getMessage(),
                ]);
            }
            
        } catch (\Throwable $th) {
            \Log::error('Erreur lors de l\'ajout du fichier : ' . $th->getMessage());
            $this->emit('alert', 'error', 'Echec de l\'opération : ' . $th->getMessage());
        }

        $this->fichiers = $this->tache->documents->sortByDesc('id');
        $this->emit('reloadPane');

        $this->pan = 3;
    }

    public function changeTab($value)
    {
        $this->pan = $value;
    }
    public function render()
    {
        switch ($this->pan) {
            case 1:
                $this->pan = 1;
                break;
            case 2:
                $this->pan = 2;
                break;
            case 3:
                $this->pan = 3;
                break;
            default:
                # code...
                break;
        }
        if ($this->file) {
            $this->activef = false;
        }
        if ($this->message) {
            $this->activec = false;
        }
        $this->tache->load(['documents', 'objectifs.agent']);
        $this->fichiers = $this->tache->documents->sortByDesc('id');
        $this->commentaires = $this->tache->commentaires()->orderBy('created_at', 'desc')->get();

        return view('livewire.taches.tache-pane');
    }
}
