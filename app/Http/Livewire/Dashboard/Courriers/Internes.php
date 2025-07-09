<?php

namespace App\Http\Livewire\Dashboard\Courriers;

use App\Models\Courrier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Internes extends Component
{

    public $search;
    public $filters = [
        1 => 'Auccun',
        2 => 'Nouveaux Courriers',
        3 => 'Courriers en retard',
        4 => 'En cours de traitement',
        5 => 'Date d\'entrée',
        6 => 'Date : Ajourd\'huit',
        7 => 'Date : hier',
    ];
    public $filterVal = 'Filtre';

    public function render()
    {
        // rewrite search logic
        $courriers = Courrier::where('type_id', 3)->where('statut_id', '!=', 3);

        if (!is_null($this->search)) {
            $elements = explode(' ', $this->search);
            foreach ($elements as $value) {
                $courriers = $courriers->search($value);
            }
        }

        $courriers = $courriers->orderBy('id', 'desc')->get()->take(5)->filter(function ($courrier) {
            return Auth::user()->can('view', $courrier);
            // ($courrier->isIntern() &&
            //     $courrier->destinateurs->count() &&
            //     in_array(Auth::user()->agent->id, $courrier->destinateurs->pluck('id')->toArray()) ||
            //     $courrier->created_by == Auth::user()->agent->id ||
            //     in_array(Auth::user()->agent->id, $courrier->followers->pluck('id')->toArray()) ||
            //     in_array(Auth::user()->agent->id, $courrier->partages->pluck('agent_id')->toArray())
            // );
        });

        $courriers = $this->mapFollowers($courriers);

        return view('livewire.dashboard.courriers.internes', compact('courriers'));
    }

    public function mapFollowers($courriers)
    {
        return $courriers->map(function ($courrier) {
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
                // $this->courriers = Courrier::notViewed()->get();
                break;
            case 3:
                $this->filterVal = $this->filters[$value];
                // $this->courriers = Courrier::scheduled()->isLate()->notClassified()->get();
                break;

            case 4:
                $this->filterVal = $this->filters[$value]; // 'Date : Ajourd\'huit';
                // $this->courriers = Courrier::whereNotNull('traitement_id')->notClassified()->get();
                break;
            case 5:
                $this->filterVal = $this->filters[$value]; // 'Date : Ajourd\'huit';
                // $this->courriers = Courrier::orderBy('date_arrive', 'desc')->get();
                break;
            case 6:
                $this->filterVal = $this->filters[$value]; // 'Date : Ajourd\'huit';
                // $this->courriers = $this->courriers->where('created_at', now()->format('Y-m-d'));
                break;

            case 7:
                $this->filterVal = $this->filters[$value]; // 'Date : hier';
                // $this->courriers = $this->courriers->where('created_at', now()->yesterday()->format('Y-m-d'))->groupBy('type_id');
                break;

            default:
                $this->filterVal = 'Filtre';
                $this->mount();
                break;
        }
    }
}
