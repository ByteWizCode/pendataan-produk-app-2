<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (Auth::user() && Auth::user()->role == 'pelanggan') {
            $list_pesanan = Pesanan::where('pelanggan_id', Auth::user()->id)->latest()->get();
            return view('pesanan.pelanggan', compact('list_pesanan'));
        }


        // get query string for status
        $status = request()->query('status');

        $list_pesanan = Pesanan::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->with('produk')->latest()->get();

        $list_pesanan->map(function ($pesanan) {
            $pesanan->keuntungan = ($pesanan->produk->harga_jual - $pesanan->produk->harga_beli) * $pesanan->jumlah;
            return $pesanan;
        });

        return view('pesanan.index', compact('list_pesanan', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'harga' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        $validate['pelanggan_id'] = Auth::user()->id;
        $validate['total'] = $validate['jumlah'] * $validate['harga'];

        $create = Pesanan::create($validate);

        if ($create) {
            return redirect(route('pesanan.index'))->with('success', 'Berhasil membuat pesanan');
        }
        return back()->with('error', 'Gagal membuat pesanan, coba lagi dalam beberapa menit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $validate = $request->validate([
            'harga' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);
        $validate['total'] = $validate['jumlah'] * $validate['harga'];

        $update = $pesanan->update($validate);

        if ($update > 0) {
            return redirect(route('pesanan.index'))->with('success', 'Berhasil mengubah pesanan');
        }
        return back()->with('error', 'Gagal mengubah pesanan, coba lagi dalam beberapa menit');
    }

    public function updateStatus(Pesanan $pesanan, $status): RedirectResponse
    {
        if ($status == 'submitted') {
            $produk = Produk::find($pesanan->produk_id);
            $currentStok = $produk->stok - $pesanan->jumlah;
            if ($currentStok < 0) {
                return back()->with('error', 'Stok produk tidak mencukupi, silahkan cek ketersediaan stok terlebih dahulu');
            }
            $produk->update(['stok' => $currentStok]);
        }

        $update = $pesanan->update(['status' => $status]);
        if ($update > 0) {
            return redirect()->back()->with('success', 'Berhasil mengubah status pesanan');
        }
        return back()->with('error', 'Gagal mengubah status pesanan, coba lagi dalam beberapa menit');
    }
}
