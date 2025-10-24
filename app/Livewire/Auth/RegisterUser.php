<?php

namespace App\Livewire\Auth;


use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

#[Layout('components.layouts.auth.simple')]
class RegisterUser extends Component  // Clase renombrada a RegisterUser
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // Validación de los datos del formulario
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Hashear la contraseña antes de almacenarla
        $validated['password'] = Hash::make($validated['password']);

        // Crear al nuevo usuario
        event(new Registered(($user = User::create($validated))));

        // Iniciar sesión automáticamente
        Auth::login($user);

        // Redirigir al usuario al home
        $this->redirect(route('home', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');  // Asegúrate de que la vista esté en 'resources/views/livewire/auth/register.blade.php'
    }
}
