<?php

namespace App\Http\Livewire\Document;

use App\Models\Direction;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class DocumentIndex extends Component
{
    public $classeurs;
    public $dossiers;
    public $annee;
    public $mois;
    public $direction;
    public $brouillons;
    public $files;
    public $filter;
    public $search;
    public $division_id;
    public $filterText = 'Filtre';
    protected $queryString = ['direction', 'annee', 'mois'];

    public function mount()
    {
        $this->filter = "Tous";
        // $this->classeurs = Classeur::orderBy('created_at', 'desc')->get()
        // ->filter(function ($classeur)
        // {
        //     return Gate::allows('view', $classeur);
        //     // return Gate::allows('view_classeur', $classeur);
        // });
        $this->brouillons = collect();
        $agent_br = Auth::user()->agent->brouillons;
        $user_br = Auth::user()->brouillons;
        if ($agent_br->count() > 0) {
            $this->brouillons = $this->brouillons->merge($agent_br);
        }
        if ($user_br->count() > 0) {
            $this->brouillons = $this->brouillons->merge($user_br);
        }

        // dd($this->brouillons);

    }

    public function render()
    {
        $direction = Direction::find($this->direction);

        if ($direction) {
            $dossiers = Dossier::whereHas('documents', function ($query) use ($direction) {
                $query->whereIn('user_id', $direction->agents->pluck('user_id')->toArray());
            })
                ->select('id', 'created_at')
                ->orderBy('created_at', 'desc');
        } else {
            $dossiers = Dossier::whereHas('documents', function ($query) {
                if(Auth::user()->agent->isResponsable()){
                    $query->whereIn('user_id', Auth::user()->agent->direction->agents->pluck('user_id')->toArray());
                }else{
                    $query->where('user_id', Auth::user()->agent->user_id);
                }
            })->select('id', 'created_at')->orderBy('created_at', 'desc');
        }

        if ($this->annee) {
            $annees = $dossiers->whereYear('created_at', $this->annee)->get()->filter(function ($dossier) {
                return Auth::user()->can('view', $dossier);
            })->groupBy(function ($query) {
                return $query->created_at->isoFormat('MMMM');
            });

        } else {
            $annees = $dossiers->get()->filter(function ($dossier) {
                return Auth::user()->can('view', $dossier);
            })->groupBy(function ($query) {
                return $query->created_at->isoFormat('Y');
            });
        }

        $moisArr = ['janvier' => 1, 'fevrie' => 2, 'mars' => 3, 'avril' => 4, 'mai' => 5, 'juin' => 6, 'jullet' => 7, 'août' => 8, 'septembre' => 9, 'octobre' => 10, 'novembre' => 11, 'decembre' => 12];

        if ($this->mois) {

            $this->dossiers = Dossier::with('documents')->whereHas('documents', function ($query) use ($direction) {
                if ($direction) {
                    $query->whereIn('user_id', $direction->agents->pluck('user_id')->toArray());
                } else {
                    $query->whereIn('user_id', Auth::user()->agent->direction->agents->pluck('user_id')->toArray());
                }
            })
            ->whereMonth('created_at', $moisArr[$this->mois])
            ->get()
            ->filter(function ($dossier) {
                return Gate::allows('view', $dossier);
            });

        }

        return view('livewire.document.document-index')->with([
            'annees' => $annees,
        ]);
    }

    public function changeDate($date)
    {
        if (is_numeric($date)) {
            $this->annee = $date;
        } else {
            $this->mois = $date;

        }
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }
}
