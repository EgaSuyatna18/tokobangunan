<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    function index() {
        $title = 'Profile';
        $user = User::where('id', auth()->user()->id)->first();
        return view('profile.index', compact('title', 'user'));
    }

    function ubahPassword() {
        $validated = Request()->validate([
            'lama' => 'required',
            'baru' => 'required|same:konfirmasi',
            'konfirmasi' => 'required'
        ]);
        if(!password_verify($validated['lama'], auth()->user()->password)) {
            return redirect('/profile')->with('message', 'Gagal Mengubah Password!');
        }
        User::where('id', auth()->user()->id)->update(['password' => Hash::make($validated['baru'])]);
        return redirect('/profile')->with('message', 'Berhasil Mengubah Password');
    }
}