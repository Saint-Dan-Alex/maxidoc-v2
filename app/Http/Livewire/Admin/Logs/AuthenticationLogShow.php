<?php

namespace App\Http\Livewire\Admin\Logs;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AuthenticationLogShow extends Component
{
    public int $logId;
    public array $log = [];

    public function mount(int $id)
    {
        $this->logId = $id;
        $row = DB::table('authentication_log')
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'authentication_log.authenticatable_id')
                     ->where('authentication_log.authenticatable_type', '=', 'App\\Models\\User');
            })
            ->select([
                'authentication_log.*',
                DB::raw('users.name as user_name'),
            ])
            ->where('authentication_log.id', $id)
            ->first();
        if ($row) {
            $this->log = (array) $row;
        }
    }

    public function render()
    {
        return view('livewire.admin.logs.authentication-log-show', [
            'log' => $this->log,
        ]);
    }
}
