<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Permission::factory()->createMany([
            [
                'name' => 'Telecharger un document',
                'guard_name' => 'web',
                'module_id' => 4,
            ],
            [
                'name' => 'Imprimer un document',
                'guard_name' => 'web',
                'module_id' => 4,
            ]
        ]);
    }
}
