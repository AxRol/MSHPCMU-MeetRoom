<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'administrateur', 'guard_name' => 'web']);
        $gestionnaire = Role::firstOrCreate(['name' => 'gestionnaire', 'guard_name' => 'web']);
        $utilisateur = Role::firstOrCreate(['name' => 'utilisateur', 'guard_name' => 'web']);

        Permission::findOrCreate('gerer salles', 'web');
        Permission::findOrCreate('gerer reservations', 'web');
        Permission::findOrCreate('gerer directions', 'web');
        Permission::findOrCreate('gerer utilisateurs', 'web');

        // Assigner des permissions aux rôles
        $admin->givePermissionTo(['gerer salles', 'gerer reservations', 'gerer directions', 'gerer utilisateurs']);
        $gestionnaire->givePermissionTo(['gerer salles', 'gerer reservations', 'gerer directions']);
        $utilisateur->givePermissionTo(['gerer reservations']);

        $administrateur = User::create([
            'name' => 'Admin',
            'email' => 'admin@disd.ci',
            'password' => bcrypt('admindisd'),
        ]);
        $administrateur->assignRole($admin);

        $gestionnaire = User::create([
            'name' => 'Gestionnaire',
            'email' => 'gestionnaire@disd.com',
            'password' => bcrypt('gestionnairedisd'),
        ]);
        $gestionnaire->assignRole($gestionnaire);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@disd.com',
            'password' => bcrypt('admindisd'),
        ]);
        $user->assignRole($utilisateur);

    }
}

