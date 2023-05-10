<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class C_Kategori extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.kategori.index', [
            'title' => 'Kelola Kategori',
            'kategori' => Kategori::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.kategori.create', [
            'title' => 'Tambah Kategori'
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
            'slug' => 'nullable|unique:kategoris',
            'alamat' => 'required',
            'image' => 'nullable|image|file|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('kategori-images');
        }

        $validatedData['slug'] = $validatedData['nama'] . ' ' . rand(1000, 9999);
        $validatedData['slug'] = Str::of($validatedData['slug'])->slug();

        Kategori::create($validatedData);

        return redirect('/dashboard/kategori')->with('success', 'Tambah Data Kategori Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        return view('dashboard.kategori.show', [
            'title' => 'Info Kategori',
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        return view('dashboard.kategori.edit', [
            'title' => 'Ubah Kategori',
            'kategori' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $rules = [
            'nama' => 'required|max:255',
            'slug' => 'nullable|unique:kategoris',
            'alamat' => 'required',
            'image' => 'nullable|image|file|max:16384'
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('kamar-images');
        }

        if ($request->nama != $kategori->nama) {
            $validatedData['slug'] = $validatedData['nama'] . ' ' . rand(1000, 9999);
            $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        }

        Kategori::where('id', $kategori->id)->update($validatedData);

        return redirect('/dashboard/kategori/')->with('success', 'Data Kategori Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        if ($kategori->image) {
            Storage::delete($kategori->image);
        }
        Kategori::destroy($kategori->id);
        return redirect('/dashboard/kategori')->with('success', 'Data Kategori Berhasil Dihapus');
    }

    public function kategori()
    {
        return view('v_kategori', [
            'title' => 'Kategori',
            'kategori' => Kategori::all()
        ]);
    }
}
