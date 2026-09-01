<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Acceso Administrativo | Big Apple Fast-Food')]
class LoginComponent extends Component
{
    public string $login = ''; // Username or email
    public string $password = '';
    public bool $remember = false;
    public string $errorMessage = '';

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
    }

    public function fillUser(string $username)
    {
        $this->login = $username;
        $this->password = '123';
        $this->errorMessage = '';
    }

    public function authenticate()
    {
        $this->errorMessage = '';

        $this->validate([
            'login' => 'required|min:3',
            'password' => 'required',
        ], [
            'login.required' => 'Ingresa tu usuario o correo.',
            'password.required' => 'Ingresa tu contraseña.',
        ]);

        $throttleKey = Str::transliterate(Str::lower($this->login) . '|' . request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 8)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->errorMessage = "Demasiados intentos fallidos. Espera {$seconds} segundos para reintentar.";
            return;
        }

        // Check if input is email or username
        $field = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Check credentials
        if (Auth::attempt([$field => $this->login, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // Fallback check if user entered email in username field or viceversa
        $altField = $field === 'email' ? 'username' : 'email';
        if (Auth::attempt([$altField => $this->login, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);
        $this->errorMessage = 'Usuario o contraseña incorrectos. Verifica tus datos.';
    }

    public function render()
    {
        return view('livewire.admin.login-component');
    }
}
