<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs.
     */
    public function index()
    {
        $userRole = auth()->user()->role;
        $users = User::all();
        return view('users.index', compact('users'), ['userRole' => $userRole]);
    }

    /**
     * Afficher le formulaire de création d'un utilisateur.
     */

    public function create()
    {
        // Récupérer tous les rôles
        $roles = Role::all();

        // Passer les rôles à la vue
        return view('users.create', compact('roles'));
    }

    /**
     * Enregistrer un nouvel utilisateur.
     */
    public function store(Request $request)
    {
       $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|exists:roles,name', // Vérifie que le rôle existe
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Attribuer le rôle sélectionné
        $user->assignRole($request->role);

            // Redirection vers la liste des utilisateurs avec un message de succès
            $utilisateur = $request->name;
            return redirect()->route('users.index')->with('success', "Utilisateur  $utilisateur créé avec succès.");
    }

    /**
     * Afficher les détails d'un utilisateur.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Afficher le formulaire de modification d'un utilisateur.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
      //  $permissions = Permission::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Mettre à jour un utilisateur.
     */
    public function update(Request $request, User $user)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name', // Vérifie que le rôle existe
        ]);

        // Mise à jour de l'utilisateur
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Synchroniser le rôle
        if ($request->role) {
            $user->syncRoles([$request->role]); // Synchronise le rôle sélectionné
        }

        // Redirection vers la liste des utilisateurs avec un message de succès
        $utilisateur = $request->name;
        return redirect()->route('users.index')->with('success', "Utilisateur $utilisateur mis à jour avec succès.");
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroy(User $user)
    {
        $user->delete();
        $utilisateur = $user->name;
        return redirect()->route('users.index')->with('success', "Utilisateur $utilisateur supprimé avec succès.");
    }
}
