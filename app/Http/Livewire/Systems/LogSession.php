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
    public $logs;
    public $filter;
    public $filterText;
    public $search;

    protected $paginationTheme = 'bootstrap-5';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->logs = AuthenticationLog::all();
        $this->filterText = "Filtre";
    }

    public function render()
    {

        if ($this->search) {
            $this->logs = $this->logs->filter(function ($log) {
                return Str::contains(Str::lower($log->authenticatable), Str::lower($this->search));
            });
        } else {
            $this->logs = AuthenticationLog::all();
        }

        switch ($this->filter) {
            case 1:
                $this->filterText = 'Connexion';
                $this->logs = $this->logs->sortByDesc('login_at');
                break;
            case 2:
                $this->filterText = 'Deconnexion';
                $this->logs = $this->logs->sortBy('logout_at');
                break;
            default:
                # code...
                break;
        }

        return view('livewire.systems.log-session');

    }

    public function changeFilter($value)
    {
        $this->filter = $value;
    }

}
