<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use App\Models\Mesin;
use App\Models\SpesifikasiMesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('elisung.mesin.index', [
            'data' => Mesin::with('spesifikasi')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'nama'    => 'required|string|max:255',
            'seri'    => 'required|string|max:255',
            'tgl_produksi'      => 'required|date',
            'tgl_pembelian'     => 'required|date',
            'foto'              => 'required|image|mimes:jpg,png|max:2048',
            'spesifikasi'       => 'nullable|string'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        $foto = imageIntervention($request->file('foto'), 'photo/mesin/');

        $mesin = Mesin::create($request->only([
            'nama',
            'seri',
            'tgl_produksi',
            'tgl_pembelian',
        ])+[
            'foto' => $foto
        ]);

        foreach (json_decode($request->spesifikasi) as $spesifikasi) {
            if ($spesifikasi->name || $spesifikasi->value) {
                SpesifikasiMesin::create([
                    'mesin_id' => $mesin->id,
                    'name' => $spesifikasi->name,
                    'value' => $spesifikasi->value,
                ]);
            }
        }

        return response()->json([
            'message' => "Berhasil"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mesin = Mesin::find($id);

        if (!$mesin) {
            return response()->json([
                'message' => "Data tidak ditemukan!"
            ], 404);
        }

        $v = Validator::make($request->all(),[
            'nama'    => 'required|string|max:255',
            'seri'    => 'required|string|max:255',
            'tgl_produksi'      => 'required|date',
            'tgl_pembelian'     => 'required|date',
            'foto'              => 'nullable|image|mimes:jpg,png|max:2048',
            'spesifikasi'       => 'nullable|string'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        if ($request->file('foto')) {
            $foto = imageIntervention($request->file('foto'), 'photo/mesin/');

            $mesin->foto = $foto;
            $mesin->save();
        }

        $mesin->update($request->only([
            'nama',
            'seri',
            'tgl_produksi',
            'tgl_pembelian',
        ]));

        foreach (json_decode($request->spesifikasi) as $spesifikasi) {
            if ($spesifikasi->name || $spesifikasi->value) {
                if (!$spesifikasi->id || !$spek = SpesifikasiMesin::find($spesifikasi->id)) {
                    $spek = SpesifikasiMesin::create([
                        'mesin_id' => $mesin->id,
                        'name' => '',
                        'value' => ''
                    ]);
                }

                $spek->name = $spesifikasi->name;
                $spek->value = $spesifikasi->value;

                $spek->save();
            }
        }

        return response()->json([
            'message' => "Berhasil"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mesin = Mesin::find($id);

        if (!$mesin) {
            return response()->json([
                'message' => "Data tidak ditemukan!"
            ], 404);
        }

        $mesin->delete();

        return response()->json([
            'message' => "Berhasil"
        ], 200);
    }
}
