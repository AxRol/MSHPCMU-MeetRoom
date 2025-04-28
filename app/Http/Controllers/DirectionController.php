<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direction;
class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = Direction::all();
        return view('directions.index', compact('directions'));
    }

    public function create()
    {
        return view('directions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'nullable|string',
        ]);

        Direction::create($request->all());
        return redirect()->route('directions.index')->with('success', 'Direction créee avec succes.');
    }

    public function show(Direction $direction)
    {
        return view('directions.show', compact('direction'));
    }

    public function edit(Direction $direction)
    {
        return view('directions.edit', compact('direction'));
    }

    public function update(Request $request, Direction $direction)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'nullable|string',
        ]);

        $direction->update($request->all());
        return redirect()->route('directions.index')->with('success', 'Direction modifiée avec success.');
    }

    public function destroy(Direction $direction)
    {
        $direction->delete();
        return redirect()->route('directions.index')->with('success', 'Direction supprimé avec success.');
    }
}
