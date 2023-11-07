<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section>

    <header>
        <h3>Delete Account</h3>

        <p style="margin-bottom: 10px;">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </header>

    <button>Delete Account</button>

    <div style="background: #ffc3c3; margin: 30px; padding: 10px;">
        <form wire:submit="deleteUser">

            <h4>Are you sure you want to delete your account?</h4>

            <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

            <!-- Password -->
            <div style="margin-bottom: 10px;">
                <div>Password</div>
                <input wire:model="password" type="password" name="password" placeholder="Password">
                <div>@error("password"){{ $message }}@enderror</div>
            </div>

            <button x-on:click="$dispatch('close')">Cancel</button>

            <button class="ml-3">Delete Account</button>

        </form>
    </div>

</section>
