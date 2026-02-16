<?php

namespace App\Http\Livewire\Taches;

use App\Http\Controllers\File;
use App\Models\Classeur;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Tache;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\PdfToImage\Pdf;
use Intervention\Image\ImageManagerStatic as Image;


class TacheDocumentPane extends Component
{
    use WithFileUploads;

    public $tache;
    public $file;
    public $filePreview;

    protected $rules = [
        'file' => 'required|file',
    ];

    protected $listeners = ['deleteFichier' => 'deleteFichier'];

    public function mount($tache)
    {
        $this->tache = $tache;
    }

    public function updatedFile()
    {
        $this->validate();

        if ($this->file->getMimeType() === 'application/pdf') {
            $this->generatePdfPreview();
        } elseif (str_starts_with($this->file->getMimeType(), 'image')) {
            $this->filePreview = $this->file->temporaryUrl();
        }
    }

    public function addFichier()
    {
        // Vérification des permissions du dossier de logs
        $logPath = storage_path('logs/laravel.log');
        if (!is_writable(dirname($logPath))) {
            throw new \Exception("Le dossier de logs n'est pas accessible en écriture: " . dirname($logPath));
        }
        
        // Test d'écriture dans les logs
        Log::info('=== DÉBUT addFichier ===');
        Log::info('Validation du formulaire...');
        $this->validate();

        $classer = Classeur::where('direction_id', Auth::user()->agent->direction_id)
            ->where('titre', 'Documents partagés')
            ->first();
        if ($classer == null) {
            $classer = Classeur::firstOrCreate(
                [
                    'direction_id' => Auth::user()->agent->direction_id,
                    'titre' => 'Documents partagés',
                ],
                [
                    'reference' => 'CLS-PARTAGES-'.strtoupper(Str::random(8)),
                    'description' => 'Classeur pour les documents partagés (issus des tâches)',
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );
        }
        // Toujours utiliser/creer le Dossier "Documents partagés" sous ce classeur
        $dossier = Dossier::where('classeur_id', $classer->id)
            ->where('titre', 'Documents partagés')
            ->first();
        if ($dossier == null) {
            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => 'Documents partagés',
                ],
                [
                    'reference' => 'DOCS-PARTAGES/' . (Auth::user()->agent?->matricule ?? ''),
                    'confidentiel' => 0,
                    'description' => 'Dossier des documents partagés (issus des tâches) pour l\'agent ' . (Auth::user()->agent?->nom ?? ''),
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );
        }
        // Vérifier que le type de document existe
        $documentType = \App\Models\DocumentType::find(3);
        if (!$documentType) {
            throw new \Exception("Le type de document avec l'ID 3 n'existe pas dans la base de données");
        }
        
        // Déterminer le document principal (parent) le cas échéant
        $parentId = null;
        $parentCourrierId = null;
        Log::info('Début de la détermination du parent_document_id', [
            'tache_id' => $this->tache->id,
            'courrier_id' => $this->tache->courrier_id ?? 'null',
            'tache_data' => $this->tache->toArray()
        ]);
        try {
            if (!empty($this->tache->courrier_id)) {
                $courrier = \App\Models\Courrier::find($this->tache->courrier_id);
                if ($courrier) {
                    // Priorité au document principal s'il est défini sur le courrier
                    if (!empty($courrier->document_id)) {
                        $parent = \App\Models\Document::find($courrier->document_id);
                    } else {
                        // Sinon, prendre un document du courrier qui n'a pas de parent
                        $parent = $courrier->documents()->whereNull('parent_document_id')->first();
                    }
                    if ($parent) {
                        $parentId = $parent->id;
                        $parentCourrierId = $parent->courrier_id ?? $courrier->id;
                        Log::info('Parent document trouvé', [
                            'parent_id' => $parentId,
                            'parent_courrier_id' => $parentCourrierId,
                            'parent_data' => $parent->toArray()
                        ]);
                    } else {
                        // En dernier recours, lier au courrier si disponible
                        $parentCourrierId = $courrier->id;
                        Log::warning('Aucun document parent trouvé, utilisation du courrier comme parent', [
                            'courrier_id' => $courrier->id
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Impossible de déterminer le parent_document_id avant création', [
                'error' => $e->getMessage(),
            ]);
        }

        // Créer le document avec les champs de base d'abord (en incluant parent_document_id si disponible)
        Log::info('Création du document avec les paramètres', [
            'parent_document_id' => $parentId,
            'courrier_id' => $parentCourrierId,
            'dossier_id' => $dossier->id,
            'file' => $this->file->getClientOriginalName()
        ]);

        $document = new \App\Models\Document([
            'dossier_id' => $dossier->id,
            'libelle' => Str::beforeLast($this->file->getClientOriginalName(), '.'),
            'category_id' => 6, // ID de la catégorie
            'reference' => 'DT/' . Auth::user()->agent?->matricule,
            'document' => (new File)->handle($this->file, 'document', 'documents'),
            'user_id' => Auth::user()->id,
            'statut_id' => 1, // Statut par défaut
            'created_by' => Auth::user()->agent->id,
            'is_piece_jointe' => 1,
            'parent_document_id' => $parentId, // Peut être null si pas de parent
            'courrier_id' => $parentCourrierId, // Conserver la liaison au courrier si connue
        ]);
        
        // Associer le type de document
        $document->typeDocument()->associate($documentType);
        
        // Sauvegarder le document
        $document->save();
        \Illuminate\Support\Facades\Log::info('Document créé avec succès', [
            'document_id' => $document->id,
            'type' => $document->type,
            'type_relation' => $document->typeDocument ? $document->typeDocument->toArray() : null
        ]);

        $tache = Tache::findOrFail($this->tache->id);

        // Lier le document au document principal après création (idempotent si déjà défini)
        try {
            // Si le parent a été déjà déterminé plus haut, ce bloc n'écrasera rien
            $parent = null;
            if (!$document->parent_document_id && !empty($tache->courrier_id)) {
                $courrier = \App\Models\Courrier::find($tache->courrier_id);
                if ($courrier) {
                    if (!empty($courrier->document_id)) {
                        $parent = \App\Models\Document::find($courrier->document_id);
                    } else {
                        $parent = $courrier->documents()->whereNull('parent_document_id')->first();
                    }
                }
            }

            if ($parent) {
                $document->parent_document_id = $parent->id;
                if (is_null($document->courrier_id)) {
                    $document->courrier_id = $parent->courrier_id ?? $courrier->id ?? $document->courrier_id;
                }
                $document->statut_id = $parent->statut_id ?? $document->statut_id;
                if (isset($parent->mark_as_done)) {
                    $document->mark_as_done = $parent->mark_as_done;
                }
                $document->save();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Lien parent_document_id non appliqué', [
                'error' => $e->getMessage(),
            ]);
        }
        // Logs pour vérifier le passage avant l'attache du document à la tâche
        Log::info('Avant attach document->tache', [
            'tache_id' => $tache->id,
            'document_id' => $document->id,
        ]);
        $tache->attachDocumentAndPropagate($document->id);
        Log::info('Après attach document->tache OK', [
            'tache_id' => $tache->id,
            'document_id' => $document->id,
        ]);

        // Historique: ajout de document via le panneau Livewire (avec logs)
        try {
            Log::info('Historique::create avant', [
                'key' => 'Ajout de document',
                'tache_id' => $tache->id,
                'user_id' => Auth::id(),
                'agent' => Auth::user()->agent->only(['id','nom','prenom']) ?? null,
            ]);
            Historique::create([
                'key' => 'Ajout de document',
                'historiquecable_id' => $tache->id,
                'historiquecable_type' => Tache::class,
                'description' => Auth::user()->agent->nom . ' ' . Auth::user()->agent->prenom . ' a ajouté un document à la tâche.',
                'user_id' => Auth::user()->id,
            ]);
            Log::info('Historique::create OK', [
                'tache_id' => $tache->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Historique::create KO', [
                'tache_id' => $tache->id,
                'error' => $e->getMessage(),
            ]);
        }

        $this->reset('file');
        $this->file = '';

        $urls = [];
        foreach ($tache->documents as $document) {
            // array_push($urls, files($document->document)->link);
            array_push($urls, ['link' => files($document->document)->link, 'id' => $document->id, 'courrier_id' => $tache->courrier?->id ?? '']);
        }
        $this->emit('documentAdded', $urls);
        Log::info('=== FIN addFichier - Succès ===');
    }
 
     private function generatePdfPreview()
     {
         try {
             // Créer une instance de la classe PDF
             $pdf = new Pdf($this->file->getRealPath());
     
             // Définir la résolution de sortie (optionnel, mais recommandé pour la qualité)
             $pdf->setResolution(150);
     
             // Spécifier le format de sortie comme PNG
             $pdf->setOutputFormat('png');
     
             // Chemin de l'image temporaire (première page du PDF)
             $imagePath = sys_get_temp_dir() . '/' . uniqid('pdf_preview_', true) . '.png';
     
             // Convertir uniquement la première page en image
             $pdf->setPage(1)->saveImage($imagePath);
     
             // Vérifier si le fichier a été créé
             if (file_exists($imagePath)) {
                 $this->filePreview = url($imagePath);
             } else {
                 throw new \Exception("L'image de prévisualisation n'a pas pu être générée.");
             }
         } catch (\Exception $e) {
             // Gérer les erreurs possibles, par exemple les permissions, fichier mal formé, etc.
             $this->filePreview = null;
             session()->flash('error', "Une erreur est survenue lors de la génération de la prévisualisation du PDF : " . $e->getMessage());
         }
     }
     


    public function deleteFichier($fichierId)
    {
        try {
            Log::info('Tentative de suppression de fichier', ['fichier_id' => $fichierId, 'user_id' => Auth::id()]);
            
            $fichier = Document::find($fichierId);
            
            if (!$fichier) {
                Log::warning('Fichier non trouvé pour suppression', ['fichier_id' => $fichierId]);
                return;
            }

            Log::info('Vérification des permissions de suppression', [
                'owner_id' => $fichier->user_id,
                'current_user_id' => Auth::id(),
                'tache_statut' => $this->tache->statut
            ]);

            if ($fichier->user_id !== Auth::id()) {
                Log::warning('Tentative de suppression non autorisée (mauvais utilisateur)', ['user_id' => Auth::id(), 'owner_id' => $fichier->user_id]);
                return;
            }
            if (!$fichier) {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'title' => 'Erreur',
                    'text' => 'Document introuvable.'
                ]);
                return;
            }
            
            // Vérification des permissions : seul l'auteur peut supprimer SON propre document
            if ($fichier->user_id !== Auth::id()) {
                Log::warning('Suppression refusée: utilisateur non autorisé', ['fichier_id' => $fichierId, 'user_id' => Auth::id(), 'owner_id' => $fichier->user_id]);
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'title' => 'Non autorisé',
                    'text' => "Vous n'êtes pas autorisé à supprimer ce document."
                ]);
                return;
            }
            
