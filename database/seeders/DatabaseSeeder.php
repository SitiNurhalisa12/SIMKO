<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'status' => 'admin',
            'email' => 'admin@gmail.com',
            'nohp' => '62846759232',
            'atas_nama' => 'admin admin',
            'jenis_rek' => 'bri',
            'norek' => '0112371122',
            'alamat' => 'cibogo',
            'password' => bcrypt('admin'),
        ]);

        User::create([
            'name' => 'Aida Diana',
            'username' => 'Aida_123',
            'status' => 'penyewa',
            'email' => 'aida@gmail.com',
            'nohp' => '6282244556635',
            'atas_nama' => 'AIDA MILLATI MARDIANA',
            'jenis_rek' => 'BNI',
            'norek' => '0987863563248',
            'alamat' => 'Jember',
            'password' => bcrypt('aida12345'),
        ]);

        User::create([
            'name' => 'Usman',
            'username' => 'Usman',
            'status' => 'pemilik',
            'email' => 'usman@gmail.com',
            'nohp' => '85204951537',
            'atas_nama' => 'ROSSANAH',
            'jenis_rek' => 'BRI',
            'norek' => '057901000557563',
            'alamat' => 'Semanggi Barat 29A',
            'password' => bcrypt('usman'),
        ]);

        Kategori::create([
            'nama' => 'Politeknik Negeri Malang',
            'slug' => 'Politeknik Negeri Malang',
            'alamat' => 'Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141'
        ]);

        Kategori::create([
            'nama' => 'Universitas Brawijaya',
            'slug' => 'Universitas Brawijaya',
            'alamat' => 'Jl. Veteran, Ketawanggede, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145'
        ]);

        Kategori::create([
            'nama' => 'Universitas Malang',
            'slug' => 'Universitas Malang',
            'alamat' => 'Jl. Semarang No.5, Sumbersari, Kec. Lowokwaru, Kota Malang, Jawa Timur 65145'
        ]);
    }
}
