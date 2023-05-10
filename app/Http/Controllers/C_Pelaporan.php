<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Pelaporan;
use App\Models\Penyewaan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class C_Pelaporan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->status === 'admin') {
            return view('dashboard.pelaporan.index', [
                'title' => 'Kelola pelaporan',
                'pelaporan' => Pelaporan::paginate(10)
            ]);
        } elseif (auth()->user()->status === 'pemilik') {
            $pelaporan = Pelaporan::paginate(10);
            return view('dashboard.pelaporan.index', [
                'title' => 'Kelola pelaporan',
                'pelaporan' => $pelaporan
            ]);
        } else {
            return view('dashboard.pelaporan.index', [
                'title' => 'Kelola pelaporan',
                'pelaporan' => Pelaporan::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $penyewaan = Penyewaan::where('slug', $slug)->first();
        return view('dashboard.pelaporan.create', [
            'title' => 'Tambah Pelaporan',
            'penyewaan' => $penyewaan
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
            'penyewaan_id' => 'required',
            'user_id' => 'required',
            'nama' => 'required',
            'slug' => 'nullable|unique:kamars',
            'jenis' => 'required',
            'informasi' => 'required',
            'status' => 'nullable',
            'keterangan' => 'nullable',
            'image' => 'image|file|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('pelaporan-images');
        }

        $user = User::find($request->user_id);

        $validatedData['slug'] = $user->name . ' ' . $validatedData['nama'] . ' ' . rand(1000, 9999);
        $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        Pelaporan::create($validatedData);
        return redirect('/dashboard/pelaporan')->with('success', 'Tambah Data Pelaporan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelaporan  $pelaporan
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $pelaporan = Pelaporan::where('slug', $slug)->first();
        return view('dashboard.pelaporan.show', [
            'title' => 'Info pelaporan',
            'pelaporan' => $pelaporan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelaporan  $pelaporan
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $pelaporan = Pelaporan::where('slug', $slug)->first();
        return view('dashboard.pelaporan.edit', [
            'title' => 'Ubah pelaporan',
            'pelaporan' => $pelaporan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelaporan  $pelaporan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelaporan $pelaporan)
    {
        $rules = [
            'penyewaan_id' => 'nullable',
            'user_id' => 'nullable',
            'nama' => 'nullable',
            'slug' => 'nullable|unique:kamars',
            'jenis' => 'nullable',
            'informasi' => 'nullable',
            'status' => 'nullable',
            'keterangan' => 'nullable',
            'image' => 'image|file|max:16384'
        ];

        if ($request->slug != $pelaporan->slug) {
            $rules['slug'] = 'nullable|unique:penyewaans';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('pelaporan-images');
        }

        if ($request->nama != $pelaporan->nama) {
            $validatedData['slug'] = $pelaporan->user->name . ' ' . $validatedData['nama'] . ' ' . rand(1000, 9999);
            $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        }

        Pelaporan::where('id', $pelaporan->id)->update($validatedData);

        return redirect('/dashboard/pelaporan')->with('success', 'Data Pelaporan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelaporan  $pelaporan
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $pelaporan = Pelaporan::where('slug', $slug)->first();
        if ($pelaporan->image) {
            Storage::delete($pelaporan->image);
        }
        Pelaporan::destroy($pelaporan->id);
        return redirect('/dashboard/pelaporan')->with('success', 'Data pelaporan telah dihapus');
    }
}
