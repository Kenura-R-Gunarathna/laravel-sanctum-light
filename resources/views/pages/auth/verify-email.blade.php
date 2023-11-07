<?php

use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.guest')] 

class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirect(
                session('url.intended', RouteServiceProvider::HOME),
                navigate: true
            );

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>

    <div style="margin-bottom: 10px;">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.</div>

    <!-- Session Status -->
    @if (session('status') == 'verification-link-sent')
        <div style="margin-bottom: 10px;">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <button type="button" wire:click="sendVerification">Resend Verification Email</button>

    <button type="button" wire:click="logout">Log Out</button>

</div>
