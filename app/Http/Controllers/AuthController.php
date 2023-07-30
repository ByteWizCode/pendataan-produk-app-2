<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(): View
    {
        return view('register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:P,L',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => 'required'
        ], [
            'required' => ':attribute tidak boleh kosong!',
            'password_confirmation.required' => 'confirm password tidak boleh kosong!',
            'email.email' => 'email yang Anda masukkan tidak valid!',
            'email.unique' => 'email yang Anda masukkan sudah terdaftar!',
            'password.confirmed' => 'password dan Confirm Password tidak sama!',
            'password' => 'passowrd minimal memiliki 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol!'
        ]);
        
        $validate['role'] = 'pelanggan';

        $create = User::create($validate);
        if ($create)
            return redirect(route('login'))->with('success', 'Anda telah terdaftar silahkan login dengan akun yang telah dibuat!');
        return back()->withInput(['nama', 'email', 'jenis_kelamin']);
    }

    public function login(): View
    {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'required' => ':attribute tidak boleh kosong!',
            'email.email' => 'email yang Anda masukkan tidak valid!'
        ]);

        if (Auth::attempt($credentials, false)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect()->intended('/admin');
                    break;
                case 'staff':
                    return redirect()->intended('/staff');
                    break;
                default:
                    return redirect()->intended('/pelanggan');
                    break;
            }
        }

        return back()->with('error', 'Email atau Password salah!')->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
