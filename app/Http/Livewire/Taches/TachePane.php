<?php

namespace App\Http\Livewire\Taches;

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
    protected $listeners = ['reloadPane' => '$refresh'];
    protected $rules = [
        'message' => 'required|string',
        'file' => 'required|file',
    ];
    public function mount($tache, $pan = null)
    {
        $this->tache = $tache;
        $this->pourcentage = $tache->pourcentage;
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
            $this->emit('alert', 'success', 'Commentaire a été ajouté à la tâche');
            event(new TacheCreated($this->tache, $this->tache->user->agent->id, 'La tâche ' . $this->tache->titre . ' a un nouveau commentaire'));
        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('alert', 'error', 'Echec de l\`opération');
        }

    }
    public function addFichier()
    {
        try {
            //code...
            if ($this->file) {
                # code...
                $classer = Classeur::where('direction_id', Auth::user()->agent?->direction_id)->where('titre', 'Classeur Tâches ' . Auth::user()->agent?->direction->titre)->first();
                if ($classer == null) {
                    # code...
                    $classer = Classeur::firstOrCreate(
                        [
                            'direction_id' => Auth::user()->agent?->direction_id,
                            'titre' => 'Classeur tâches ' . Auth::user()->agent?->direction->titre,
                        ],
                        [
                            'description' => 'Classeur pour les documents des tâches',
                            'created_by' => Auth::user()->agent->id,
                            'updated_by' => Auth::user()->agent->id,
                        ]
                    );
                }
                $dossier = Dossier::where('titre', 'Dossier ' . Auth::user()->agent?->nom . ' ' . Auth::user()->agent?->post_nom)->where('reference', 'DT/' . Auth::user()->agent?->matricule)->first();
                if ($dossier == null) {
                    $dossier = Dossier::firstOrCreate(
                        [
                            'classeur_id' => $classer->id,
                            'titre' => 'Dossier ' . Auth::user()->agent?->nom . ' ' . Auth::user()->agent?->post_nom,
                        ],
                        [
                            'reference' => 'DT/' . Auth::user()->agent?->matricule,
                            'description' => 'Dossier pour les documents tâche ' . Auth::user()->agent?->nom . ' ' . Auth::user()->agent?->post_nom,
                            'confidentiel' => 0,
                            'created_by' => Auth::user()->agent->id,
                            'updated_by' => Auth::user()->agent->id,
                        ]
                    );

                }

                $document = Document::create([
                    'dossier_id' => $dossier->id,
                    'libelle' => Str::beforeLast($this->file?->getClientOriginalName() ?? $this->tache->id . date('dmYi'), '.'),
                    'category_id' => 6,
                    'reference' => 'DT/' . Auth::user()->agent?->matricule,
                    'type' => 3,
                    'document' => (new File)->handle($this->file, 'document', 'documents'),
                    'user_id' => Auth::user()->id,
                    'statut_id' => 1,
                    'created_by' => Auth::user()->agent->id,
                ]);
                $tache = Tache::findOrFail($this->tache->id);
                $tache->documents()->attach($document->id);
                $this->emit('alert', 'success', 'Document a été ajouté à la tâche');
                $this->reset('file');
                event(new TacheCreated($this->tache, $this->tache->user->agent->id, 'La tâche ' . $this->tache->titre . ' a un nouveau fichier'));
                $this->mount($this->tache, 3);
            }
        } catch (\Throwable $th) {
            $this->emit('alert', 'error', 'Echec de l\'opération, Réessayez svp');
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
        $this->fichiers = $this->tache->documents->sortByDesc('id');
        $this->commentaires = $this->tache->commentaires()->orderBy('created_at', 'desc')->get();

        return view('livewire.taches.tache-pane');
    }
}
