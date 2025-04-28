<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolePermissionSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
{
    // Créer des rôles
    $adminRole = Role::create(['name' => 'admin']);
    $managerRole = Role::create(['name' => 'gestionnaire']);
    $userRole = Role::create(['name' => 'utilisateur']);

    // Créer des permissions
    Permission::create(['name' => 'gérer salles']);
    Permission::create(['name' => 'gérer réservations']);
    Permission::create(['name' => 'gérer directions']);
    Permission::create(['name' => 'gérer utilisateurs']);

    // Assigner des permissions aux rôles
    $adminRole->givePermissionTo(['gérer salles', 'gérer réservations', 'gérer directions', 'gérer utilisateurs']);
    $managerRole->givePermissionTo(['gérer salles', 'gérer réservations']);
    $userRole->givePermissionTo(['gérer réservations']);
}
}
