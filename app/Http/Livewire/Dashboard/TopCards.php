<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Courrier;
use App\Models\PivotUserTache;
use App\Models\Tache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TopCards extends Component
{
    // public $nb_courriers;
    // public $nb_courriers_r; //en retard
    // public $nb_courriers_t; // en traitement...
    // public $nb_taches;

    public function render()
    {
        // $this->nbCourriers();

        $nb_courriers = Courrier:://notViewed()
                         where('statut_id','=',1)->get()->filter(function ($courrier) {
                            return Auth::user()->can('view', $courrier);
                        })->count();

        $nb_courriers_r = Courrier::scheduled()->isLate()->notClassified();
        $nb_courriers_r = $nb_courriers_r->where('statut_id','<>',3); 
        $nb_courriers_r = $nb_courriers_r->get()->filter(function ($courrier) {
                                    return Auth::user()->can('view', $courrier);
                                })->count();

        $nb_courriers_t = Courrier:://whereNotNull('traitement_id')
                            where('statut_id','=',2)->notClassified()->get()->filter(function ($courrier) {
                                return Auth::user()->can('view', $courrier);
                            })->count();

        $nb_courriers_tr = Courrier:://whereNotNull('traitement_id')
                        where('type_id',[1,3])->where('statut_id',3)->get()->filter(function ($courrier) {
                            return Auth::user()->can('view', $courrier);
                        })->count();

        // $nb_taches = Tache::where('user_id', Auth::user()->id)->where('tache_statut_id', '==', 1)->count();

        return view('livewire.dashboard.top-cards',[
            'nb_courriers' => $nb_courriers,
            'nb_courriers_r' => $nb_courriers_r,
            'nb_courriers_t' => $nb_courriers_t,
            'nb_courriers_tr' =>$nb_courriers_tr
            // 'nb_taches' => $nb_taches
        ]);
    }

    // function courrierTypeFilter($filter)
    // {
    //     switch ($filter) {
    //         case 2:
    //             Session::flash('courrierFilter', 2);
    //             return redirect()->route('regidoc.courriers.index');
    //             break;
    //         case 3:
    //             Session::flash('courrierFilter', 3);
    //             return redirect()->route('regidoc.courriers.index');
    //             break;
    //         case 4:
    //             Session::flash('courrierFilter', 4);
    //             return redirect()->route('regidoc.courriers.index');
    //             break;

    //         default:
    //             Session::flash('courrierFilter', 5);
    //             return redirect()->route('regidoc.taches.index');
    //             break;
    //     }
    // }

    public function nbCourriers()
    {
        // $this->nb_courriers = Courrier:://notViewed()
        // where('statut_id','=',1)->get()->filter(function ($courrier) {
        //     return Auth::user()->can('view', $courrier);
        // })->count();

        // //Courrier::whereNull('traitement_id')->notClassified()->count();

        // $this->nb_courriers_r = Courrier::scheduled()->isLate()->notClassified();
        // $this->nb_courriers_r = $this->nb_courriers_r->whereNotIn('statut_id',3);
        // $this->nb_courriers_r = $this->nb_courriers_r->get()->filter(function ($courrier) {
        //     return Auth::user()->can('view', $courrier);
        // })->count();

        // $this->nb_courriers_t = Courrier:://whereNotNull('traitement_id')
        // where('statut_id','=',2)->notClassified()->get()->filter(function ($courrier) {
        //     return Auth::user()->can('view', $courrier);
        // })->count();

        // $this->nb_taches = Tache::where('user_id', Auth::user()->id)->where('tache_statut_id', '==', 1)->count();
        // // Auth::user()->agent->taches()->where('tache_statut_id', '==', 1)->count();
    }
}
