<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CultivavidaGroup;
use App\Models\User;

class CultivavidaGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = CultivavidaGroup::with('tutorUser')->get();
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);

        // Verificar el rol del tutor
        $tutor = User::find($validated['tutor']);
        

        if (!$tutor || !in_array($tutor->has_role, ['Colaborador', 'Administrador'])) {
            return response()->json([
                'message' => 'El tutor debe ser un usuario con rol de "Colaborador" o "Administrador".'
            ], 400); 
        }

        $group = CultivavidaGroup::create($validated);

        return response()->json([
            'message' => 'Se ha creado correctamente',
            'group' => $group,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = CultivavidaGroup::with('tutorUser')->findOrFail($id);
        return response()->json([
            'group' => $group,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = CultivavidaGroup::findOrFail($id);

        $validated = $request->validate([
            'tutor' => 'required|exists:users,id',
            'description' => 'required|string'
        ]);

        $group->update($validated);

        return response()->json([
            'message' => 'Se ha actualizado correctamente',
            'group' => $group,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = CultivavidaGroup::findOrFail($id);
        $group->delete();

        return response()->json([
            'message' => 'Se ha eliminado correctamente',
            'group' => $group,
        ], 204);
    }
}
