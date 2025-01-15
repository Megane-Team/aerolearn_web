<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanPelatihan;
use App\Models\Pelatihan;
use App\Models\User;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin.home',[
            'internal' => User::where('user_role','peserta')->where('user_type','internal')->count(),
            'eksternal' => User::where('user_role','peserta')->where('user_type','eksternal')->count(),
            'pelatihan' => Pelatihan::count(),
            'pelaksanaan' => PelaksanaanPelatihan::count()
        ]);
    }
}
