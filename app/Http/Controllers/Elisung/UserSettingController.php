<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserSettingController extends Controller
{
    public function index()
    {
        return view('elisung.setting-user.index');
    }

    public function update(Request $request)
    {
        $data = User::find(auth()->user()->id);

        $v = Validator::make($request->all(),[
            'tgl_lahir' => 'required|date',
            'name' => 'required|string|max:191',
            'jenis_kelamin' => 'required|in:l,p',
            'alamat' => 'required|string|max:1000',
            'nik' => 'required|numeric|digits:16|unique:users,nik,'.$data->id,
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        $data->update($request->only([
            'name',
            'nik',
            'tgl_lahir',
            'jenis_kelamin',
            'alamat'
        ]));

        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }
}
