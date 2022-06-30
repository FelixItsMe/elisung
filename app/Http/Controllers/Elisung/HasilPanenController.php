<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use App\Models\HasilPanen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HasilPanenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('elisung.hasil-panen.index', [
            'data' => HasilPanen::paginate(10)
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
            'tgl_panen' => 'required|date',
            'jumlah'    => 'required|numeric|min:0'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        HasilPanen::create($request->only([
            'jumlah',
            'tgl_panen',
        ]));

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
        $data = HasilPanen::find($id);

        if (!$data) {
            return response()->json([
                'message' => "Data tidak ditemukan!"
            ], 404);
        }

        $v = Validator::make($request->all(),[
            'tgl_panen' => 'required|date',
            'jumlah'    => 'required|numeric|min:0'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        $data->update($request->only([
            'jumlah',
            'tgl_panen',
        ]));

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
        $data = HasilPanen::find($id);

        if (!$data) {
            return response()->json([
                'message' => "Data tidak ditemukan!"
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => "Berhasil"
        ], 200);
    }
}
