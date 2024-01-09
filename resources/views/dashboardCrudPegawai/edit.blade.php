@extends('layouts.main')

@section('container')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form class="form-horizontal" action="{{ url('datapegawai/' . $pegawai->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h4 class="card-title">Edit Data Pegawai</h4>
                                <div class="form-group row">
                                    <label for="NIP" class="col-sm-3 text-end control-label col-form-label">NIP</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('NIP') is-invalid @enderror"
                                            name="NIP" value="{{ old('NIP', $pegawai->NIP) }}" id="NIP"
                                            placeholder="Masukan NIP" />
                                        @error('NIP')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group
                                            row">
                                    <label for="nama"
                                        class="col-sm-3 text-end control-label col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            name="nama" value="{{ old('nama', $pegawai->nama) }}" id="nama"
                                            placeholder="Masukan Nama" />
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jabatan"
                                        class="col-sm-3 text-end control-label col-form-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                            name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" id="jabatan"
                                            placeholder="Masukan Jabatan" />
                                        @error('jabatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="masa_kerja" class="col-sm-3 text-end control-label col-form-label">Masa
                                        Kerja (thn)</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control @error('masa_kerja') is-invalid @enderror"
                                            name="masa_kerja" value="{{ old('masa_kerja', $pegawai->masa_kerja) }}"
                                            id="masa_kerja" placeholder="Masukan Masa Kerja" step="any" />
                                        @error('masa_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <a class="btn btn-primary" style="margin-right: 10px"
                                            href="{{ url('/datapegawai') }}">Kembali</a>
                                        <button type="submit" class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
