<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurgeDeletedCourriers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courriers:purge';

    protected $description = 'Supprime définitivement les courriers placés à la corbeille depuis plus de 30 jours';

    public function handle()
    {
        $count = \App\Models\Courrier::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(30))
            ->forceDelete();

        $this->info("Purge terminée : {$count} courriers supprimés définitivement.");
        return Command::SUCCESS;
    }
}
