<?php

namespace App\View\Components;

use App\Models\MenuItem;
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

        return view('components.sidebar');
    }

}
