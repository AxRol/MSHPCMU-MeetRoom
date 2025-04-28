<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Exécuter le seeder.
     */
    public function run()
    {
        // Créer les rôles par défaut
        Role::firstOrCreate(['name' => 'administrateur']);
        Role::firstOrCreate(['name' => 'utilisateur']);
        Role::firstOrCreate(['name' => 'gestionnaire']);
    }
}
