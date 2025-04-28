<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salles = Salle::all();
        return view('salles.index', compact('salles'));
    }

    public function create()
    {
        return view('salles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'capacité' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        Salle::create($request->all());
        $sallenom = $request->nom;
        return redirect()->route('salles.index')->with('success', "Salle $sallenom créée avec succès.");
    }

    public function show(Salle $salle)
    {
        return view('salles.show', compact('salle'));
    }

    public function edit(Salle $salle)
    {
        return view('salles.edit', compact('salle'));
    }

    public function update(Request $request, Salle $salle)
    {
        $request->validate([
            'nom' => 'required',
            'capacité' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $salle->update($request->all());
        $sallenom = $request->nom;
        return redirect()->route('salles.index')->with('success', " Salle $sallenom a été modifiée avec succès.");
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();
        $sallenom = $salle->nom;
        return redirect()->route('salles.index')->with('success', "Salle $sallenom a été supprimé avec succès.");
    }
}
