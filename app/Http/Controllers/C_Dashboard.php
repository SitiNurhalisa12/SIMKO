<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Pelaporan;
use App\Models\Penyewaan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class C_Dashboard extends Controller
{

    public function index()
    {
        return view('dashboard.v_dashboard', [
            'title' => 'Dashboard SIMKO',
            'pengajuan' => $this->pengajuan(),
            'pelaporan' => $this->pelaporan(),
            'penyewaan' => $this->penyewaan(),
            'pembayaran' => $this->pembayaran(),
            'user' => $this->user(),
            'kost' => Kost::where('status', 'disetujui')->count(),
            'kamar' => $this->kamar()
        ]);
    }

    private function user()
    {
        $user = User::all();
        return [
            'pemilik' => $user->where('status', 'pemilik')->count(),
            'penyewa' => $user->where('status', 'penyewa')->count(),
            'admin' => $user->where('status', 'admin')->count(),
            'jumlah' => $user->count(),
            'user' => User::find(auth()->user()->id)
        ];
    }

    private function kamar()
    {
        $kamar = kamar::all();
        return [
            'terisi' => $kamar->sum('jumlah_kamar') - $kamar->sum('sisa_kamar'),
            'tersedia' => $kamar->sum('sisa_kamar'),
            'jumlah' => $kamar->sum('jumlah_kamar'),
            'jenis' => $kamar->count(),
        ];
    }

    private function pengajuan()
    {
        $user = $this->user()['user'];
        $kost = Kost::all();
        $kamar = Kamar::all();

        if ($user->status == 'pemilik') {
            $kost = Kost::where('user_id', $user->id)->get();
        }

        return [
            'setuju' => $kost->where('status', 'disetujui')->count(),
            'tolak' => $kost->where('status', 'ditolak')->count(),
            'tunggu' => $kost->where('status', 'menunggu')->count(),
            'jumlah' => Kost::count(),
            'kamar' => $kamar
        ];
    }

    private function penyewaan()
    {
        $user = $this->user()['user'];
        $penyewaan = Penyewaan::all();
        if ($user->status == 'penyewa') {
            $penyewaan = Penyewaan::where('user_id', $user->id)->get();
        } elseif ($user->status == 'pemilik') {
            $jumlah = 0;
            $setuju = 0;
            $menunggu = 0;
            $tolak = 0;
            foreach ($penyewaan as $py) {
                if ($py->kamar->kost->user->id == $user->id) {
                    ++$jumlah;
                    if ($py->status == 'disetujui' || $py->status == 'lunas') {
                        ++$setuju;
                    } elseif ($py->status == 'ditolak' || $py->status == 'keluar') {
                        ++$tolak;
                    } else {
                        ++$menunggu;
                    }
                }
            }
        } else {
            $penyewaan = Penyewaan::all();
        }

        if ($user->status == 'pemilik') {
            $setuju = $setuju;
            $tolak = $tolak;
            $menunggu = $menunggu;
            $jumlah = $jumlah;
        } else {
            $setuju = $penyewaan->where('status', 'disetujui')->count() + $penyewaan->where('status', 'lunas')->count();
            $menunggu = $penyewaan->where('status', 'menunggu')->count() + $penyewaan->where('status', 'menunggak')->count();
            $tolak = $penyewaan->where('status', 'ditolak')->count() + $penyewaan->where('status', 'keluar')->count();
            $jumlah = $penyewaan->count();
        }

        return [
            'setuju' => $setuju,
            'tunggu' => $menunggu,
            'tolak' => $tolak,
            'jumlah' => $jumlah,
            'penyewaan' => $penyewaan
        ];
    }

    private function pembayaran()
    {
        $user = $this->user()['user'];
        $pembayaran = Pembayaran::all();
        if ($user->status == 'penyewa') {
            $pembayaran = Pembayaran::where('user_id', $user->id)->get();
            return [
                'setuju' => $pembayaran->where('status', 'disetujui')->count(),
                'tunggu' => $pembayaran->where('status', 'menunggu')->count(),
                'tolak' => $pembayaran->where('status', 'ditolak')->count(),
                'total' => $pembayaran->where('status', 'disetujui')->sum('total_bayar'),
                'data' => Pembayaran::where('user_id', $user->id)->where('status', 'disetujui')->orderBy('id', 'desc')->limit(7)->get(),
                'jumlah' => $pembayaran->count(),
            ];
        } elseif ($user->status == 'pemilik') {
            $jumlah = 0;
            $setuju = 0;
            $menunggu = 0;
            $tolak = 0;
            $total = 0;
            foreach ($pembayaran as $pb) {
                if ($pb->penyewaan->kamar->kost->user->id == $user->id) {
                    ++$jumlah;
                    $total += $pb->total_bayar;
                    if ($pb->status == 'disetujui') {
                        ++$setuju;
                    } elseif ($pb->status == 'ditolak') {
                        ++$tolak;
                    } else {
                        ++$menunggu;
                    }
                }
            }
            return [
                'setuju' => $setuju,
                'tunggu' => $menunggu,
                'tolak' => $tolak,
                'total' => $total,
                'data' => Pembayaran::where('status', 'disetujui')->orderBy('id', 'desc')->limit(7)->get(),
                'jumlah' => $pembayaran->count(),
            ];
        } else {
            $pembayaran = Pembayaran::all();
            return [
                'setuju' => $pembayaran->where('status', 'disetujui')->count(),
                'tunggu' => $pembayaran->where('status', 'menunggu')->count(),
                'tolak' => $pembayaran->where('status', 'ditolak')->count(),
                'total' => Pembayaran::where('status', 'disetujui')->sum('total_bayar'),
                'data' => Pembayaran::where('status', 'disetujui')->orderBy('id', 'desc')->limit(7)->get(),
                'jumlah' => $pembayaran->count(),
            ];
        }
    }

    private function pelaporan()
    {
        $user = $this->user()['user'];
        $pelaporan = Pelaporan::all();
        if ($user->status == 'penyewa') {
            $pelaporan = Pelaporan::where('user_id', $user->id);
        } elseif ($user->status == 'pemilik') {
            $jumlah = 0;
            $setuju = 0;
            $menunggu = 0;
            $tolak = 0;
            foreach ($pelaporan as $pl) {
                if ($pl->penyewaan->kamar->kost->user->id == $user->id) {
                    ++$jumlah;
                    if ($pl->status == 'disetujui') {
                        ++$setuju;
                    } elseif ($pl->status == 'ditolak') {
                        ++$tolak;
                    } else {
                        ++$menunggu;
                    }
                }
            }
        } else {
            $pelaporan = Pelaporan::all();
        }

        if ($user->status == 'pemilik') {
            return [
                'setuju' => $setuju,
                'tunggu' => $menunggu,
                'tolak' => $tolak,
                'data' => Pelaporan::orderBy('id', 'desc')->limit(7)->get(),
                'jumlah' => $pelaporan->count(),
            ];
        } else {
            return [
                'setuju' => $pelaporan->where('status', 'disetujui')->count(),
                'tunggu' => $pelaporan->where('status', 'menunggu')->count(),
                'tolak' => $pelaporan->where('status', 'ditolak')->count(),
                'data' => Pelaporan::orderBy('id', 'desc')->limit(7)->get(),
                'jumlah' => $pelaporan->count(),
            ];
        }
    }

    public function home()
    {
        return view('v_home', [
            'title' => 'SIMKO',
            'kost' => Kost::latest()->get(),
            'kamar' => Kamar::all()
        ]);
    }

    public function about()
    {
        return view('v_tentang', [
            'title' => 'Tentang SIMKO'
        ]);
    }
}
