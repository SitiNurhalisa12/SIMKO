<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kamar;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class C_Pembayaran extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->status === 'admin') {
            return view('dashboard.pembayaran.index', [
                'title' => 'Kelola pembayaran',
                'pembayaran' => Pembayaran::paginate(10)
            ]);
        } elseif (auth()->user()->status === 'pemilik') {
            $pembayaran = Pembayaran::paginate(10);
            return view('dashboard.pembayaran.index', [
                'title' => 'Kelola pembayaran',
                'pembayaran' => $pembayaran
            ]);
        } else {
            $pembayaran = Pembayaran::where('user_id', auth()->user()->id)->get();
            // return dd($pembayaran);
            return view('dashboard.pembayaran.index', [
                'title' => 'Kelola pembayaran',
                'pembayaran' => $pembayaran
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
        $durasi = Penyewaan::durasi($penyewaan->awal_sewa, $penyewaan->akhir_sewa);
        $bayar = Penyewaan::bayar($durasi, $penyewaan->kamar->harga);
        $denda = Penyewaan::bayar_denda($penyewaan->akhir_sewa, now()->format('Y-m-d'), $penyewaan->id);
        return view('dashboard.pembayaran.create', [
            'title' => 'Tambah Pembayaran',
            'penyewaan' => $penyewaan,
            'kamar' => $penyewaan->kamar,
            'kost' => $penyewaan->kamar->kost,
            'durasi' => $durasi,
            'bayar' => $bayar,
            'denda' => $denda,
            'pemilik' => $penyewaan->user
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
            'slug' => 'nullable|unique:penyewaans',
            'no_transfer' => 'required',
            'durasi_sewa' => 'nullable',
            'harga_sewa' => 'nullable',
            'denda' => 'nullable',
            'total_bayar' => 'nullable',
            'jenis' => 'nullable',
            'status' => 'nullable',
            'komentar' => 'nullable',
            'image' => 'image|file|max:16384'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('pembayaran-images');
        }
        $user = User::find($request->user_id);
        $penyewaan = Penyewaan::find($request->penyewaan_id);

        $validatedData['durasi_sewa'] = Penyewaan::durasi($penyewaan->awal_sewa, $penyewaan->akhir_sewa);
        $validatedData['harga_sewa'] = Penyewaan::bayar($validatedData['durasi_sewa'], $penyewaan->kamar->harga);;
        $validatedData['denda'] = Penyewaan::bayar_denda($penyewaan->akhir_sewa, now()->format('Y-m-d'), $penyewaan->id);
        $validatedData['total_bayar'] = $validatedData['harga_sewa'] + $validatedData['denda'];
        $validatedData['jenis'] = Pembayaran::jenis_bayar($penyewaan->id);

        $validatedData['slug'] = $user->name . ' ' . $request->no_transfer . ' ' . rand(1000, 9999);
        $validatedData['slug'] = Str::of($validatedData['slug'])->slug();

        $penyewaan->update([
            'status' => 'lunas',
            'keterangan' => 'Menunggu verifikasi dari pemilik kosan'
        ]);
        Pembayaran::create($validatedData);
        return redirect('/dashboard/pembayaran/')->with('success', 'Pembayaran Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $pembayaran = Pembayaran::where('slug', $slug)->first();
        $penyewaan = Penyewaan::find($pembayaran->penyewaan_id);
        return view('dashboard.pembayaran.show', [
            'title' => 'Info Pembayaran',
            'pembayaran' => $pembayaran,
            'penyewaan' => $penyewaan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $pembayaran = Pembayaran::where('slug', $slug)->first();
        return view('dashboard.pembayaran.edit', [
            'title' => 'Verifikasi Pembayaran',
            'pembayaran' => $pembayaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $rules = [
            'status' => 'nullable',
            'komentar' => 'nullable',
        ];

        $validatedData = $request->validate($rules);

        $penyewaan = Penyewaan::find($pembayaran->penyewaan->id);
        $kamar = Kamar::find($penyewaan->kamar->id);
        if (!$request->keterangan) {
            $keterangan = '-';
        } else {
            $keterangan = $request->keterangan;
        }

        if ($request->status == 'disetujui') {
            if ($penyewaan->status == 'menunggu') {
                $penyewaan->update([
                    'status' => 'disetujui',
                    'keterangan' => $keterangan,
                    'no_kamar' => $request->no_kamar
                ]);
                // $kamar->update(['sisa_kamar' => $kamar->sisa_kamar - 1]);
            }
            $penyewaan->update([
                ['status' => 'disetujui']
            ]);
        }


        Pembayaran::where('id', $pembayaran->id)->update($validatedData);

        return redirect('/dashboard/pembayaran/')->with('success', 'Data Pembayaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
