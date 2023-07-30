@extends('layouts.app')

@section('page-title')
    Daftar Produk
@endsection

@push('add-css')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
@endpush

@push('add-js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script>
        $(document).ready(() => {
            $("#tableProduk").DataTable({
                language: {
                    emptyTable: "Data produk belum tersedia"
                }
            });
        })
    </script>
@endpush

@section('page-content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Data Produk</h4>
                    <a href="{{ route('produk.create') }}" class="btn btn-outline-primary icon"><i
                            class="bi bi-plus-lg"></i></a>
                </div>

                @include('layouts.partials.alert')

                <div class="responsive-table mt-5">
                    <table class="table table-borderless table-hover" id="tableProduk">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Jenis Produk</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Harga Jual</th>
                                <th scope="col" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_produk as $produk)
                                <tr>
                                    <td>{{ $produk->nama }}</td>
                                    <td>{{ $produk->deskripsi }}</td>
                                    <td>{{ $produk->jenis->jenis }}</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>{{ $produk->harga_jual }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('produk.edit', $produk->id) }}"
                                                class="btn icon btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="#" role="button" class="btn icon btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteProdukModal-{{ $produk->id }}">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    {{-- Delete User Modal --}}
    @foreach ($list_produk as $produk)
        <div class="modal fade text-left" id="deleteProdukModal-{{ $produk->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteProdukModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProdukModal">Konfirmasi</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda ingin menghapus data produk: <b>{{ $produk->nama }}</b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tidak</span>
                        </button>
                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya, Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
