@extends('layouts.main')

@section('container')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        @if (session()->has('success'))
                            <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                                <div class="alert alert-success alert-dismissible m-0" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <div class="card-body mb-3 mt-1" style="padding-top: 5px;padding-bottom: 5px">
                            <h5 class="card-title mb-0">Data Perseteujuan Pertama</h5>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Jenis Cuti</th>
                                    <th scope="col">Alasan Cuti</th>
                                    <th scope="col">Lama Cuti</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($persetujuanPertamas as $persetujuanPertama)
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td class="data-nip" data-nip={{ $persetujuanPertama->pengajuanCuti->NIP }}>
                                            {{ $persetujuanPertama->pengajuanCuti->NIP }}</td>
                                        <td>{{ $persetujuanPertama->pengajuanCuti->jenis_cuti }}</td>
                                        <td>{{ $persetujuanPertama->pengajuanCuti->alasan }}</td>
                                        <td>{{ $persetujuanPertama->pengajuanCuti->alamat_cuti }}</td>
                                        <td>

                                            <div class="d-flex gap-4">
                                                <a href="{{ url('dashboard/persetujuanpertama/' . $persetujuanPertama->id . '/show') }}"
                                                    class="btn btn-info"
                                                    style="padding-top: 2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px;
                                                margin-right: 5px"><i
                                                        class="fas fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
