<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Telemetri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelemetriController extends Controller
{
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'latitude' => 'required',
            'longitude'   => 'required',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'waktu_penggilingan' => 'required|integer',
            'bensin'  => 'required|numeric|min:0',
            'hasil_beras'  => 'required|numeric|min:0',
            'hasil_dedak'  => 'required|numeric|min:0',
            'gabah' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        Telemetri::create([
            't_awal' => $request->waktu_mulai,
            't_akhir' => $request->waktu_selesai,
            'waktu_penggilingan' => $request->waktu_penggilingan,
            'beras' => $request->hasil_beras,
            'dedak' => $request->hasil_dedak,
            'bensin_pakai' => $request->bensin,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'gabah' => $request->gabah
        ]);

        return response()->json([
            'message' => "Berhasil"
        ], 200);
    }
}
