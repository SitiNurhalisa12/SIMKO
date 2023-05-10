<?php

namespace App\Models;

use App\Models\Kost;
use App\Models\User;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyewaan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function durasi($awal, $akhir)
    {
        $start = strtotime($awal);
        $end = strtotime($akhir);

        $tahun_awal = date('Y', $start);
        $tahun_akhir = date('Y', $end);

        $bulan_awal = date('m', $start);
        $bulan_akhir = date('m', $end);

        $tanggal_awal = date('d', $start);
        $tanggal_akhir = date('d', $end);

        $durasi = (($tahun_akhir - $tahun_awal) * 12) + ($bulan_akhir - $bulan_awal);

        if ($tanggal_akhir >= $tanggal_awal) {
            ++$durasi;
        }

        return $durasi;
    }

    public static function bayar($durasi, $harga)
    {
        $bayar = $durasi * $harga;
        return $bayar;
    }

    public static function bayar_denda($akhir, $sekarang, $penyewaan)
    {
        $penyewaan = Penyewaan::find($penyewaan);
        $batas = date('Y-m-d', strtotime($akhir . '+ 6 days'));
        $denda_kamar = $penyewaan->kamar->denda;
        if ($sekarang > $batas) {
            if ($penyewaan->status != 'keluar') {
                DB::table('penyewaans')->where('id', $penyewaan->id)->update([
                    'status' => 'menunggak',
                    'keterangan' => 'Segera perpanjang atau penyewaan akan dihapus dalam waktu 1 minggu'
                ]);
            }
            $denda = $denda_kamar;
        } else {
            $denda = 0;
        }
        return $denda;
    }

    public static function status_sewa($status, $id)
    {
        $penyewaan = Penyewaan::find($id);
        $pembayaran = Pembayaran::where('penyewaan_id', $id)->orderBy('id', 'desc')->first();
        $pemilik = User::find($penyewaan->kamar->kost->user->id);
        $durasi = Penyewaan::durasi($penyewaan->awal_sewa, $penyewaan->akhir_sewa);
        $bayar = Penyewaan::bayar($durasi, $penyewaan->kamar->harga);

        $sekarang = now()->format('Y-m-d');
        $tidak_bayar = date('Y-m-d', strtotime($penyewaan->created_at . '+ 1 days'));
        $akhir_sewa = $penyewaan->akhir_sewa;

        $denda = Penyewaan::bayar_denda($akhir_sewa, $sekarang, $id);

        if ($status == 'menunggu') {
            // status menunggu atau menolak
            if ($sekarang >= $tidak_bayar) {
                Kamar::find($penyewaan->kamar_id)->update(['sisa_kamar' => $penyewaan->kamar->sisa_kamar + 1]);
                Penyewaan::destroy($penyewaan->id);
                return back()->with('gagal', 'Penyewaan telah dihapus otomatis karena tidak melakukan pembayaran dalam waktu 1 hari');
            }
            return view('dashboard.penyewaan.show', [
                'title' => 'Info Penyewaan',
                'penyewaan' => $penyewaan,
                'pembayaran' => $pembayaran,
                'durasi' => $durasi,
                'bayar' => $bayar,
                'denda' => 0,
                'pemilik' => $pemilik
            ]);
        } elseif ($status == 'menunggak') {
            if ($sekarang >= $akhir_sewa) {
                Kamar::find($penyewaan->kamar_id)->update(['sisa_kamar' => $penyewaan->kamar->sisa_kamar + 1]);
                Penyewaan::find($penyewaan->id)->update(['status' => 'keluar', 'keterangan' => 'Anda telah dikeluarkan. Silahkan lakukan pesanan lagi']);
            }
            return view('dashboard.penyewaan.show', [
                'title' => 'Info Penyewaan',
                'penyewaan' => $penyewaan,
                'pembayaran' => $pembayaran,
                'durasi' => 0,
                'bayar' => 0,
                'denda' => $denda,
                'pemilik' => $pemilik
            ]);
        } else {
            return view('dashboard.penyewaan.show', [
                'title' => 'Info Penyewaan',
                'penyewaan' => $penyewaan,
                'pembayaran' => $pembayaran,
                'durasi' => $durasi,
                'bayar' => 0,
                'denda' => $denda,
                'pemilik' => $pemilik
            ]);
        }
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelaporan()
    {
        return $this->hasMany(Pelaporan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
