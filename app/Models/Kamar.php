<?php

namespace App\Models;

use App\Models\Kost;
use App\Models\Penyewaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class);
    }
}
