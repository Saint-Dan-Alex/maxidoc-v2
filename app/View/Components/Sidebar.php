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

        $this->menuItems = MenuItem::where('parent_id', null)->orderBy('order')->get()
            ->filter(function ($item) {
                return Auth::user()->can($item->policy);
                // Gate::allows($item->policy);
            });

        return view('components.sidebar');
    }

}
