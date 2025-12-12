<?php

namespace App\View\Components;

use App\Models\MenuItem;
use App\Models\Courrier;
use App\Models\Tache;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $menuItems;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->menuItems = collect();

        // Récupérer tous les éléments de menu principaux
        $this->menuItems = MenuItem::where('parent_id', null)
            ->orderBy('order')
            ->get()
            ->filter(function ($item) {
                // Pour l'élément Paramètres (ID 40), on vérifie s'il a des enfants accessibles
                if ($item->id == 40) {
                    $hasAccessibleChildren = MenuItem::where('parent_id', 40)
                        ->get()
                        ->filter(fn($child) => Gate::allows($child->policy))
                        ->isNotEmpty();
                    
                    return $hasAccessibleChildren && Gate::allows($item->policy);
                }
                
                return Gate::allows($item->policy);
            });

        $user = Auth::user();

        if ($user->agent) {
            $agentId = $user->agent->id;
            
            $inboxCount = Courrier::where('statut_id', 1)
                ->whereDoesntHave('views', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->where(function ($q) use ($agentId) {
                    $q->where('created_by', $agentId)
                      ->orWhereHas('destinateurs', function ($sq) use ($agentId) {
                          $sq->where('agent_id', $agentId);
                      })
                      ->orWhereHas('followers', function ($sq) use ($agentId) {
                          $sq->where('agent_id', $agentId);
                      })
                      ->orWhereHas('partages', function ($sq) use ($agentId) {
                          $sq->where('agent_id', $agentId);
                      });
                })
                ->count();

            $tasksCount = Tache::where('tache_statut_id', '!=', 3)
                ->where(function ($q) use ($user, $agentId) {
                    $q->where('user_id', $user->id)
                      ->orWhereHas('agents', function ($sq) use ($agentId) {
                          $sq->where('agents.id', $agentId);
                      });
                })
                ->count();
        } else {
            $inboxCount = 0;
            $tasksCount = 0;
        }

        $documentsNewCount = Document::where('statut_id', 1)->count();

        $archivesCount = Document::archive()->count();

        return view('components.sidebar', [
            'inboxCount' => $inboxCount,
            'tasksCount' => $tasksCount,
            'documentsNewCount' => $documentsNewCount,
            'archivesCount' => $archivesCount,
        ]);
    }

}
