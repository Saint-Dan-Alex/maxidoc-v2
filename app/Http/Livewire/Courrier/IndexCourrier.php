<?php

namespace App\Http\Livewire\Courrier;

use App\Models\Courrier;
use App\Models\CourrierType;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexCourrier extends Component
{
    use WithPagination;

    protected $courrierGroups = [];
    public $filters = [
        1 => 'Aucun',
        2 => 'Nouveaux Courriers',
        3 => 'Courriers en retard',
        4 => 'En cours de traitement',
        5 => 'Date d\'entrée',
        6 => 'Date : Aujourd\'hui',
        7 => 'Date : Hier',
    ];
    public $filterVal = 'Filtre';
    public $active_tab = 1;
    public $search = '';  
    public $selectedMonth = '';
    public $selectedYear = '';
    public $priority = null;
    public $statut = null;
    public $view = 1;

    protected $listeners = ['courrierAdd' => 'refreshPage'];
    protected $courriers;

    public function mount()
    {
        $this->loadCourriers();
    }

    public function loadCourriers()
    {
        $this->courriers = Courrier::orderBy('id', 'desc')->paginate(10);
        $this->mapFollowers();
        $this->groupCourriersByType();
    }

    public function groupCourriersByType()
    {
        // Regrouping courriers by type_id and paginating the grouped collection
        $items = collect($this->courriers->items())->groupBy('type_id');
        $this->courrierGroups = new LengthAwarePaginator(
            $items,
            $this->courriers->total(),
            $this->courriers->perPage(),
            $this->courriers->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function changeTab($tab)
    {
        if ($this->active_tab !== $tab) {
            $this->resetPage();
            $this->active_tab = $tab;
            $this->resetFilters();
        }
    } 

    public function refreshSelection()
    {
        $this->resetFilters();
    }

    private function resetFilters()
    {
        $this->selectedMonth = null;
        $this->selectedYear = null;
        $this->priority = null;
        $this->statut = null;
        $this->search = "";
    }

    
    public function render()
    {
        if (Session::has('courrierFilter')) {
            $this->filter(Session::get('courrierFilter'));
        }

        if ($this->search) {
            $this->courriers = Courrier::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('reference_interne', 'like', '%' . $this->search . '%')
                    ->orWhereHas('expediteur', function ($query) {
                        $query->where('prenom', 'like', '%' . $this->search . '%')
                            ->orWhere('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('postnom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('externExpediteur', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereDate('created_at', 'like', '%' . $this->search . '%');
            })->orderBy('id', 'desc')->paginate(10);

            $this->mapFollowers();
            $this->groupCourriersByType();
        } else {
            if ($this->filterVal == 'Filtre') {
                $this->loadCourriers();
            }
        }

        return view('livewire.courrier.index-courrier', [
            'courrierGroups' => $this->courrierGroups,
        ]);
    }

    public function refreshPage()
    {
        $this->loadCourriers();
    }

    public function mapFollowers()
    {
        $this->courriers->getCollection()->transform(function ($courrier) {
            $followers = collect();

            foreach ($courrier->etapes as $etape) {
                if ($etape->pivot->view_by) {
                    $followers->push(User::find($etape->pivot->view_by)->agent);
                }
            }

            $courrier->followers = $followers->unique();

            return $courrier;
        });
    }

    public function filter($value)
    {
        switch ($value) {
            case 2:
                $this->filterVal = $this->filters[$value];
                $this->courriers = Courrier::notViewed()->paginate(10);
                break;
            case 3:
                $this->filterVal = $this->filters[$value];
                $this->courriers = Courrier::scheduled()->isLate()->notClassified()->paginate(10);
                break;
            case 4:
                $this->filterVal = $this->filters[$value];
                $this->courriers = Courrier::where('statut_id','=',2)->notClassified()->paginate(10);
                break;
            case 5:
                $this->filterVal = $this->filters[$value];
                $this->courriers = Courrier::orderBy('date_arrive', 'desc')->paginate(10);
                break;
            case 6:
                $this->filterVal = $this->filters[$value];
                $this->courriers = Courrier::whereDate('created_at', now()->format('Y-m-d'))->paginate(10);
                break;
            case 7:
                $this->filterVal = $this->filters[$value];
                $this->courriers = Courrier::whereDate('created_at', now()->yesterday()->format('Y-m-d'))->paginate(10);
                break;
            default:
                $this->filterVal = 'Filtre';
                $this->loadCourriers();
                break;
        }

        $this->groupCourriersByType();
    }

    public function switchView($value)
    {
        $this->view = $value;
        $this->reset('courrierGroups');
        $this->courrierGroups = CourrierType::with(['courriers' => function ($query) {
            $query->notClassified()->orderBy('created_at', 'desc');
        }])->paginate(10);
    }
}
