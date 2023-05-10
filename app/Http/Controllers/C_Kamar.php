<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Kamar;
use App\Models\Penyewaan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class C_Kamar extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.kamar.index', [
            'title' => 'Kelola Kamar'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $kost = Kost::where('slug', $slug)->first();
        return view('dashboard.kamar.create', [
            'title' => 'Tambah Kamar',
            'kost' => $kost
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
            'kost_id' => 'required',
            'tipe' => 'required',
            'slug' => 'nullable|unique:kamars',
            'harga' => 'required',
            'denda' => 'required',
            'jumlah_kamar' => 'required',
            'sisa_kamar' => 'nullable',
            'deskripsi' => 'required',
            'image' => 'image|file|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('kamar-images');
            $validatedData['image'] = $request->file('image')->move(('kamar-images'), $validatedData['image']);
        }
        $validatedData['sisa_kamar'] = $request->jumlah_kamar;
        $kost = Kost::find($request->kost_id);
        if (auth()->user()->status === 'admin') {
            $kost->update(['status' => 'disetujui']);
        }

        $validatedData['slug'] = $validatedData['tipe'] . ' ' . rand(1000, 9999);
        $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        Kamar::create($validatedData);
        if (auth()->user()->status === 'admin') {
            return redirect('/dashboard/kost/' . $kost->slug)->with('success', 'Tambah Data Kamar Berhasil');
        } else {
            return redirect('/dashboard/pengajuan/' . $kost->slug)->with('success', 'Tambah Data Kamar Berhasil');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kamar  $kamar
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $kamar = Kamar::where('slug', $slug)->first();
        $penyewaan = Penyewaan::where([
            ['kamar_id', $kamar->id],
            ['status', 'disetujui']
        ])->orWhere([
            ['kamar_id', $kamar->id],
            ['status', 'menunggak']
        ])->get();
        return view('dashboard.kamar.show', [
            'title' => 'Info Kamar',
            'kamar' => $kamar,
            'penyewa' => $penyewaan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kamar  $kamar
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $kamar = Kamar::where('slug', $slug)->first();
        return view('dashboard.kamar.edit', [
            'title' => 'Ubah Kamar',
            'kamar' => $kamar,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kamar  $kamar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $kamar = Kamar::where('slug', $slug)->first();
        $kost = Kost::find($kamar->kost_id);
        $rules = [
            'kost_id' => 'nullable',
            'tipe' => 'required',
            'harga' => 'required',
            'denda' => 'required',
            'jumlah_kamar' => 'required',
            'deskripsi' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:16384'
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('kamar-images');
            $validatedData['image'] = $request->file('image')->move(('kamar-images'), $validatedData['image']);
        }

        if ($request->tipe != $kamar->tipe) {
            $validatedData['slug'] = $validatedData['tipe'] . ' ' . rand(1000, 9999);
            $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        }

        Kamar::where('id', $kamar->id)->update($validatedData);

        return redirect('/dashboard/kost/' . $kost->slug)->with('success', 'Data Kamar Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kamar  $kamar
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $kamar = Kamar::where('slug', $slug)->first();
        if (Kamar::where('kost_id', $kamar->kost_id)->count() === 1) {
            Kost::find($kamar->kost_id)->update(['status' => 'menunggu']);
        }
        if ($kamar->image) {
            Storage::delete($kamar->image);
        }
        Kamar::destroy($kamar->id);
        return redirect('/dashboard/kost')->with('success', 'Data Kamar Berhasil Dihapus');
    }
}
