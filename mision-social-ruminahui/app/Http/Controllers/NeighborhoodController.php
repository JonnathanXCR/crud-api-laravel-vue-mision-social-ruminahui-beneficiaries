<?php

namespace App\Http\Controllers;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $neighborhoods = Neighborhood::all();
        return response()->json([
            'neighborhood' => $neighborhoods,
        ], 201);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $neighborhood = Neighborhood::create($validated);

        return response()->json([
            'message' => 'Se ha creado correctamente',
            'neighborhood' => $neighborhood,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtiene un barrio específico por ID
        $neighborhood = Neighborhood::findOrFail($id);
        return response()->json($neighborhood);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $neighborhood = Neighborhood::findOrFail($id);
        $neighborhood->update($validated);

        return response()->json([
            'message' => 'Se ha actualizado correctamente',
            'neighborhood' => $neighborhood,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $neighborhood = Neighborhood::findOrFail($id);
        $neighborhood->delete();
        return response()->json([
            'message' => 'Se ha eliminado correctamente',
            'neighborhood' => $neighborhood,
        ], 201);
    }
}
