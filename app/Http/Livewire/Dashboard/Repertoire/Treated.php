<?php

namespace App\Http\Livewire\Dashboard\Repertoire;

use Livewire\WithPagination; 
use App\Models\User;
use App\Models\Courrier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Treated extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap-5';
    protected $listeners = ['CourrierCreated' => 'refreshCourriers'];

    public $search = ''; 
    public $priority = null;
    public $statut = null; 

     private function applyFilters($query)
    {   

        if (!empty($this->search)) {
            $query->where(function ($subQuery) {
                $subQuery->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('reference_interne', 'like', '%' . $this->search . '%')
                    ->orWhereHas('expediteur', function ($query) {
                        $query->where('prenom', 'like', '%' . $this->search . '%')
                            ->orWhere('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('post_nom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('externExpediteur', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    });
            });
        } 
       
        if (!empty($this->priority)) {
            $query->where('priorite_id', $this->priority);
        }

        if (!empty($this->statut)) {
            $query->where('statut_id', $this->statut);
        }

        return $query;
    }

    private function applyPermissions($query)
    {
        // Filtrer avant pagination en fonction des permissions
        return $query->get()->filter(function ($courrier) {
            return Auth::user()->can('view', $courrier);
        });
    }

    public function mapFollowers($courriers)
    {
        return $courriers->transform(function ($courrier) {
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
    
    public function render()
    {
        $courriersQuery = Courrier::with('expediteur', 'externExpediteur', 'externDestinateur', 'destinateurs');

        // Appliquer les filtres avant la récupération
        $courriersQuery = $this->applyFilters($courriersQuery);
        // $courriersQuery = $courriersQuery->scheduled()->isLate()->notClassified()->orderBy('id', 'desc'); 
        // $courriersQuery = $courriersQuery->scheduled()->isLate()->notClassified() 
        $courriersQuery = $courriersQuery->where('type_id',[1,3])->where('statut_id',3)->orderBy('id', 'desc');;

        // Filtrer les résultats basés sur les permissions AVANT de paginer
        $courriers = $this->applyPermissions($courriersQuery);

        // Transformer les courriers avant la pagination
        $courriers = $this->mapFollowers($courriers);

        // Paginer la collection filtrée
        $courriers = $this->paginateCollection($courriers, 10);

        return view('livewire.dashboard.repertoire.treated',[
            'courriers' => $courriers
        ]);
    }

    private function paginateCollection($items, $perPage)
    {
        $page = $this->page ?: 1;
        $total = $items->count();
        $results = $items->forPage($page, $perPage);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $results, 
            $total, 
            $perPage, 
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
