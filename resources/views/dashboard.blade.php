@extends('layouts.app')

@section('page-title')
    Dashboard
@endsection

@section('page-content')
    @switch(Auth::user()->role)
        @case('admin')
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Staff</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($staff_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Pelanggan</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($pelanggan_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi bi-handbag-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Produk</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($produk_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Pemasukan</h6>
                                    <h6 class="font-extrabold mb-0">Rp {{ number_format($revenue) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pemasukan</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="line"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @break

        @case('staff')
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Pelanggan</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($pelanggan_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi bi-handbag-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Produk</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($produk_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="bi bi-basket3-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Pesanan</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($pesanan_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Pemasukan</h6>
                                    <h6 class="font-extrabold mb-0">Rp {{ number_format($revenue) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pemasukan</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="line"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @break

        @default
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="bi bi-basket3-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-7">
                                    <h6 class="text-muted font-semibold">Pesanan</h6>
                                    <h6 class="font-extrabold mb-0">{{ number_format($pesanan_count) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endswitch
@endsection

@push('add-js')
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
        <script src="{{ asset('assets\extensions\chart.js\Chart.min.js') }}"></script>

        <script>
            const ctxBar = document.getElementById("bar").getContext("2d");
            const ctxLine = document.getElementById("line").getContext("2d");

            const lineColors = [
                '#57cae9',
                '#5dda9c',
                '#ff7976',
            ]

            const myBar = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($pesanan).map((item) => {
                        const date = new Date(item['month'] + '-01');
                        const month = date.toLocaleString('id-ID', {
                            month: 'long',
                            year: 'numeric'
                        });
                        return month;
                    }),
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        backgroundColor: '#435ebe',
                        data: @json($pesanan).map((item) => {
                            return item['jumlah']
                        }),
                    }]
                },
                options: {
                    responsive: true,
                    barRoundness: 1,
                    title: {
                        display: true,
                        text: "Jumlah Pesanan berdasarkan Bulan"
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 40 + 20,
                                padding: 10,
                            },
                            gridLines: {
                                drawBorder: false,
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false
                            }
                        }]
                    }
                }
            });

            const myline = new Chart(ctxLine, {
                type: 'bar',
                data: {
                    labels: @json($penjualan).reduce((acc, item) => {
                        const date = new Date(item['month'] + '-01');
                        const month = date.toLocaleString('id-ID', {
                            month: 'long',
                            year: 'numeric'
                        });

                        const index = acc.findIndex((el) => el === month);
                        if (index === -1) {
                            acc.push(month);
                        }
                        return acc;
                    }, []),
                    datasets: @json($penjualan).reduce((acc, item) => {
                        const index = acc.findIndex((el) => el.label === item.jenis);
                        if (index === -1) {
                            acc.push({
                                label: item.jenis,
                                backgroundColor: lineColors[acc.length],
                                data: [item.total],
                                fill: true,
                            });
                        } else {
                            acc[index].data.push(item.total);
                        }
                        return acc;
                    }, [])
                },
                options: {
                    responsive: true,
                    layout: {
                        padding: {
                            top: 10,
                        },
                    },
                    tooltips: {
                        intersect: false,
                        titleFontFamily: 'Helvetica',
                        titleMarginBottom: 10,
                        xPadding: 10,
                        yPadding: 10,
                        cornerRadius: 3,
                    },
                    legend: {
                        display: true,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                drawBorder: true,
                            },
                            ticks: {
                                display: true,
                            },
                        }, ],
                        xAxes: [{
                            gridLines: {
                                drawBorder: true,
                                display: true,
                            },
                            ticks: {
                                display: true,
                            },
                        }, ],
                    },
                }
            });
        </script>
    @endif
@endpush
