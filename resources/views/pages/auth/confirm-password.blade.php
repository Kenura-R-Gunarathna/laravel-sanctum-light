<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.guest')] 

class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
            navigate: true
        );
    }
} 

?>

<div>

    <div style="margin-bottom: 10px;">This is a secure area of the application. Please confirm your password before continuing.</div>

    <form wire:submit="confirmPassword">

        <!-- Password -->
        <div style="margin-bottom: 10px;">
            <div>Password</div>
            <input wire:model="password" type="password" name="password" required autocomplete="current-password">
            <div>@error("password"){{ $message }}@enderror</div>
        </div>

        <button type="submit">Confirm</button>

    </form>
</div>
