<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Login formunu göster
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('products.create');
        }
        return view('auth.login');
    }

    // Login işlemi
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email adresi zorunludur.',
            'email.email' => 'Geçerli bir email adresi girin.',
            'password.required' => 'Şifre zorunludur.',
        ]);

        // Remember me seçeneği
        $remember = $request->has('remember');

        // Auth kontrol et
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('products.create')->with('success', '✅ Başarıyla giriş yaptınız!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', '❌ Email veya şifre yanlış!');
    }

    // Register formunu göster
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('products.create');
        }
        return view('auth.register');
    }

    // Register işlemi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Ad Soyad zorunludur.',
            'email.required' => 'Email adresi zorunludur.',
            'email.email' => 'Geçerli bir email adresi girin.',
            'email.unique' => 'Bu email adresi zaten kullanılıyor.',
            'password.required' => 'Şifre zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
        ]);

        // Yeni kullanıcı oluştur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'admin', // İlk kullanıcı admin
        ]);

        // Otomatik giriş yap
        Auth::login($user);

        return redirect()->route('products.create')->with('success', '✅ Kayıt başarılı! Hoşgeldiniz!');
    }

    // Logout işlemi
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('products.index')->with('success', '✅ Başarıyla çıkış yaptınız.');
    }
}
