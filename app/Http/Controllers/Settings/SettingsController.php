<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    /**
     * Affiche la page principale des paramètres
     */
    public function index()
    {
        $menuItems = MenuItem::where('parent_id', 40) // ID 40 = Paramètres
            ->orderBy('order')
            ->get()
            ->filter(fn($item) => Gate::allows($item->policy))
            ->map(function($item) {
                $item->url = route($item->route);
                return $item;
            });

        return view('settings.index', [
            'menuItems' => $menuItems
        ]);
    }
}
