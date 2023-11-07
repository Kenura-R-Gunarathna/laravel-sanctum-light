<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new 
#[Layout('layouts.guest')] 

class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <form wire:submit="resetPassword">

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

        <button type="submit">Reset Password</button>

    </form>
</div>
