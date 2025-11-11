<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LogsActivitesMenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Paramètres connus du projet
        $data = [
            'menu_id'       => 1,
            'parent_id'     => null, // item principal (comme Paramètres)
            'title'         => 'Logs d’activités',
            'url'           => '',
            'route'         => 'regidoc.logs.auth.index',
            'policy'        => "Voir l'historique des sessions",
            'target'        => '_self',
            'icon_regular'  => 'fi fi-rr-activity',
            'icon_solid'    => 'fi fi-sr-activity',
            'order'         => 9, // juste après Paramètres (order 8)
            'parameters'    => null,
            'created_at'    => $now,
            'updated_at'    => $now,
            'deleted_at'    => null,
        ];

        // Upsert pour éviter les doublons si déjà semé
        $exists = DB::table('menu_items')
            ->where('route', $data['route'])
            ->orWhere('title', $data['title'])
            ->first();

        if ($exists) {
            DB::table('menu_items')->where('id', $exists->id)->update([
                'menu_id'      => $data['menu_id'],
                'parent_id'    => $data['parent_id'],
                'url'          => $data['url'],
                'route'        => $data['route'],
                'policy'       => $data['policy'],
                'target'       => $data['target'],
                'icon_regular' => $data['icon_regular'],
                'icon_solid'   => $data['icon_solid'],
                'order'        => $data['order'],
                'parameters'   => $data['parameters'],
                'updated_at'   => $now,
                'deleted_at'   => null,
            ]);
        } else {
            DB::table('menu_items')->insert($data);
        }
    }
}
