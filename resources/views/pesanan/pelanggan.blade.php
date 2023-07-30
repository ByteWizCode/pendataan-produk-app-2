@extends('layouts.app')

@section('page-title')
    Pesanan Saya
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
            $("#tablePesanan").DataTable({
                language: {
                    emptyTable: "Anda belum membuat pesanan"
                }
            });

            $('input[name="jumlah"]').each((index, element) => {
                const parent = $(element).closest('.modal-content');
                const totalDisplay = parent.find('.totalDisplay');
                const harga = parseInt(parent.find('input[name="harga"]').val());

                function hitungTotal() {
                    const jumlah = parseInt($(element).val());
                    const total = jumlah * harga;
                    totalDisplay.html(
                        `<span class="fs-5 align-top">Rp</span> ${total.toLocaleString('id-ID')}`);
                }

                $(element).on('change', hitungTotal);

                hitungTotal();
            });
        })
    </script>
@endpush

@section('page-content')
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Data Pesanan</h4>
                    <a href="{{ route('produk.list') }}" class="btn btn-outline-primary icon">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>

                @include('layouts.partials.alert')

                <div class="responsive-table mt-5">
                    <table class="table table-borderless table-hover" id="tablePesanan">
                        <thead>
                            <tr>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_pesanan as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->produk->nama }}</td>
                                    <td>{{ $pesanan->harga }}</td>
                                    <td>{{ $pesanan->jumlah }}</td>
                                    <td>{{ $pesanan->total }}</td>
                                    <td>{{ $pesanan->status }}</td>
                                    <td>
                                        @if ($pesanan->status == 'pending')
                                            <div class="d-flex gap-2">
                                                <a href="#" role="button" class="btn icon btn-sm btn-outline-warning"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#produkModal-{{ $pesanan->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="#" role="button" class="btn icon btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#cancelStatusModal-{{ $pesanan->id }}">
                                                    <i class="bi bi-dash-lg"></i>
                                                </a>
                                            </div>
                                        @endif
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
    {{-- Produk Modal --}}
    @foreach ($list_pesanan as $pesanan)
        <div class="modal fade text-left" id="produkModal-{{ $pesanan->id }}" tabindex="-1" role="dialog"
            aria-labelledby="produkModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="produkModal">Pesan Produk</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Nama Produk</label>
                                        <p>{{ $pesanan->produk->nama }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Harga</label>
                                        <p>Rp{{ number_format($pesanan->produk->harga_jual) }}</p>
                                        <input type="hidden" name="harga" id="harga"
                                            value="{{ $pesanan->produk->harga_jual }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                                            value="{{ $pesanan->jumlah }}" min="1" max="{{ $pesanan->stok }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Total</label>
                                        <p class="totalDisplay" class="fs-1 fw-bold text-primary">
                                            <span class="fs-5 align-top">Rp</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    {{-- Cancel Status Pesanan Modal --}}
    @foreach ($list_pesanan as $pesanan)
        <div class="modal fade text-left" id="cancelStatusModal-{{ $pesanan->id }}" tabindex="-1" role="dialog"
            aria-labelledby="cancelStatusModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelStatusModal">Konfirmasi</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda ingin membatalkan data pesanan: <b>{{ $pesanan->produk->nama }}</b> -
                        Rp{{ number_format($pesanan->total) }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tidak</span>
                        </button>
                        <form
                            action="{{ route('pesanan.update.status', ['pesanan' => $pesanan->id, 'status' => 'cancel']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya, Batalkan</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
