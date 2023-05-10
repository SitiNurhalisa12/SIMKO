@extends('layouts.main')
@section('container')
   {{-- intro --}}
   <div class="row m-5">
      <h2 class="my-3">{{ $title }}</h2>
      <img src="https://source.unsplash.com/1200x500/?dorm" class="card-img-top" alt="...">
      <center>
         <div class="text-center my-5 w-50">
            <h3>Sistem Informasi Pengelolaan SIMKO</h3>
            <p>Sistem informulirasi pengelolaan SIMKO adalah sebuah sistem website yang berisi informulirasi mengenai kost Pak Usman yang berdasarkan kategori lokasinya yaitu di sekitaran kampus kota malang. Sistem ini mempunyai  fitur berupa pencarian lokasi, pengajuan, penyewaan dan pelaporan kos-kosan, dan halaman khusus untuk pemilik dan penyewa. </p>
         </div>
      </center>
   </div>
   
   {{-- tim --}}
   <div class="row" style="background-color: #eee">
      <h3 class="text-center m-5">Tim SIMKO</h3>
      <div class="col-6 mb-5">
         <center>
             <div class="w-25 mb-3">
                 <img src="https://source.unsplash.com/800x800/?female" class="card-img-top rounded-circle" alt="...">
             </div>
             <h5>Sabrina Putri Mulisa</h5>
             <span>2141764022</span>
         </center>
     </div>
     <div class="col-6 mb-5">
         <center>
             <div class="w-25 mb-3">
                 <img src="https://source.unsplash.com/100x100/?female" class="card-img-top rounded-circle" alt="...">
             </div>
             <h5>Siti Nurhalisa</h5>
             <span>2141764078</span>
         </center>
     </div>
   </div>

   {{-- kontak --}}
   <h3 class="text-center m-5">Kontak</h3>
   <div class="row d-flex justify-content-center m-5">
      <div class="col-5">
         <p>Politeknik Negeri Malang adalah perguruan tinggi vokasi yang berada di malang, jawa timur</p>
         <p><b>Alamat:</b> Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141</p>
         <p><b>Jam:</b> 07:00 - 16:00</p>
         <p><b>Telepon:</b>(0341) 404424-404425</p>
         <p><b>Didirikan:</b> 1982, Kota Malang</p>
         <p><b>Provinsi:</b> Jawa Timurt</p>
      </div>
      <div class="col-5">
         <iframe src="https://www.google.com/maps/dir/-7.9456471,112.6166553/berdiri+polinema/@-7.9462307,112.6145566,17z/data=!3m1!4b1!4m9!4m8!1m0!1m5!1m1!1s0x2e78827687d272e7:0x789ce9a636cd3aa2!2m2!1d112.6156684!2d-7.9467136!3e2"></iframe>

      </div>
   </div>

@endsection
