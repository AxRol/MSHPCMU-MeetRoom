<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Salle;
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
        $roles = Role::all();
        $salles = Salle::all(); // Récupérer toutes les salles
        // Passer les rôles à la vue
        return view('users.create', compact('roles', 'salles'));

    }

    /**
     * Enregistrer un nouvel utilisateur.
     */
    public function store(Request $request)
    {
       $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:4|confirmed',
        'role' => 'required|string|exists:roles,name',
        'salles' => 'nullable|array', // Valider les salles
        'salles.*' => 'exists:salles,id', // Vérifier que chaque salle existe
            ]);

            // Création de l'utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Attribuer le rôle sélectionné
            $user->assignRole($request->role);

            // Si le rôle est "gestionnaire", attribuer les salles
            if ($request->role === 'administrateur') {
            $allSalleIds = Salle::pluck('id')->toArray();
            $user->salles()->sync($allSalleIds); // Associer toutes les salles
            } elseif ($request->role === 'gestionnaire' && $request->has('salles')) {
                $user->salles()->sync($request->salles); // Associer les salles
            } else {
                $user->salles()->detach(); // Détacher toutes les salles pour les autres rôles
            }

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
        $user = User::findOrFail($user->id);
        $roles = Role::all();
        $salles = Salle::all(); // Récupérer toutes les salles

    return view('users.edit', compact('user', 'roles', 'salles'));

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
            'password' => 'nullable|string|min:4|confirmed',
            'role' => 'required|string|exists:roles,name', // Vérifie que le rôle existe
            'salles' => 'nullable|array',
            'salles.*' => 'exists:salles,id',
        ]);

        // Mise à jour de l'utilisateur
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Synchroniser le rôle
        if ($request->role) {
            $user->syncRoles([$request->role]);
        }

        // Gestion des salles selon le rôle
    if ($request->role === 'administrateur') {
        $allSalleIds = Salle::pluck('id')->toArray();
        $user->salles()->sync($allSalleIds);
    } elseif ($request->role === 'gestionnaire') {
        $user->salles()->sync($request->input('salles', []));
    } else {
        $user->salles()->detach();
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
