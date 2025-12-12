<?php

namespace App\Http\Livewire\Dashboard\Courriers;

use App\Models\Courrier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Entrants extends Component
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
        $courriers = Courrier::where('type_id', 1)->where('statut_id', '!=', 3);

        if (!is_null($this->search)) {
            $elements = explode(' ', $this->search);
            foreach ($elements as $value) {
                $courriers = $courriers->search($value);
            }
        }

        // Filtrer pour ne montrer que les courriers où l'utilisateur est impliqué
        $courriers = $courriers->where(function ($query) {
            $agentId = Auth::user()->agent->id;
            $query->where('created_by', $agentId)
                ->orWhereHas('destinateurs', function ($q) use ($agentId) {
                    $q->where('agent_id', $agentId);
                })
                ->orWhereHas('followers', function ($q) use ($agentId) {
                    $q->where('agent_id', $agentId);
                })
                ->orWhereHas('partages', function ($q) use ($agentId) {
                    $q->where('agent_id', $agentId);
                });
        });

        $courriers = $courriers->orderBy('id', 'desc')->take(5)->get();

        $courriers = $this->mapFollowers($courriers);

        return view('livewire.dashboard.courriers.entrants', compact('courriers'));
    }

    public function mapFollowers($courriers)
    {
        return $courriers->map(function ($courrier) {
            $followers = collect();

            foreach ($courrier->etapes as $etape) {
                if ($etape->pivot->view_by) {
                    $user = User::with('agent')->find($etape->pivot->view_by);
                    if ($user && $user->agent) {
                        $followers->push($user->agent);
                    }
                }
            }

            $courrier->followers = $followers->unique('id');

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
