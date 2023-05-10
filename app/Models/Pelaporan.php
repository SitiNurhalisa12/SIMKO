<?php

namespace App\Models;

use App\Models\User;
use App\Models\Penyewaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelaporan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
