<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index()
    {
        return Cita::with(['user', 'servicio.categoria'])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();
    }

    public function misCitas()
    {
        return Cita::with('servicio.categoria')
            ->where('user_id', Auth::id())
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
        ]);

        $ocupada = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();

        if ($ocupada) {
            return response()->json([
                'message' => 'Ese horario ya está ocupado'
            ], 422);
        }

        Cita::create([
            'user_id' => Auth::id(),
            'servicio_id' => $request->servicio_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'pendiente',
            'notas' => $request->notas
        ]);

        return response()->json([
            'message' => 'Cita reservada correctamente'
        ]);
    }

    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada,realizada'
        ]);

        $cita = Cita::findOrFail($id);

        $cita->estado = $request->estado;
        $cita->save();

        return response()->json([
            'message' => 'Estado actualizado'
        ]);
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);

        if ($cita->user_id != Auth::id() && Auth::user()->rol !== 'admin') {
            abort(403);
        }

        $cita->delete();

        return response()->json([
            'message' => 'Cita eliminada'
        ]);
    }
}
