<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        return Horario::orderBy('hora_inicio')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        Horario::create([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'activo' => true
        ]);

        return response()->json([
            'message' => 'Horario creado'
        ]);
    }

    public function update(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);

        $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        $horario->update([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return response()->json([
            'message' => 'Horario actualizado'
        ]);
    }

    public function cambiarEstado($id)
    {
        $horario = Horario::findOrFail($id);

        $horario->activo = !$horario->activo;
        $horario->save();

        return response()->json([
            'message' => 'Estado actualizado'
        ]);
    }

    public function destroy($id)
    {
        Horario::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Horario eliminado'
        ]);
    }
}
