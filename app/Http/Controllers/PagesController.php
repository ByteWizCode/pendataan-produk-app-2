<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function dashboard(): View
    {
        if (Auth::user()->role == 'pelanggan') {
            $pesanan_count = Pesanan::where('pelanggan_id', Auth::user()->id)->get()->count();
            return view('dashboard', compact('pesanan_count'));
        }

        $staff_count = User::where('role', 'staff')->get()->count();
        $pelanggan_count = User::where('role', 'pelanggan')->get()->count();
        $produk_count = Produk::all()->count();
        $pesanan_count = Pesanan::all()->count();

        $sales = Pesanan::where('status', 'submitted')->get()->sum('total');
        $revenue = Pesanan::where('status', 'submitted')->get()->sum('total') - Produk::all()->sum('harga_beli');

        $pesanan = Pesanan::selectRaw('DATE_FORMAT(submitted_at, "%Y-%m") as month, sum(jumlah) as jumlah')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $penjualan = Pesanan::selectRaw('jenis, DATE_FORMAT(submitted_at, "%Y-%m") as month, sum(total) as total, sum(jumlah) as jumlah')
            ->join('produk', 'produk.id', '=', 'pesanan.produk_id')
            ->join('jenis_produk', 'jenis_produk.id', '=', 'produk.jenis_produk_id')
            ->groupBy('jenis', 'month')
            ->orderBy('month')
            ->get();

        return view(
            'dashboard',
            compact(
                'staff_count',
                'pelanggan_count',
                'produk_count',
                'pesanan_count',
                'revenue',
                'sales',
                'pesanan',
                'penjualan'
            )
        );
    }
}
