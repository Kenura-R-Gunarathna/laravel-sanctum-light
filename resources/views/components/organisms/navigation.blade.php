<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Forms\LogoutForm;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav>

    <ul style="display: flex; justify-content: space-between; padding: 0px;">

        @if(auth()->check())

            <li style="display: block;">{{ auth()->user()->name }}</li>
            <li style="display: block;"><a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a></li>
            <li style="display: block;"><a href="{{ route('profile') }}" wire:navigate>Profile</a></li>
            <li style="display: block;"><button wire:click="logout">Log Out</button></li>

        @else

            <li style="display: block;"><a href="{{ route('login') }}" wire:navigate>Log In</a></li>
            <li style="display: block;"><a href="{{ route('register') }}" wire:navigate>Register</a></li>

        @endif

    </ul>

</nav>
