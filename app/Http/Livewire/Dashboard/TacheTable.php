<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Courrier;
use App\Models\CourrierType;
use App\Models\PivotUserTache;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TacheTable extends Component
{
    // public $taches = [];
    // public $filters = [
    //     1 => 'Auccun',
    //     2 => 'Destinateur : A - Z',
    //     3 => 'Destinateur : Z - A',
    //     4 => 'Expediteur : A - Z',
    //     5 => 'Expediteur : Z - A',
    //     6 => 'Date d\'entrée',
    //     7 => 'Date : Ajourd\'huit',
    //     8 => 'Date : hier',
    // ];
    // public $filterVal = 'Filtres';

    // public function mount()
    // {
    //     $this->taches = Tache::where('tache_statut_id', 2)->whereIn('id', PivotUserTache::select('id')->where('agent_id', Auth::user()->agent->id)->get()->toArray())->orWhere('user_id', Auth::user()->id)->get();
    // }

    public function render()
    {
        $taches = Tache::whereIn(
            'id',
            PivotUserTache::select('id')
                ->where('agent_id', Auth::user()->agent->id)->get()->toArray()
        )
            ->orWhere('user_id', Auth::user()->id)
            ->where('tache_statut_id', 2)
            ->get()->take(9);
        return view('livewire.dashboard.tache-table', compact('taches'));
    }

    public function filter($value)
    {
        // $this->reset('courrierGroups');
        // switch ($value) {
        //     case 2:
        //         $this->filterVal = 'Destinateur : A - Z';

        //         break;

        //     case 3:
        //         $this->filterVal = 'Destinateur : Z - A';
        //         break;

        //     case 4:
        //         $this->filterVal = 'Expediteur : A - Z';
        //         break;

        //     case 5:
        //         $this->filterVal = 'Expediteur : Z - A';
        //         break;

        //     case 6:
        //         $this->filterVal = 'Date d\'entrée';
        //         $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
        //         {
        //             $query->notClassified()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        //             ->orderBy('created_at','asc');
        //         }])->get();
        //         break;

        //     case 7:
        //         $this->filterVal = 'Date : Ajourd\'huit';
        //         $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
        //         {
        //             $query->notClassified()->whereDate('created_at', now()->today())->orderBy('created_at','desc');
        //         }])->get();
        //         break;

        //     case 8:
        //         $this->filterVal = 'Date : hier';
        //         $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
        //         {
        //             $query->notClassified()->whereDate('created_at', now()->yesterday())->orderBy('created_at','desc');
        //         }])->get();
        //         break;

        //     default:
        //         $this->filterVal = 'Filtres';
        //         $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
        //         {
        //             $query->notClassified()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        //             ->orderBy('created_at','desc');
        //         }])->get();
        //         break;
        // }
    }
}
