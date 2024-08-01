<?php

namespace App\Http\Controllers;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persons = Person::all();
        return response()->json($persons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'dni' => 'required|string|max:20|unique:persons,dni',
                'name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'string|email|max:100|unique:persons,email',
                'birthday' => 'required|date',
                'gender' => 'required|in:Masculino,Femenino',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'neighborhood_id' => 'nullable|exists:neighborhoods,id',
                'user_id' => 'exists:users,id|unique:persons,user_id',
            ]);

            // Crear la nueva persona
            $person = Person::create($validated);
            // Responder con un mensaje de confirmación y los detalles de la persona
            return response()->json([
                'message' => 'Se ha registrado correctamente',
                'person' => $person,
            ], 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }    
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $dni)
    {
        $person = Person::findOrFail($dni);
        return response()->json($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $dni)
    {
        $person = Person::findOrFail($dni);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'email' => 'string|email|max:100|unique:persons,email,' . $person->dni . ',dni',
                'birthday' => 'required|date',
                'gender' => 'required|in:Masculino,Femenino',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'user_id' => 'exists:users,id|unique:persons,user_id,' . $person->dni . ',dni', 
            ]);

            $person->update($validated);
            // Responder con un mensaje de confirmación y los detalles de la persona
            return response()->json([
                'message' => 'Se ha actualizado correctamente',
                'person' => $person,
            ], 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        }   

        

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::findOrFail($dni);
        $person->delete();

        return response()->json(null, 204);
    }
}
