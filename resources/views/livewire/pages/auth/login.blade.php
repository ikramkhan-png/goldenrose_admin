<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
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

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="login-card">
    <!-- Header with Logo -->
    <div class="login-header">
        <div class="logo">
            <i class="fas fa-building"></i>
        </div>
        <h1>Golden Rose Construction</h1>
        <p>Administration Portal</p>
    </div>

    <!-- Form Body -->
    <div class="login-body">
        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
        
        <!-- Info Messages -->
        @if (session('info'))
            <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        <form wire:submit="login">
            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i> Email Address
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-at"></i>
                    </span>
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
                </div>
                @error('form.email')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i> Password
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-key"></i>
                    </span>
                    <input 
                        wire:model="form.password" 
                        id="password" 
                        type="password" 
                        name="password" 
                        class="form-control @error('form.password') is-invalid @enderror" 
                        placeholder="Enter your password"
                        required 
                        autocomplete="current-password"
                    >
                </div>
                @error('form.password')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input 
                        wire:model="form.remember" 
                        class="form-check-input" 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                    >
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link" wire:navigate>
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>
                Sign In to Dashboard
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="login-footer">
        <p>
            <i class="fas fa-shield-alt me-1"></i>
            Secure admin access only. All activities are monitored.
        </p>
    </div>
</div>
