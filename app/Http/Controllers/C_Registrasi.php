<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class C_Registrasi extends Controller
{
    public function index()
    {
        return view('v_registrasi', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users|alpha_dash',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'norek' => 'nullable|unique:users',
            'jenis_rek' => 'nullable',
            'atas_nama' => 'nullable',
            'nohp' => 'required|min:5|max:15|unique:users|alpha_num',
            'status' => 'required',
            'alamat' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('user-images');
        }

        // $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['nohp'] = Str::replace('08', '628', $validatedData['nohp']);
        $validatedData['nohp'] = Str::replace('8', '628', $validatedData['nohp']);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        return redirect('/login')->with('success', 'Pendaftaran akun berhasil, Silahkan Login');
    }
}
