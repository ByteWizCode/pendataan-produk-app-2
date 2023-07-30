@extends('layouts.app')

@section('page-title')
    Profile
@endsection

@push('add-css')
@endpush

@push('add-js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(() => {
            const initFormAkun = $('#formAkun').serialize()
            $('#formAkun').submit(() => {
                const currentFormAkun = $('#formAkun').serialize()
                if (initFormAkun === currentFormAkun) {
                    return false;
                }
            })
            if ({{ Auth::user()->role == 'pelanggan' ? 1 : 0 }}) {
                const initFormDetail = $('#formDetail').serialize() + '&foto_ktp=' + encodeURIComponent($(
                        '#foto_ktp')
                    .val())
                $('#formDetail').submit(() => {
                    const currentFormDetail = $('#formDetail').serialize() + '&foto_ktp=' +
                        encodeURIComponent(
                            $('#foto_ktp').val())
                    if (initFormDetail === currentFormDetail) {
                        return false;
                    }
                })
            }
        })
    </script>
@endpush

@section('page-content')
    @include('layouts.partials.alert')
    <div class="card">
        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" id="formAkun" class="needs-validation"
            novalidate>
            @csrf
            @method('PUT')
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title mb-5">Form Akun</h4>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama User</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ Auth::user()->nama }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ Auth::user()->email }}" readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="" class="d-block">Jenis Kelamin</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="jenis_kelamin" id="jkL" class="form-check-input"
                                        value="L" @checked(Auth::user()->jenis_kelamin == 'L')>
                                    <label for="jkL">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="jenis_kelamin" id="jkP" class="form-check-input"
                                        value="P" @checked(Auth::user()->jenis_kelamin == 'P')>
                                    <label for="jkP">Perempuan</label>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Change Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password jika ingin mengubahnya">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3 py-3">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if (Auth::user()->role == 'pelanggan')
        {{-- Detail --}}
        <div class="card">
            <form action="{{ route('profile.detail.update', Auth::user()->id) }}" method="POST" id="formDetail"
                class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Form Detail</h4>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ $detail->tempat_lahir ?? old('tempat_lahir') }}">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ $detail->tanggal_lahir ?? old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" id="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ $detail->alamat ?? old('alamat') }}">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="foto_ktp">Foto KTP</label>
                                    <input type="file" name="foto_ktp" id="foto_ktp"
                                        class="form-control @error('foto_ktp') is-invalid @enderror"
                                        value="{{ $detail->foto_ktp ?? old('foto_ktp') }}">
                                    @error('foto_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if ($detail != null && $detail->foto_ktp != null)
                                <div class="col-12 col-md-2">
                                    <img src="{{ asset($detail->foto_ktp) }}" alt="foto KTP {{ Auth::user()->nama }}"
                                        class="img-fluid rounded">
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end align-items-center gap-3 py-3">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
