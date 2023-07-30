<?php

namespace App\Http\Controllers;

use App\Models\JenisProduk;
use App\Models\produk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $list_produk = produk::all();

        if (Auth::user()->role == 'pelanggan') {
            return view('produk.list', compact('list_produk'));
        }

        return view('produk.index', compact('list_produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $list_jenis_produk = JenisProduk::all();
        return view('produk.create', compact('list_jenis_produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jenis_produk_id' => 'required|exists:jenis_produk,id',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:1999|exclude'
        ], [
            'required' => ':attribute tidak boleh kosong!',
            'jenis_produk_id.exists' => 'jenis produk tidak ditemukan',
            'min' => ':attribute harus memiliki minimal :value',
            'gambar.image' => 'file gambar yang diperbolehkan .jpg, .jpeg, .png',
            'gambar.max' => 'file gambar maksimal 2mb',
            'gambar.dimensions' => 'file gambar harus memiliki ratio 1:1'
        ]);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');

            // Generate a unique filename for the image
            $filename = time() . '.' . $image->getClientOriginalExtension();

            if (!File::exists(public_path('storage/produk'))) {
                File::makeDirectory(public_path('storage/produk'), 0755, true);
            }

            $resizedImage = ResizeImage::class::make($image)->fit(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
            });

            $resizedImage->save(public_path('storage/produk/') . $filename);

            $validate['gambar'] = 'produk/' . $filename;
        }

        $create = produk::create($validate);
        if ($create) {
            return redirect(route('produk.index'))->with('success', 'Berhasil menambahkan data produk baru');
        }
        return back()->with('error', 'Gagal menambahkan data produk baru, coba lagi dalam beberapa saat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produk $produk): View
    {
        $list_jenis_produk = JenisProduk::all();
        return view('produk.edit', compact('produk', 'list_jenis_produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, produk $produk)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jenis_produk_id' => 'required|exists:jenis_produk,id',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:1999|exclude'
        ], [
            'required' => ':attribute tidak boleh kosong!',
            'jenis_produk_id.exists' => 'jenis produk tidak ditemukan',
            'min' => ':attribute harus memiliki minimal :value',
            'gambar.image' => 'file gambar yang diperbolehkan .jpg, .jpeg, .png',
            'gambar.max' => 'file gambar maksimal 2mb',
            'gambar.dimensions' => 'file gambar harus memiliki ratio 1:1'
        ]);

        if ($request->hasFile('gambar')) {
            $default = 'assets/images/default-product.jpg';
            if ($produk->gambar != $default) {
                $image = $request->file('gambar');
                $filename = explode('/', $produk->gambar)[2];

                $resizedImage = ResizeImage::class::make($image)->fit(1200, 1200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $resizedImage->save(public_path('storage/produk/') . $filename);
                $validate['gambar'] = 'produk/' . $filename;
            } else {
                $validate['gambar'] = $request->file('gambar')->store('produk');
            }
        }

        $update = $produk->update($validate);

        if ($update > 0) {
            return redirect(route('produk.index'))->with('success', 'Berhasil menambahkan data produk baru');
        }
        return back()->with('error', 'Gagal mengubah data produk, coba lagi dalam beberapa menit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $produk): RedirectResponse
    {
        $delete = $produk->delete();

        if ($delete > 0) {
            return redirect()->back()->with('success', 'Berhasil menghapus data produk');
        }
        return back()->with('error', 'Gagal menambahkan data produk, coba lagi dalam beberapa menit');
    }
}
