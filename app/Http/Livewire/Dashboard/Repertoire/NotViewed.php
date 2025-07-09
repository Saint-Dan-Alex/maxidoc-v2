<?php

namespace App\Http\Livewire\Dashboard\Repertoire;

use Livewire\WithPagination; 
use App\Models\User;
use App\Models\Courrier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotViewed extends Component
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
        $courriers = Courrier::with('expediteur','externExpediteur','externDestinateur','destinateurs');
        $courriers = $this->applyFilters($courriers);
        $courriers = $courriers->where('statut_id', '=', 1);
        $courriers = $this->applyPermissions($courriers);
        $courriers = $this->mapFollowers($courriers);
        $courriers = $this->paginateCollection($courriers, 10); 

        return view('livewire.dashboard.repertoire.not-viewed',[
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
