<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kamar;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kost extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        });
        $query->when($filters['jenis'] ?? false, function ($query, $jenis) {
            return $query->where(function ($query) use ($jenis) {
                $query->where('jenis', $jenis);
            });
        });

        $query->when($filters['kategori'] ?? false, function ($query, $slug) {
            return $query->whereHas('kategori', function ($query) use ($slug) {
                $query->where('slug', $slug);
            });
        });

        $query->when($filters['user'] ?? false, function ($query, $user) {
            return $query->whereHas('user', function ($query) use ($user) {
                $query->where('username', $user);
            });
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function kamar()
    {
        return $this->hasMany(Kamar::class);
    }
}
