<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $path = session('url.intended', RouteServiceProvider::HOME);

            $this->redirect($path);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h3>Profile Information</h3>

        <p style="margin-bottom: 10px;">Update your account's profile information and email address.</p>
    </header>

    <form wire:submit="updateProfileInformation">

        <div style="margin-bottom: 10px;">
            <div>Name</div>
            <input wire:model="name" type="text" name="name" autofocus autocomplete="name">
            <div>@error("name"){{ $message }}@enderror</div>
        </div>

        <div style="margin-bottom: 10px;">
            <div>Email</div>
            <input wire:model="email" type="email" name="email" autofocus autocomplete="username">
            <div>@error("email"){{ $message }}@enderror</div>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p>
                        Your email address is unverified.

                        <button wire:click.prevent="sendVerification">Click here to re-send the verification email.</button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p>A new verification link has been sent to your email address.</p>
                    @endif
                </div>
            @endif
        </div>

        <button type="submit">Save</button>

        <div x-data="{ shown: false, timeout: null }"
            x-init="@this.on('profile-updated', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
            x-show.transition.out.opacity.duration.1500ms="shown"
            x-transition:leave.opacity.duration.1500ms
            style="display: none;">
            Saved.
        </div>

    </form>
</section>
