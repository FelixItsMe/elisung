<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use App\Models\Telemetri;
use Illuminate\Http\Request;

class TelemetriController extends Controller
{
    public function index()
    {
        return view('elisung.telemetri.index', [
            'data' => Telemetri::select(['t_awal', 't_akhir', 'waktu_penggilingan', 'beras', 'id'])
                ->latest()
                ->paginate(10)
        ]);
    }

    public function show($id)
    {
        $data = Telemetri::find($id);

        if (!$data) {
            return response()->json([
                'message' => "Data tidak ditemukan"
            ], 404);
        }

        return response()->json([
            'data' => $data,
            'message' => "Detail data telemetri"
        ], 200);
    }

    public function destroy($id)
    {
        $data = Telemetri::find($id);

        if (!$data) {
            return response()->json([
                'message' => "Data tidak ditemukan"
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => "Berhasil"
        ], 200);
    }
}
