@extends('layouts.app')

@section('page-title')
    Tambah User
@endsection

@push('add-css')
@endpush

@push('add-js')
@endpush

@section('page-content')
    @include('layouts.partials.alert')
    <div class="card">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title mb-5">Form User</h4>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama User</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
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
                                        value="L" checked>
                                    <label for="jkL">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="jenis_kelamin" id="jkP" class="form-check-input"
                                        value="P">
                                    <label for="jkP">Perempuan</label>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role"
                                    class="form-select @error('role') is-invalid @enderror">
                                    <option disabled selected>----- Pilih Role -----</option>
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    <option value="pelanggan">Pelanggan</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Default Password</label>
                                <p>Password123!</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3 py-3">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah User</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
