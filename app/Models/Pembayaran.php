<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function jenis_bayar($id)
    {
        $penyewaan = Penyewaan::find($id);
        if ($penyewaan->status == 'menunggu') {
            return 'pelunasan';
        } else {
            return 'perpanjang';
        }
    }

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
