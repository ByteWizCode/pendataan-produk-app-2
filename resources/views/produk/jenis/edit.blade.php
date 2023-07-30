@extends('layouts.app')

@section('page-title')
    Edit Jenis Produk
@endsection

@push('add-css')
@endpush

@push('add-js')
@endpush

@section('page-content')
    @include('layouts.partials.alert')
    <div class="card">
        <form action="{{ route('jenis-produk.update', $jenisProduk->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title mb-5">Form Jenis Produk</h4>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="jenis">Nama Jenis Produk</label>
                                <input type="text" name="jenis" id="jenis"
                                    class="form-control @error('jenis') is-invalid @enderror"
                                    value="{{ old('jenis') ?? $jenisProduk->jenis }}">
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    value="{{ old('deskripsi') ?? $jenisProduk->deskripsi }}">
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-3 py-3">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
