<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        return Servicio::with('categoria')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
        ]);

        Servicio::create($request->all());

        return response()->json([
            'message' => 'Servicio creado'
        ]);
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
        ]);

        $servicio->update($request->all());

        return response()->json([
            'message' => 'Servicio actualizado'
        ]);
    }

    public function destroy($id)
    {
        Servicio::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Servicio eliminado'
        ]);
    }
}
