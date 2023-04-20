<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', [
            'title' => 'User',
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'no_telp' => 'required',
            'level' => 'required',
            'password' => 'required'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return redirect('/user');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'no_telp' => 'required',
            'level' => 'required',
        ]);
        if($request->input('password')) $validated['password'] = Hash::make($request->input('password'));
        User::where('id', $user->id)->update($validated);
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->username == 'admin') abort('403', 'Admin Tidak Dapat Dihapus');
        User::where('id', $user->id)->delete();
        BarangMasuk::where('user_id', $user->id)->delete();
        return redirect('/user');
    }

    function updateAdmin($id, Request $request) {
        $validated = $request->validate([
            'no_telp' => 'required',
        ]);
        if($request->input('password')) $validated['password'] = Hash::make($request->input('password'));
        User::where('id', $id)->update($validated);
        return redirect('/user');
    }
}