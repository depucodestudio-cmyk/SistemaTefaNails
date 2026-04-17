<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return Categoria::orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre'
        ]);

        Categoria::create([
            'nombre' => $request->nombre
        ]);

        return response()->json([
            'message' => 'Categoría creada'
        ]);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $id
        ]);

        $categoria->update([
            'nombre' => $request->nombre
        ]);

        return response()->json([
            'message' => 'Categoría actualizada'
        ]);
    }

    public function destroy($id)
    {
        Categoria::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Categoría eliminada'
        ]);
    }
}
