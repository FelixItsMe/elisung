<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'foto'              => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        if ($request->file('foto')) {
            $foto = imageIntervention($request->file('foto'), 'photo/users/');

            $data->foto = $foto;
            $data->save();
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

    public function updatePassword(Request $request)
    {
        $data = User::find(auth()->user()->id);

        $v = Validator::make($request->all(),[
            'old_password' => 'required|current_password',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => $v->errors()
            ], 400);
        }

        $data->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'berhasil'
        ], 200);
    }
}
