<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.guest')] 

class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
            navigate: true
        );
    }
}; ?>

<div>

    <!-- Session Status -->
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login">

        <!-- Email Address -->
        <div style="margin-bottom: 10px;">
            <div>Email</div>
            <input wire:model="form.email" type="email" name="email" required autofocus autocomplete="username">
            <div>@error("form.email"){{ $message }}@enderror</div>
        </div>

        <!-- Password -->
        <div style="margin-bottom: 10px;">
            <div>Password</div>
            <input wire:model="form.password" type="password" name="password" required autocomplete="current-password" >
            <div>@error("form.password"){{ $message }}@enderror</div>
        </div>

        <!-- Remember Me -->
        <div style="margin-bottom: 10px;">
            <label>
                <input wire:model="form.remember" type="checkbox" name="remember">
                <span>Remember me</span>
            </label>
        </div>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" wire:navigate style="display: block; margin-bottom: 10px;">
                Forgot your password?
            </a>
        @endif

        <button type="submit">Log in</button>
        
    </form>
</div>
