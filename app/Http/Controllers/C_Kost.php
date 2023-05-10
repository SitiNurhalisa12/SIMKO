<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Kategori;
use App\Models\Penyewaan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class C_Kost extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.kost.index', [
            'title' => 'Kelola Kost',
            'kost' => Kost::paginate(10),
            'kamar' => Kamar::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.kost.create', [
            'title' => 'Tambah Kost',
            'kategori' => Kategori::all(),
            'users' => User::where('status', 'pemilik')->get()
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
            'nama' => 'required|max:255',
            'slug' => 'nullable|unique:kosts',
            'user_id' => 'required',
            'jenis' => 'required',
            'kategori_id' => 'required',
            'jarak' => 'required',
            'wc' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'komentar' => 'nullable',
            'image' => 'image|file|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('kost-images');
        }

        $validatedData['slug'] = $validatedData['nama'] . ' ' . rand(1000, 9999);
        $validatedData['slug'] = Str::of($validatedData['slug'])->slug();

        Kost::create($validatedData);

        return redirect('/dashboard/kamar/create/' . $validatedData['slug'])->with('success', 'Tambah Data Kost Berhasil! Selanjutnya tambahkan informasi Kamar di Kostan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $kost = Kost::where('slug', $slug)->first();
        $kamar = Kamar::where('kost_id', $kost->id)->first();
        $jumlah = Kamar::where('kost_id', $kost->id)->sum('jumlah_kamar');
        $sisa = Kamar::where('kost_id', $kost->id)->sum('sisa_kamar');
        $harga_min = Kamar::where('kost_id', $kost->id)->min('harga');
        $harga_max = Kamar::where('kost_id', $kost->id)->max('harga');
        $penyewaan = Penyewaan::all();
        return view('dashboard.kost.show', [
            'title' => 'Indekos',
            'kost' => $kost,
            'jumlah' => $jumlah,
            'min' => $harga_min,
            'max' => $harga_max,
            'sisa' => $sisa,
            'kamar' => Kamar::where('kost_id', $kost->id)->get(),
            'penyewaan' => $penyewaan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $kost = Kost::where('slug', $slug)->first();
        return view('dashboard.kost.edit', [
            'title' => 'Ubah Kost',
            'kost' => $kost,
            'kategori' => Kategori::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kost $kost)
    {
        $rules = [
            'nama' => 'required|max:255',
            'user_id' => 'nullable',
            'jenis' => 'required',
            'kategori_id' => 'required',
            'jarak' => 'required',
            'wc' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'status' => 'required',
            'komentar' => 'nullable',
            'image' => 'image|mimes:jpg,jpeg,png|max:16384'
        ];

        if ($request->slug != $kost->slug) {
            $rules['slug'] = 'nullable|unique:kosts';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('kost-images');
        }

        if ($request->nama != $kost->nama) {
            $validatedData['slug'] = $validatedData['nama'] . ' ' . rand(1000, 9999);
            $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        }

        Kost::where('id', $kost->id)->update($validatedData);

        return redirect('/dashboard/kost')->with('success', 'Data Kost berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kost  $kost
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $kost = Kost::where('slug', $slug)->first();
        if ($kost->image) {
            Storage::delete($kost->image);
        }
        Kost::destroy($kost->id);
        return redirect('/dashboard/kost')->with('success', 'Data Kost telah dihapus');
    }

    public function kosan($slug)
    {
        $kost = Kost::where('slug', $slug)->first();
        $kamar = Kamar::where('kost_id', $kost->id)->first();
        return view('v_kostan', [
            'title' => 'Kostan',
            'kost' => $kost,
            'jumlah' => Kamar::find($kamar->id)->sum('jumlah_kamar'),
            'sisa' => Kamar::find($kamar->id)->sum('sisa_kamar'),
            'kecil' => Kamar::find($kamar->id)->min('harga'),
            'besar' => Kamar::find($kamar->id)->max('harga'),
            'kamar' => Kamar::where('kost_id', $kost->id)->get()
        ]);
    }
}
