@extends('layouts.dashboard')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('gagal'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            {{ session('gagal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="">
        @if (auth()->user()->status == 'penyewa')
            <div class="row my-3 d-flex justify-content-between">
                <div class="col-lg-2">
                    <a class="btn btn-dark" href="/kost"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                </div>
            </div>
        @else
        @endif
        <div class="table-responsive text-center">
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color: white">#</th>
                        <th scope="col" style="color: white">Penyewa</th>
                        <th scope="col" style="color: white">Kosan</th>
                        <th scope="col" style="color: white">Kamar</th>
                        <th scope="col" style="color: white">Akhir Sewa</th>
                        <th scope="col" style="color: white">Keterangan</th>
                        <th scope="col" style="color: white">Status</th>
                        <th scope="col" style="color: white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penyewaan as $py)
                        @if (auth()->user()->status == 'admin')
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $py->user->name }}</td>
                                <td>{{ $py->kamar->kost->nama }}</td>
                                <td>{{ $py->kamar->tipe }}</td>
                                <td>{{ DateTime::createFromFormat('Y-m-d', $py->akhir_sewa)->format('d F Y') }}</td>
                                <td>
                                    @if (now()->format('Y-m-d') >= date('Y-m-d', strtotime($py->created_at . '+ 1 days')))
                                        Kadaluarsa
                                    @else
                                        {{ $py->keterangan ?? 'Jika tidak membayar selama 1 hari maka penyewaan akan otomatis terhapus' }}
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge @if ($py->status === 'disetujui') bg-success @elseif ($py->status === 'ditolak') bg-danger @elseif ($py->status == 'menunggak') bg-warning  @elseif ($py->status == 'lunas') border border-success text-black @else bg-secondary @endif">{{ $py->status }}</span>
                                </td>
                                <td>
                                    <a href="/dashboard/penyewaan/{{ $py->slug }}" class="btn btn-success"><i
                                            class="bx bx-info-circle"></i></a>
                                </td>
                            </tr>
                        @elseif ($py->kamar->kost->user->id === auth()->user()->id || $py->user->name === auth()->user()->name)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $py->user->name }}</td>
                                <td>{{ $py->kamar->kost->nama }}</td>
                                <td>{{ $py->kamar->tipe }}</td>
                                <td>{{ DateTime::createFromFormat('Y-m-d', $py->akhir_sewa)->format('d F Y') }}</td>
                                <td>
                                    @if (now()->format('Y-m-d') >= date('Y-m-d', strtotime($py->created_at . '+ 1 days')))
                                        Kadaluarsa
                                    @else
                                        {{ $py->keterangan ?? 'Jika tidak membayar selama 1 hari maka penyewaan akan otomatis terhapus' }}
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge @if ($py->status === 'disetujui') bg-success @elseif ($py->status == 'menunggu') bg-secondary @elseif ($py->status == 'menunggak') bg-warning text-black @else bg-danger @endif">{{ $py->status }}</span>
                                </td>
                                <td>
                                    <a href="/dashboard/penyewaan/{{ $py->slug }}" class="btn btn-success"><i
                                            class="bx bx-info-circle"></i></a>
                                    @if (auth()->user()->status == 'penyewa' && $py->status == 'disetujui')
                                        <a href="/dashboard/pelaporan/create/{{ $py->slug }}" class="btn btn-info"
                                            title="pelaporan"><i class="bx bx-envelope"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="d-flex justify-content-end">
            {{ $penyewaan->links() }}
        </div> --}}
    </div>
@endsection
