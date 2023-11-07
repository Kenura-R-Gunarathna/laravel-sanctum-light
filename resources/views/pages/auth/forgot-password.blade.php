<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.guest')] 

class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}

?>

<div>

    <div style="margin-bottom: 10px;">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</div>

    <!-- Session Status -->
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="sendPasswordResetLink">

        <!-- Email Address -->
        <div style="margin-bottom: 10px;">
            <div>Email</div>
            <input wire:model="email" type="email" name="email" required autofocus autocomplete="username">
            <div>@error("email"){{ $message }}@enderror</div>
        </div>

        <button type="submit">Email Password Reset Link</button>

    </form>
</div>
