<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $role = $request->role ?? 'pelanggan';

        $users = User::where('role', $role)->get();
        return view('users.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:P,L',
            'role' => 'required|in:admin,staff,pelanggan'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email.email' => 'email yang Anda masukkan tidak valid',
            'email.unique' => 'email yang Anda masukkan sudah terdaftar',
            'in' => ':attribute harus memiliki nilai :values',
            'jenis_kelamin.in' => 'jenis kelamin harus bernilai Laki-Laki atau Perempuan',
        ]);
        $validate['password'] = Hash::make('Password123!');

        $create = User::create($validate);

        if ($create) {
            $role = $request->role == 'pelanggan' ? 'pelanggan' : 'staff';
            return redirect(route('users.index', ['role' => $role]))->with('success', "Berhasil menambahkan data {$request->role} baru");
        }
        return back()->with('error', 'Gagal menambahkan data user baru, coba lagi dalam beberapa menit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'exclude'],
            'jenis_kelamin' => 'required|in:P,L',
            'role' => 'required|in:admin,staff,pelanggan'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email.email' => 'email yang Anda masukkan tidak valid',
            'in' => ':attribute harus memiliki nilai :values',
            'jenis_kelamin.in' => 'jenis kelamin harus bernilai Laki-Laki atau Perempuan',
            'password.*' => 'passowrd minimal memiliki 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol!'
        ]);

        if ($request->password != '') {
            $validate['password'] = Hash::make($request->password);
        }

        $update = $user->update($validate);

        if ($update > 0) {
            $role = $request->role == 'pelanggan' ? 'pelanggan' : 'staff';
            return redirect(route('users.index', ['role' => $role]))->with('success', 'Berhasil mengubah data user');
        }
        return back()->with('error', 'Gagal mengubah data user baru, coba lagi dalam beberapa menit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {

        $delete = $user->delete();

        if ($delete > 0) {
            return redirect()->back()->with('success', 'Berhasil menghapus data user');
        }
        return redirect()->back()->with('error', 'Gagal menghapus data user, coba lagi dalam beberapa menit');
    }

    public function myProfile(): View
    {
        $detail = Pelanggan::where('user_id', Auth::user()->id)->first();
        return view('users.profile', compact('detail'));
    }

    public function updateProfile(Request $request, User $user): RedirectResponse
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'exclude'],
            'jenis_kelamin' => 'required|in:P,L',
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email.email' => 'email yang Anda masukkan tidak valid',
            'jenis_kelamin.in' => 'jenis kelamin harus bernilai Laki-Laki atau Perempuan',
            'password.*' => 'passowrd minimal memiliki 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol!'
        ]);

        if ($request->password != '') {
            $validate['password'] = Hash::make($request->password);
        }

        $update = $user->update($validate);

        if ($update > 0) {
            return redirect()->back()->with('success', 'Berhasil menyimpan perubahan profile');
        }
        return back()->with('error', 'Gagal menyimpan perubahan profile, coba lagi dalam beberapa menit');
    }

    public function updateProfileDetail(Request $request, $id)
    {
        $validate = $request->validate([
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'foto_ktp' => 'nullable|image|max:1999|exclude'
        ], [
            'required' => ':attribute tidak boleh kosong',
            'email.email' => 'email yang Anda masukkan tidak valid',
            'foto_ktp.image' => 'file foto ktp yang diperbolehkan .jpg, .jpeg, .png',
            'foto_ktp.max' => 'file foto ktp maksimal 2mb',
        ]);

        if ($request->foto_ktp != '') {
            $validate['foto_ktp'] = $request->file('foto_ktp')->storeAs('foto-ktp', "pelanggan-{$id}.png");
        }

        $pelanggan = Pelanggan::updateOrInsert(['user_id' => $id], $validate);

        if ($pelanggan) {
            return redirect()->back()->with('success', 'Berhasil menyimpan perubahan profile');
        }
        return back()->with('error', 'Gagal menyimpan perubahan profile, coba lagi dalam beberapa menit');
    }
}
