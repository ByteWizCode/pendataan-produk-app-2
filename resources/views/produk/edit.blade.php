@extends('layouts.app')

@section('page-title')
    Edit Produk
@endsection

@push('add-css')
@endpush

@push('add-js')
@endpush

@section('page-content')
    @include('layouts.partials.alert')
    <div class="card">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" class="needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title mb-5">Form Produk</h4>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="nama">Nama Produk</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama') ?? $produk->nama }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" id="deskripsi"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    value="{{ old('deskripsi') ?? $produk->deskripsi }}">
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="jenis_produk_id">Jenis Produk</label>
                                <select name="jenis_produk_id" id="jenis_produk_id"
                                    class="form-select @error('deskripsi') is-invalid @enderror">
                                    <option disabled>----- Pilih Jenis Produk -----</option>
                                    @foreach ($list_jenis_produk as $jenisProduk)
                                        <option value="{{ $jenisProduk->id }}" @selected($jenisProduk->id == $produk->jenis_produk_id)>
                                            {{ $jenisProduk->jenis }} - {{ $jenisProduk->deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_produk_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" id="stok"
                                    class="form-control @error('stok') is-invalid @enderror"
                                    value="{{ old('stok') ?? $produk->stok }}">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_beli" id="harga_beli"
                                        class="form-control @error('harga_beli') is-invalid @enderror"
                                        value="{{ old('harga_beli') ?? $produk->harga_beli }}">
                                </div>
                                @error('harga_beli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_jual" id="harga_jual"
                                        class="form-control @error('harga_jual') is-invalid @enderror"
                                        value="{{ old('harga_jual') ?? $produk->harga_jual }}">
                                </div>
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}" class="img-fluid rounded">
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="gambar">Change Gambar</label>
                                <input type="file" name="gambar" id="gambar"
                                    class="form-control @error('gambar') is-invalid @enderror"
                                    value="{{ old('gambar') ?? $produk->nama }}">
                                @error('gambar')
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
