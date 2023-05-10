<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Kamar;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class C_Pengajuan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->status === 'admin') {
            return view('dashboard.pengajuan.index', [
                'title' => 'Kelola Pengajuan',
                'pengajuan' => Kost::paginate(10)
            ]);
        } else {
            return view('dashboard.pengajuan.index', [
                'title' => 'Kelola Pengajuan',
                'pengajuan' => Kost::where('user_id', auth()->user()->id)->paginate(10)
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pengajuan.create', [
            'title' => 'Mengajukan Kosan',
            'kategori' => Kategori::all()
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
            'slug' => 'nullable',
            'user_id' => 'required',
            'jenis' => 'required',
            'kategori_id' => 'required',
            'jarak' => 'required',
            'wc' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'status' => 'nullable',
            'komentar' => 'nullable',
            'image' => 'image|file|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('kost-images');
            $validatedData['image'] = $request->file('image')->move(('kost-images'), $validatedData['image']);
            // dd($validatedData);
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
        $jumlah = Kamar::where('kost_id', $kost->id)->sum('jumlah_kamar');
        $sisa = Kamar::where('kost_id', $kost->id)->sum('sisa_kamar');
        $harga_min = Kamar::where('kost_id', $kost->id)->min('harga');
        $harga_max = Kamar::where('kost_id', $kost->id)->max('harga');
        return view('dashboard.pengajuan.show', [
            'title' => 'Indekos',
            'kost' => $kost,
            'jumlah' => $jumlah,
            'min' => $harga_min,
            'max' => $harga_max,
            'sisa' => $sisa,
            'kamar' => Kamar::where('kost_id', $kost->id)->get()
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
        return view('dashboard.pengajuan.edit', [
            'title' => 'Mengubah Pengajuan',
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
    public function update(Request $request, $id)
    {
        $kost = Kost::find($id);

        $rules = [
            'nama' => 'nullable|max:255',
            'user_id' => 'nullable',
            'jenis' => 'nullable',
            'kategori_id' => 'nullable',
            'jarak' => 'nullable',
            'wc' => 'nullable',
            'alamat' => 'nullable',
            'deskripsi' => 'nullable',
            'status' => 'nullable',
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
            $validatedData['image'] = $request->file('image')->move(('kost-images'), $validatedData['image']);
        }

        if ($request->nama != $kost->nama) {
            $validatedData['slug'] = $validatedData['nama'] . ' ' . rand(1000, 9999);
            $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        }

        Kost::where('id', $kost->id)->update($validatedData);

        return redirect('/dashboard/pengajuan')->with('success', 'Data Pengajuan berhasil diubah');
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
        return redirect('/dashboard/pengajuan')->with('success', 'Data Pengajuan telah dihapus');
    }
}
