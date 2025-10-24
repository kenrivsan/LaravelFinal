<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function create()
    {
        // Si no usas vista clásica, este método puede quedar sin usarse.
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','lowercase','email','max:255','unique:users,email'],
            'password' => ['required','confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => Str::lower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}