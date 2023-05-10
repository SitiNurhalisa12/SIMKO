<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Kategori;
use Illuminate\Http\Request;

class C_Kosan extends Controller
{
    public function index()
    {
        $title = 'Kos-kosan';

        if (request('kategori')) {
            $kategori = Kategori::firstWhere('slug', request('kategori'));
            $title = 'Kosan sekitar ' . $kategori->nama;
        }

        if (request('user')) {
            $user =  User::firstWhere('username', request('user'));
            $title = 'Juragan ' . $user->name;
        }
        if (request('jenis')) {
            $title = 'Kosan Jenis ' . request('jenis');
        }

        if (request('search')) {
            $title = 'Mencari ' . request('search');
        }

        // $kost = Kost::where('slug', $slug)->first();
        // $kamar = Kamar::where('kost_id', $kost->id)->first();
        // $jumlah = Kamar::find($kamar->id)->sum('jumlah_kamar');
        // $harga_min = Kamar::find($kamar->id)->min('harga');
        // $harga_max = Kamar::find($kamar->id)->max('harga');


        $kamar = Kamar::all();
        return view('v_kost', [
            'title' => $title,
            'kost' => Kost::latest()->filter(request(['search', 'kategori', 'user', 'jenis']))->get(),
            'kamar' => $kamar,
        ]);
    }
}
