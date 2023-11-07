<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.guest')] 

class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">

        <!-- Name -->
        <div style="margin-bottom: 10px;">
            <div>Name</div>
            <input wire:model="name" type="text" name="name" required autofocus autocomplete="name">
            <div>@error("name"){{ $message }}@enderror</div>
        </div>

        <!-- Email Address -->
        <div style="margin-bottom: 10px;">
            <div>Email</div>
            <input wire:model="email" type="email" name="email" required autofocus autocomplete="username">
            <div>@error("email"){{ $message }}@enderror</div>
        </div>

        <!-- Password -->
        <div style="margin-bottom: 10px;">
            <div>Password</div>
            <input wire:model="password" type="password" name="password" required autocomplete="new-password">
            <div>@error("password"){{ $message }}@enderror</div>
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 10px;">
            <div>Confirm Password</div>
            <input wire:model="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            <div>@error("password_confirmation"){{ $message }}@enderror</div>
        </div>

        <a href="{{ route('login') }}" wire:navigate style="display: block; margin-bottom: 10px;">
            Already registered?
        </a>

        <button type="submit">Register</button>

    </form>
</div>