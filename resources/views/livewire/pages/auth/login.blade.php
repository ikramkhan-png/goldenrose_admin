<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('admin.layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Redirect based on user type
        $user = Auth::user();
        
        if ($user->type === 'client') {
            // Redirect clients to client dashboard
            $this->redirect(route('client.dashboard'), navigate: false);
        } else {
            // Redirect admins/super_admins to admin dashboard
            $this->redirect(route('admin.dashboard'), navigate: false);
        }
    }
}; ?>

<div class="login-card">
    <!-- Header with Logo -->
    <div class="login-header">
        <div class="logo">
            <i class="fas fa-building"></i>
        </div>
        <h1>{{ __('Golden Rose Construction') }}</h1>
        <p>{{ __('Administration Portal') }}</p>
    </div>

    <!-- Form Body -->
    <div class="login-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="login" style="display: flex; flex-direction: column; gap: 0;">
            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input
                    wire:model="form.email"
                    id="email"
                    type="email"
                    name="email"
                    class="form-control @error('form.email') is-invalid @enderror"
                    placeholder="admin@goldenrose.com"
                    required
                    autofocus
                    autocomplete="username"
                >
                @error('form.email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input
                    wire:model="form.password"
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('form.password') is-invalid @enderror"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                @error('form.password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; cursor: pointer; font-weight: 400;">
                    <input wire:model="form.remember" type="checkbox" id="remember" name="remember"
                        style="width: 15px; height: 15px; accent-color: #4f46e5;">
                    {{ __('Remember me') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link" wire:navigate>
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-login" style="margin-top: 4px;">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                {{ __('Sign In to Dashboard') }}
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="login-footer">
        <p>
            <i class="fas fa-shield-alt me-1"></i>
            {{ __('Secure admin access only. All activities are monitored.') }}
        </p>
    </div>
</div>
