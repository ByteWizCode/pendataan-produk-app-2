@extends('layouts.app')

@section('page-title')
    Daftar Produk
@endsection

@push('add-css')
@endpush

@push('add-js')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(() => {
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
        });
    </script>
@endpush

@section('page-content')
    @include('layouts.partials.alert')
    <div class="row">
        @forelse ($list_produk as $produk)
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card rounded-5">
                    <div class="card-content">
                        <div class="card-body">
                            <img src="{{ asset($produk->gambar) }}" alt="foto produk" class="img-fluid rounded-4 mb-3">
                            <h4 class="card-title">{{ $produk->nama }}</h4>
                            <h6 class="card-subtitle">{{ $produk->jenis->jenis }}</h6>
                            <p class="my-3 fs-2 fw-bold text-primary"><span
                                    class="fs-5 align-top">Rp</span>{{ number_format($produk->harga_jual) }}</p>
                            <p class="d-flex align-items-top gap-2">Tersedia <i class="bi bi-stack"></i>
                                {{ number_format($produk->stok) }}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" role="button" data-bs-toggle="modal"
                            data-bs-target="#produkModal-{{ $produk->id }}" class="btn d-block btn-primary">Beli
                            Sekarang</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada produk yang tersedia</p>
        @endforelse
    </div>

    {{-- Modal --}}
    {{-- Produk Modal --}}
    @foreach ($list_produk as $produk)
        <div class="modal fade text-left" id="produkModal-{{ $produk->id }}" tabindex="-1" role="dialog"
            aria-labelledby="produkModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('pesanan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
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
                                        <p>{{ $produk->nama }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Harga</label>
                                        <p>Rp{{ number_format($produk->harga_jual) }}</p>
                                        <input type="hidden" name="harga" id="harga"
                                            value="{{ $produk->harga_jual }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                                            value="1" min="1" max="{{ $produk->stok }}">
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
                                <span class="d-none d-sm-block">Buat Pesanan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
