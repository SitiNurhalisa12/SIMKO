<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class C_User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.user.index', [
            'title' => 'Kelola Akun',
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.create', [
            'title' => 'Tambah Akun'
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users|alpha_dash',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|max:255',
            'jenis_rek' => 'nullable',
            'atas_nama' => 'nullable|unique:users',
            'norek' => 'nullable|unique:users',
            'nohp' => 'required|unique:users|alpha_num',
            'status' => 'required',
            'alamat' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('user-images');
        }

        $validatedData['nohp'] = Str::replace('08', '628', $validatedData['nohp']);
        $validatedData['nohp'] = Str::replace('8', '628', $validatedData['nohp']);
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        return redirect('/dashboard/user')->with('success', 'Tambah Data User Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('dashboard.user.show', [
            'title' => 'Info Akun',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit', [
            'title' => 'Ubah Akun',
            'user' => $user,
            'nohp' => Str::replace('62', '', $user->nohp)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'password' => 'required|max:255',
            'status' => 'nullable',
            'jenis_rek' => 'nullable',
            'atas_nama' => 'nullable',
            'alamat' => 'required',
            'image' => 'nullable|image|file|max:16384'
        ];

        if ($request->username != $user->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->nohp != $user->nohp) {
            $rules['nohp'] = 'required|unique:users';
        } else {
            $rules['nohp'] = 'required';
        }

        if ($request->norek != $user->norek) {
            $rules['norek'] = 'nullable|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('user-images');
        }

        $validatedData['nohp'] = Str::replace('08', '628', $validatedData['nohp']);
        $validatedData['nohp'] = Str::replace('8', '628', $validatedData['nohp']);

        $validatedData['password'] = bcrypt($validatedData['password']);
        User::where('id', $user->id)->update($validatedData);

        return redirect('/dashboard')->with('success', 'Data akun berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::delete($user->image);
        }
        if (auth()->user()->id === $user->id) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            User::destroy($user->id);
            return redirect('/login')->with('success', 'Data User telah dihapus');
        } else {
            return redirect('/dashboard/user')->with('success', 'Data Akun telah dihapus');
        }
    }

    public function profil()
    {
        $user = User::find(Auth()->user()->id);
        return view('dashboard.v_profil', [
            'title' => 'Profil',
            'user' => User::find(Auth()->user()->id),
            'nohp' => Str::replace('62', '', $user->nohp)
        ]);
    }
}