            // Vérifier si la tâche est terminée (ou autre condition bloquante)
            if ($this->tache->statut === 2) { 
                 $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'title' => 'Action impossible',
                    'text' => "Impossible de supprimer une pièce jointe d'une tâche terminée."
                ]);
                return;
            }

            $oldName = $fichier->libelle;
            
            // Détacher de la tâche
            $this->tache->documents()->detach($fichierId);
            
            // Historique
            Historique::create([
                'key' => 'Suppression de document',
                'historiquecable_id' => $this->tache->id,
                'historiquecable_type' => Tache::class,
                'description' => Auth::user()->agent->nom . ' ' . Auth::user()->agent->prenom . ' a supprimé la pièce jointe "' . $oldName . '".',
                'user_id' => Auth::user()->id,
            ]);

            Log::info('Document supprimé avec succès de la tâche', ['document_id' => $fichierId]);
            
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'title' => 'Succès',
                'text' => 'Document supprimé avec succès.'
            ]);
            
            $this->refreshDocumentsList();

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du document', ['error' => $e->getMessage()]);
             $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'title' => 'Erreur',
                'text' => "Une erreur est survenue lors de la suppression."
            ]);
        }
    }

    private function refreshDocumentsList() {
        $urls = [];
        foreach ($this->tache->fresh()->documents as $document) {
            try {
                $fileInfo = files($document->document);
                $url = is_object($fileInfo) ? $fileInfo->link : '';
                if ($url) {
                    $url = str_replace('\\', '/', $url);
                        array_push($urls, [
                        'link' => $url,
                        'id' => $document->id,
                        'courrier_id' => $this->tache->courrier?->id ?? '',
                        'user_id' => $document->user_id,
                        'original_name' => is_object($fileInfo) ? $fileInfo->name : basename($url)
                    ]);
                }
            } catch (\Exception $e) {}
        }
        $this->emit('documentDeleted', $urls);
    }


    public function render()
    {
        return view('livewire.taches.tache-document-pane');
    }

}
