@extends('layouts.app')

@section('page-title')
    Daftar Pesanan
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
                    emptyTable: "Data pesanan belum tersedia"
                }
            });

            document.getElementById('status').addEventListener('change', function() {
                window.location.href = this.value;
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

                    <select name="status" id="status" class="form-select w-auto">
                        <option value="{{ route('pesanan.index') }}" {{ $status == null ? 'selected' : '' }}>
                            Semua
                        </option>
                        @foreach (['pending', 'submitted', 'cancel'] as $item)
                            <option value="{{ route('pesanan.index', ['status' => $item]) }}"
                                {{ $status == $item ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @include('layouts.partials.alert')

                <div class="responsive-table mt-5">
                    <table class="table table-borderless table-hover" id="tablePesanan">
                        <thead>
                            <tr>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Keuntungan</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_pesanan as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->pelanggan->nama }}</td>
                                    <td>{{ $pesanan->produk->nama }}</td>
                                    <td>{{ $pesanan->harga }}</td>
                                    <td>
                                        {{ $pesanan->jumlah }}{{ $pesanan->status == 'pending' ? '/' . $pesanan->produk->stok : '' }}
                                    </td>
                                    <td>{{ $pesanan->total }}</td>
                                    <td>{{ $pesanan->keuntungan }}</td>
                                    <td>
                                        @if ($pesanan->status == 'submitted')
                                            <span class="badge w-100 bg-success">Submitted</span>
                                        @elseif ($pesanan->status == 'cancel')
                                            <span class="badge w-100 bg-danger">Cancel</span>
                                        @else
                                            <span class="badge w-100 bg-warning">Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($pesanan->status == 'pending')
                                            <div class="d-flex gap-2">
                                                <a href="#" role="button" class="btn icon btn-sm btn-outline-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#approveStatusModal-{{ $pesanan->id }}">
                                                    <i class="bi bi-check-lg"></i>
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
    {{-- Approve Status Pesanan Modal --}}
    @foreach ($list_pesanan as $pesanan)
        <div class="modal fade text-left" id="approveStatusModal-{{ $pesanan->id }}" tabindex="-1" role="dialog"
            aria-labelledby="approveStatusModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveStatusModal">Konfirmasi</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda ingin menyetujui data pesanan: <b>{{ $pesanan->produk->nama }}</b> -
                        Rp{{ number_format($pesanan->total) }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tidak</span>
                        </button>
                        <form
                            action="{{ route('pesanan.update.status', ['pesanan' => $pesanan->id, 'status' => 'submitted']) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya, Setujui</span>
                            </button>
                        </form>
                    </div>
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
