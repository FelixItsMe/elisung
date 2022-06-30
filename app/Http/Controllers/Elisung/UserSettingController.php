<?php

namespace App\Http\Controllers\Elisung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function index()
    {
        return view('elisung.setting-user.index');
    }
}
