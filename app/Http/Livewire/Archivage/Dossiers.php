<?php

namespace App\Http\Livewire\Archivage;

use App\Models\Classeur;
use App\Models\Dossier;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Illuminate\Support\Str;

class Dossiers extends Component
{
    public $classeur;
    public $dossiers;
    public $files;
    public $filter;
    public $search;
    public $filterText = 'Filtre';

    public function mount(Classeur $classeur)
    {
        $this->classeur = $classeur;
        $this->filter = "Tous";
    }

    private function getNestedDossiers($parentId = null, $level = 0)
    {
        $agent = auth()->user()->agent;
        
        $query = Dossier::where('classeur_id', $this->classeur->id)
            ->where('parent_id', $parentId)
            ->whereHas('documents', function ($query) use ($agent) {
                $query->where('statut_id', 6);
                
                // Si l'agent n'est pas DG, on filtre par son service
                if (!$agent->isDG()) {
                    $query->where('service_id', $agent->service_id);
                }
            });

        if ($this->search) {
            $query->where(function($q) {
                $q->where('titre', 'like', '%' . $this->search . '%')
                  ->orWhere('reference', 'like', '%' . $this->search . '%');
            });
        }

        // Appliquer le tri
        switch ($this->filter) {
            case 2:
                $query->orderBy('titre');
                $this->filterText = 'A - Z';
                break;
            case 3:
                $query->orderByDesc('titre');
                $this->filterText = 'Z - A';
                break;
            case 4:
                $query->orderByDesc('created_at');
                $this->filterText = "Date d'ajout";
                break;
            case 5:
                $query->orderByDesc('updated_at');
                $this->filterText = 'Date de modification';
                break;
            default:
                $query->orderBy('titre');
                $this->filterText = 'Filtre';
                break;
        }

        $dossiers = $query->get();
        
        $result = collect();
        foreach ($dossiers as $dossier) {
            $dossier->level = $level;
            $result->push($dossier);
            
            // Récupérer les sous-dossiers
            $subDossiers = $this->getNestedDossiers($dossier->id, $level + 1);
            $result = $result->merge($subDossiers);
        }
        
        return $result;
    }

    public function render()
    {
        $this->dossiers = $this->getNestedDossiers();

        return view('livewire.archivage.dossiers');
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }
}
