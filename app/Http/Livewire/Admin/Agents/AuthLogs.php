<?php

namespace App\Http\Livewire\Admin\Agents;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AuthLogs extends Component
{
    use WithPagination;

    public int $userId;
    public string $search = '';
    public int $perPage = 10;

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount(int $userId)
    {
        $this->userId = $userId;
    }

    public function render()
    {
        // Table and columns come from the authentication-log migration
        $query = DB::table('authentication_log')
            ->where('authenticatable_type', 'App\\Models\\User')
            ->where('authenticatable_id', $this->userId)
            ->when($this->search !== '', function ($q) {
                $like = '%' . $this->search . '%';
                $q->where(function ($sub) use ($like) {
                    $sub->where('ip_address', 'like', $like)
                        ->orWhere('user_agent', 'like', $like);
                });
            })
            ->orderByDesc('login_at')
            ->orderByDesc('id');

        $logs = $query->paginate($this->perPage);

        return view('livewire.admin.agents.auth-logs', [
            'logs' => $logs,
        ]);
    }
}
