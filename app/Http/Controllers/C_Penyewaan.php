<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Penyewaan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class C_Penyewaan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->status === 'admin') {
            return view('dashboard.penyewaan.index', [
                'title' => 'Kelola Penyewaan',
                'penyewaan' => Penyewaan::paginate(10)
            ]);
            // } elseif (auth()->user()->status === 'pemilik') {
            //     return view('dashboard.penyewaan.index', [
            //         'title' => 'Kelola Penyewaan',
            //         'penyewaan' => Penyewaan::where('user_id', auth()->user()->id)->paginate(10)
            //     ]);
        } elseif (auth()->user()->status === 'pemilik') {
            $penyewaan = Penyewaan::paginate(10);
            return view('dashboard.penyewaan.index', [
                'title' => 'Kelola Penyewaan',
                'penyewaan' => $penyewaan
            ]);
        } else {
            $penyewaan = Penyewaan::where('user_id', auth()->user()->id)->paginate(10);
            // return dd($penyewaan);
            return view('dashboard.penyewaan.index', [
                'title' => 'Kelola Penyewaan',
                'penyewaan' => $penyewaan
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
        $kamar = Kamar::where('slug', $slug)->first();
        return view('dashboard.penyewaan.create', [
            'title' => 'Tambah Penyewaan',
            'kamar' => $kamar,
            'awal' => now()->format('Y-m-d')
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
            'user_id' => 'required',
            'kamar_id' => 'required',
            'slug' => 'nullable|unique:penyewaans',
            'status' => 'nullable',
            'awal_sewa' => 'required',
            'akhir_sewa' => 'required',
            'keterangan' => 'nullable',
        ]);

        $user = User::find($request->user_id);
        $kamar = Kamar::find($request->kamar_id);

        $kamar->update(['sisa_kamar' => $kamar->sisa_kamar - 1]);

        $validatedData['slug'] = $user->name . ' ' . $kamar->tipe . ' ' . rand(1000, 9999);
        $validatedData['slug'] = Str::of($validatedData['slug'])->slug();

        Penyewaan::create($validatedData);
        return redirect('/dashboard/penyewaan/' . $validatedData["slug"])->with('success', 'Tambah Data Penyewaan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyewaan  $penyewaan
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $penyewaan = Penyewaan::where('slug', $slug)->first();
        $status = Penyewaan::status_sewa($penyewaan->status, $penyewaan->id);
        return $status;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyewaan  $penyewaan
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $penyewaan = Penyewaan::where('slug', $slug)->first();
        $kamar = Kamar::find($penyewaan->kamar_id);
        return view('dashboard.penyewaan.edit', [
            'title' => 'Perpanjang Penyewaan',
            'penyewaan' => $penyewaan,
            'kamar' => $kamar,
            'awal' => now()->format('Y-m')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penyewaan  $penyewaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penyewaan $penyewaan)
    {
        $rules = [
            'user_id' => 'nullable',
            'kamar_id' => 'required',
            'status' => 'nullable',
            'keterangan' => 'nullable',
            'no_kamar' => 'nullable',
            'awal_sewa' => 'required',
            'akhir_sewa' => 'required',
        ];

        if ($request->slug != $penyewaan->slug) {
            $rules['slug'] = 'nullable|unique:penyewaans';
        }

        $validatedData = $request->validate($rules);
        $user = User::find($request->user_id);
        $kamar = Kamar::find($request->kamar_id);

        if ($request->nama != $penyewaan->nama) {
            $validatedData['slug'] = $user->name . ' ' . $kamar->tipe . ' ' . rand(1000, 9999);
            $validatedData['slug'] = Str::of($validatedData['slug'])->slug();
        }


        $validatedData['status'] = 'menunggu';
        $validatedData['keterangan'] = NULL;
        Penyewaan::where('id', $penyewaan->id)->update($validatedData);

        return redirect('/dashboard/penyewaan')->with('success', 'Data Perpanjangan sudah dikirim');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyewaan  $penyewaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyewaan $penyewaan)
    {
        $kamar = Kamar::find($penyewaan->kamar->id);
        $kamar->update(['sisa_kamar' => $kamar->sisa_kamar + 1]);

        if ($penyewaan->image) {
            Storage::delete($penyewaan->image);
        }
        Penyewaan::destroy($penyewaan->id);
        return redirect('/dashboard/penyewaan')->with('success', 'Data Penyewaan telah dihapus');
    }
}
