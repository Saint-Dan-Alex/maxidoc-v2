<?php

namespace App\Http\Livewire\Admin\Logs;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AuthenticationLogsIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 15;
    public ?array $selected = null;
    protected string $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $q = DB::table('authentication_log')
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'authentication_log.authenticatable_id')
                     ->where('authentication_log.authenticatable_type', '=', 'App\\Models\\User');
            })
            ->select([
                'authentication_log.id',
                'authentication_log.authenticatable_type',
                'authentication_log.authenticatable_id',
                'authentication_log.ip_address',
                'authentication_log.user_agent',
                'authentication_log.login_at',
                'authentication_log.login_successful',
                'authentication_log.logout_at',
                'authentication_log.location',
                DB::raw('users.name as user_name'),
            ])
            ->when($this->search !== '', function ($qb) {
                $s = '%' . str_replace(' ', '%', $this->search) . '%';
                $qb->where(function ($qq) use ($s) {
                    $qq->where('ip_address', 'like', $s)
                       ->orWhere('user_agent', 'like', $s)
                       ->orWhere('authenticatable_type', 'like', $s)
                       ->orWhere('authenticatable_id', 'like', $s);
                });
            })
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.admin.logs.authentication-logs-index', [
            'logs' => $q,
        ]);
    }

    public function show(int $id): void
    {
        $row = DB::table('authentication_log')->where('id', $id)->first();
        $this->selected = $row ? (array) $row : null;
        $this->dispatchBrowserEvent('open-auth-log-modal');
    }
}
