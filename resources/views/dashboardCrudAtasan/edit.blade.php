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

                        <form class="form-horizontal" action="{{ url('dashboard/dataatasan/' . $atasan->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Data atasan</h4>
                                <div class="form-group row">
                                    <label for="NIP" class="col-sm-3 text-end control-label col-form-label">NIP</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('NIP') is-invalid @enderror"
                                            name="NIP" value="{{ old('NIP', $atasan->NIP) }}" id="NIP"
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
                                            name="nama" value="{{ old('nama', $atasan->nama) }}" id="nama"
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
                                            name="jabatan" value="{{ old('jabatan', $atasan->jabatan) }}" id="jabatan"
                                            placeholder="Masukan Jabatan" />
                                        @error('jabatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="kelompok"
                                        class="col-sm-3 text-end control-label col-form-label">Kelompok</label>
                                    <div class="col-sm-9">

                                        <select class="shadow-none @error('nama_kelompok') is-invalid @enderror"
                                            style="width: 100%; height: 36px" name="nama_kelompok" required>
                                            {{-- <option value="">Pilih</option> --}}
                                            @foreach ($kelompoks as $kelompok)
                                                @if ($kelompok->nama_kelompok == $atasan->nama_kelompok)
                                                    <option value="{{ $kelompok->nama_kelompok }}" selected>
                                                        {{ $kelompok->nama_kelompok }}</option>
                                                @else
                                                    <option value="{{ $kelompok->nama_kelompok }}">
                                                        {{ $kelompok->nama_kelompok }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('nama_kelompok')
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
                                            name="masa_kerja" value="{{ old('masa_kerja', $atasan->masa_kerja) }}"
                                            id="masa_kerja" placeholder="Masukan Masa Kerja" step="any" />
                                        @error('masa_kerja')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="golongan"
                                        class="col-sm-3 text-end control-label col-form-label">Golongan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('golongan') is-invalid @enderror"
                                            name="golongan" value="{{ old('golongan', $atasan->golongan) }}" id="golongan"
                                            placeholder="Golongan" />
                                        @error('golongan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-sm-3 text-end control-label col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email', $atasan->email) }}" id="email"
                                            placeholder="Masukan email" step="any" />
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-sm-3 text-end control-label col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                                            name="password" value="{{ old('password') }}" id="password"
                                            placeholder="Masukan password" step="any" />
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="file"
                                        class="col-sm-3 text-end control-label col-form-label">File</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control @error('file') is-invalid @enderror"
                                            name="ttd" value="{{ old('file') }}" id="file"
                                            placeholder="File" accept="image/png, image/jpeg" />
                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="border-top">
                                    <div class="card-body">
                                        <a class="btn btn-primary" style="margin-right: 10px"
                                            href="{{ url('dashboard/dataatasan') }}">Kembali</a>
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
