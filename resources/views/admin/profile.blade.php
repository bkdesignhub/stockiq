@extends('layouts.app')

@section('title', 'Admin Profile - StockIQ')

@section('content')
    <section class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Admin</p>
            <h1 class="page-title">Profile Security</h1>
            <p class="page-subtitle">Update admin name, mobile number, and password used to access StockIQ.</p>
        </div>
    </section>

    @if (session('status'))
        <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" class="app-panel max-w-3xl p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 lg:grid-cols-2">
            <label class="block">
                <span class="text-sm font-bold text-slate-950">Admin name</span>
                <input name="name" value="{{ old('name', $user->name) }}" class="mt-2 w-full" required>
                @error('name')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
            </label>

            <label class="block">
                <span class="text-sm font-bold text-slate-950">Mobile number</span>
                <input name="mobile" value="{{ old('mobile', $user->mobile) }}" class="mt-2 w-full" placeholder="Enter mobile number">
                @error('mobile')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
            </label>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <h2 class="font-bold text-slate-950">Change password</h2>
            <p class="mt-1 text-sm font-medium text-slate-600">Leave password fields blank if you only want to update profile details.</p>

            <div class="mt-4 grid gap-5 lg:grid-cols-3">
                <label class="block">
                    <span class="text-sm font-bold text-slate-950">Current password</span>
                    <div class="password-field mt-2 flex">
                        <input name="current_password" type="password" class="w-full rounded-r-none" autocomplete="current-password">
                        <button type="button" onclick="togglePasswordVisibility(this)" class="password-toggle grid w-12 place-items-center rounded-l-none rounded-r-xl border border-l-0 border-slate-200 bg-white text-blue-700" aria-label="Show current password">
                            <svg class="eye-icon h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5a10.75 10.75 0 0 1 9.94 6.65 1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19a10.75 10.75 0 0 1-9.94-6.65Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-off-icon hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path d="m2 2 20 20"/><path d="M6.7 6.7A10.9 10.9 0 0 0 2.06 11.65a1 1 0 0 0 0 .7A10.75 10.75 0 0 0 12 19a10.6 10.6 0 0 0 4.1-.82"/><path d="M9.9 4.24A10.7 10.7 0 0 1 12 4a10.75 10.75 0 0 1 9.94 7.65 1 1 0 0 1 0 .7 10.9 10.9 0 0 1-2.27 3.51"/><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"/></svg>
                        </button>
                    </div>
                    @error('current_password')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </label>

                <label class="block">
                    <span class="text-sm font-bold text-slate-950">New password</span>
                    <div class="password-field mt-2 flex">
                        <input name="password" type="password" class="w-full rounded-r-none" autocomplete="new-password">
                        <button type="button" onclick="togglePasswordVisibility(this)" class="password-toggle grid w-12 place-items-center rounded-l-none rounded-r-xl border border-l-0 border-slate-200 bg-white text-blue-700" aria-label="Show new password">
                            <svg class="eye-icon h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5a10.75 10.75 0 0 1 9.94 6.65 1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19a10.75 10.75 0 0 1-9.94-6.65Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-off-icon hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path d="m2 2 20 20"/><path d="M6.7 6.7A10.9 10.9 0 0 0 2.06 11.65a1 1 0 0 0 0 .7A10.75 10.75 0 0 0 12 19a10.6 10.6 0 0 0 4.1-.82"/><path d="M9.9 4.24A10.7 10.7 0 0 1 12 4a10.75 10.75 0 0 1 9.94 7.65 1 1 0 0 1 0 .7 10.9 10.9 0 0 1-2.27 3.51"/><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"/></svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>@enderror
                </label>

                <label class="block">
                    <span class="text-sm font-bold text-slate-950">Confirm password</span>
                    <div class="password-field mt-2 flex">
                        <input name="password_confirmation" type="password" class="w-full rounded-r-none" autocomplete="new-password">
                        <button type="button" onclick="togglePasswordVisibility(this)" class="password-toggle grid w-12 place-items-center rounded-l-none rounded-r-xl border border-l-0 border-slate-200 bg-white text-blue-700" aria-label="Show confirm password">
                            <svg class="eye-icon h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5a10.75 10.75 0 0 1 9.94 6.65 1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19a10.75 10.75 0 0 1-9.94-6.65Z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="eye-off-icon hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24"><path d="m2 2 20 20"/><path d="M6.7 6.7A10.9 10.9 0 0 0 2.06 11.65a1 1 0 0 0 0 .7A10.75 10.75 0 0 0 12 19a10.6 10.6 0 0 0 4.1-.82"/><path d="M9.9 4.24A10.7 10.7 0 0 1 12 4a10.75 10.75 0 0 1 9.94 7.65 1 1 0 0 1 0 .7 10.9 10.9 0 0 1-2.27 3.51"/><path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"/></svg>
                        </button>
                    </div>
                </label>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
            <button class="btn-primary">Save Profile</button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Back to Dashboard</a>
        </div>
    </form>

    <script>
        window.togglePasswordVisibility = function (button) {
            const input = button.closest('.password-field')?.querySelector('input');

            if (! input) {
                return;
            }

            const showing = input.getAttribute('type') === 'text';
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');

            input.setAttribute('type', showing ? 'password' : 'text');
            button.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
            eyeIcon.classList.toggle('hidden', ! showing);
            eyeOffIcon.classList.toggle('hidden', showing);
        };
    </script>
@endsection
