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

                        <div class="card-body">
                            <a class="btn btn-primary" href="{{ url('dashboard/dataatasan/create') }}">Tambah</a>
                        </div>

                        <div class="card-body" style="padding-top: 5px;padding-bottom: 5px">
                            <h5 class="card-title mb-0">Data Atasan</h5>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Masa Kerja (thn)</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach ($atasans as $atasan)
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $atasan->NIP }}</td>
                                        <td>{{ $atasan->nama }}</td>
                                        <td>{{ $atasan->jabatan }}</td>
                                        <td>{{ $atasan->masa_kerja }}</td>
                                        <td>{{ $atasan->email }}</td>
                                        <td>
                                            <div class="d-flex gap-4">
                                                <a href="{{ url('dashboard/dataatasan/' . $atasan->id . '/edit') }}"
                                                    class="btn btn-warning"
                                                    style="padding-top: 2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px;
                                                    margin-right: 5px"><i
                                                        class="far fa-edit"></i></a>

                                                <form action="{{ url('dashboard/dataatasan/' . $atasan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn btn-danger"
                                                        onclick=" return confirm('Data atasan akan dihapus')"
                                                        style="padding-top: 2px; padding-bottom: 2px; padding-left: 5px; padding-right: 5px"><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
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
