<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForceDailyLogout extends Command
{
    protected $signature = 'auth:force-daily-logout';

    protected $description = 'Marquer la déconnexion pour toutes les sessions non fermées à 23h59 (authentication_log)';

    public function handle(): int
    {
        $now = now();
        // Mettre logout_at pour toutes les entrées ouvertes
        $affected = DB::table('authentication_log')
            ->where('login_successful', true)
            ->whereNull('logout_at')
            ->update(['logout_at' => $now]);

        $this->info("Déconnexions marquées: {$affected}");

        // Optionnel: si vous utilisez le driver de session 'database', vous pourriez purger ici
        // DB::table('sessions')->truncate(); // très intrusif, donc non activé par défaut

        return Command::SUCCESS;
    }
}
