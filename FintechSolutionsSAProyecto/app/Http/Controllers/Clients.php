<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Client;

use Illuminate\Http\Request;

class Clients extends Controller
{
    // Crea un cliente
    public function create(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date'
        ]);

        $client = Client::create($validated);

        if (!$client) {
            return response()->json([
                "message" => "Cliente no creado",
                "data" => null
            ], 404);
        }
        return response()->json([
            "message" => "Cliente creado exitosamente",
            "data" => $client
        ], 200);

    }

    // Extrae a todos los clientes
    public function store(Request $request)
    {
        $clients = Client::orderBy("client_id", "desc")->paginate(10);

        if (!$clients) {
            return response()->json([
                "message" => "Clientes no encontrados",
                "data" => null
            ], 404);
        }
        return response()->json([
            "message" => "Clientes obtenidos exitosamente",
            "data" => $clients
        ], 200);

    }

    // Extrae a un cliente por id
    public function readed(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                "message" => "Cliente no encontrado",
                "data" => null
            ], 404);
        }

        return response()->json([
            "message" => "Cliente obtenido exitosamente",
            "data" => $client
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                "message" => "Cliente no encontrado",
                "data" => null
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $client->client_id . ',client_id',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date'
        ]);

        $client->update($validated);

        return response()->json([
            "message" => "Cliente actualizado exitosamente",
            "data" => $client
        ], 200);
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json([
                "message" => "Cliente no encontrado",
                "data" => null
            ], 404);
        }

        $client->delete();

        return response()->json([
            "message" => "Cliente eliminado exitosamente",
            "data" => $client
        ], 200);
    }

}
