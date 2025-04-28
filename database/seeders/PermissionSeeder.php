<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Exécuter le seeder.
     */
    public function run()
    {
        // Créer les permissions par défaut
        Permission::firstOrCreate(['name' => 'gerer salles']);
        Permission::firstOrCreate(['name' => 'gerer reservations']);
        Permission::firstOrCreate(['name' => 'gerer directions']);
        Permission::firstOrCreate(['name' => 'gerer utilisateurs']);
    }
}
