<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h3>Update Password</h3>

        <p style="margin-bottom: 10px;">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form wire:submit="updatePassword">
        <div style="margin-bottom: 10px;">
            <div>Current Password</div>
            <input wire:model="current_password" type="password" name="current_password" autocomplete="current-password">
            <div>@error("current_password"){{ $message }}@enderror</div>
        </div>

        <div style="margin-bottom: 10px;">
            <div>New Password</div>
            <input wire:model="password" type="password" name="password" autocomplete="new-password">
            <div>@error("password"){{ $message }}@enderror</div>
        </div>

        <div style="margin-bottom: 10px;">
            <div>Confirm Password</div>
            <input wire:model="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
            <div>@error("password_confirmation"){{ $message }}@enderror</div>
        </div>

        <button type="submit">Save</button>

        <div x-data="{ shown: false, timeout: null }"
            x-init="@this.on('password-updated', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
            x-show.transition.out.opacity.duration.1500ms="shown"
            x-transition:leave.opacity.duration.1500ms
            style="display: none;">
            Saved.
        </div>

    </form>
</section>
