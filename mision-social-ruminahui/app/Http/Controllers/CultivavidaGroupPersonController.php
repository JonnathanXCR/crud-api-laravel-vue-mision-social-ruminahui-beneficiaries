<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CultivavidaGroupPerson;

class CultivavidaGroupPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = CultivavidaGroupPerson::with(['group', 'person'])->get();
        return response()->json($assignments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {
            $validated = $request->validate([
                'cultivavida_group_id' => 'required|exists:cultivavida_groups,id',
                'person_dni' => 'required|exists:persons,dni'
            ]);
            // Verificar si la relación ya existe
            $existingAssignment = CultivavidaGroupPerson::where('cultivavida_group_id', $validated['cultivavida_group_id'])
            ->where('person_dni', $validated['person_dni'])
            ->first();


            // Crear la nueva asignación
            $assignment = CultivavidaGroupPerson::create($validated);

            // Responder con la nueva asignación creada
            return response()->json([
                'message' => 'Asignación creada correctamente.',
                'assignment' => $assignment
            ], 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }   



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assignment = CultivavidaGroupPerson::with(['group'])->findOrFail($id);
        return response()->json($assignment);
    }


    // Obtener todas las personas asignadas a un grupo específico
    public function getByGroup($groupId)
    {
        $assignments = CultivavidaGroupPerson::with('person')
            ->where('group_id', $groupId)
            ->get();

        return response()->json($assignments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assignment = CultivavidaGroupPerson::findOrFail($id);

        $validated = $request->validate([
            'cultivavida_group_id' => 'required|exists:cultivavida_groups,id',
            'person_dni' => 'required|exists:persons,dni'
        ]);

        $assignment->update($validated);

        return response()->json($assignment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assignment = CultivavidaGroupPerson::findOrFail($id);
        $assignment->delete();

        return response()->json(null, 204);

    }

    
}
