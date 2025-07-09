<?php

namespace App\Http\Livewire\Taches;

use App\Http\Controllers\File;
use App\Models\Classeur;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
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
        $this->validate();

        $classer = Classeur::where('direction_id', Auth::user()->agent->direction_id)
            ->where('titre', 'Classeur Tâches ' . Auth::user()->agent->direction?->titre)
            ->first();
        if ($classer == null) {
            $classer = Classeur::firstOrCreate(
                [
                    'direction_id' => Auth::user()->agent->direction_id,
                    'titre' => 'Tâches ',
                ],
                [
                    'reference' => Auth::user()->agent->direction?->code.'/'.Classeur::count(),
                    'description' => 'Classeur pour les documents de tâches ' . Auth::user()->agent?->direction->titre,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );
        }

        $dossier = Dossier::where('reference', 'DT/' . Auth::user()->agent?->matricule)->first();
        if ($dossier == null) {
            $dossier = Dossier::firstOrCreate(
                [
                    'classeur_id' => $classer->id,
                    'titre' => 'Taches',
                ],
                [
                    'reference' => 'DT/' . Auth::user()->agent?->matricule,
                    'confidentiel' => 0,
                    'description' => 'Dossier pour les documents créés de l\'agent ' . Auth::user()->agent?->nom,
                    'created_by' => Auth::user()->agent->id,
                    'updated_by' => Auth::user()->agent->id,
                ]
            );
        }

        $document = Document::create([
            'dossier_id' => $dossier->id,
            'libelle' => Str::beforeLast($this->file->getClientOriginalName(), '.'),
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

        $this->reset('file');
        $this->file = '';

        $urls = [];
        foreach ($tache->documents as $document) {
            // array_push($urls, files($document->document)->link);
            array_push($urls, ['link' => files($document->document)->link, 'id' => $document->id, 'courrier_id' => $tache->courrier?->id ?? '']);
        }

        $this->emit('documentAdded', $urls);
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
     


    // public function deleteFichier($fichierId)
    // {
    //     $fichier = Document::findOrFail($fichierId);

    //     Storage::disk('public')->delete($fichier->document);

    //     $fichier->delete();

    //     $this->emit('reloadComponent');
    // }

    public function render()
    {
        return view('livewire.taches.tache-document-pane');
    }

}
