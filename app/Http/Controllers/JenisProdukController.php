<?php

namespace App\Http\Controllers;

use App\Models\JenisProduk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JenisProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $list_jenis_produk = JenisProduk::all();
        return view('produk.jenis.index', compact('list_jenis_produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('produk.jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'jenis' => 'required|string|unique:jenis_produk,jenis',
            'deskripsi' => 'nullable|string|max:255'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'jenis.required' => 'jenis produk tidak boleh kosong',
            'jenis.unique' => 'jenis produk yang Anda masukkan sudah tersedia',
            'max' => 'Maksimal :value karakter'
        ]);

        $create = JenisProduk::create($validate);

        if ($create) {
            return redirect(route('jenis-produk.index'))->with('success', 'Berhasil menambahkan jenis produk baru');
        }
        return back()->with('erro', 'Gagal menambahkan jenis produk baru, coba lagi dalam beberapa menit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisProduk $jenisProduk): View
    {
        return view('produk.jenis.edit', compact('jenisProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisProduk $jenisProduk): RedirectResponse
    {
        $validate = $request->validate([
            'jenis' => 'required|string',
            'deskripsi' => 'nullable|string|max:255'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'jenis.required' => 'jenis produk tidak boleh kosong',
            'max' => 'Maksimal :value karakter'
        ]);

        $update = $jenisProduk->update($validate);

        if ($update > 0) {
            return redirect(route('jenis-produk.index'))->with('success', 'Berhasil mengubah data jenis produk');
        }
        return back()->with('error', 'Gagal mengubah data jenis produk, coba lagi dalam beberapa menit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisProduk $jenisProduk): RedirectResponse
    {
        $delete = $jenisProduk->delete();

        if ($delete > 0) {
            return redirect()->back()->with('success', 'Berhasil menghapus data jenis produk');
        }
        return back()->with('error', 'Gagal menghapus data jenis produk, coba lagi dalam beberapa menit');
    }
}
