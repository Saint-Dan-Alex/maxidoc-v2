<?php

namespace App\Http\Livewire\Systems;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Yadahan\AuthenticationLog\AuthenticationLog;

class LogSession extends Component
{
    use WithPagination;
    public $filter = 0;
    public $filterText = 'Filtre';
    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 0],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AuthenticationLog::with('authenticatable')
            ->when($this->search, function($query) {
                $search = strtolower($this->search);
                $query->whereHas('authenticatable', function($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                });
            });

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Connexion';
                $query->orderByDesc('login_at');
                break;
            case 2:
                $this->filterText = 'Déconnexion';
                $query->orderBy('logout_at', 'desc');
                break;
            default:
                $query->orderByDesc('login_at');
                break;
        }

        $logs = $query->paginate($this->perPage);

        return view('livewire.systems.log-session', [
            'logs' => $logs
        ]);

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
