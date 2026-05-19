<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - StockIQ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-600">
    <main class="grid min-h-screen place-items-center px-4 py-10">
        <section class="w-full max-w-md">
            <div class="mb-7 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-blue-50 text-blue-600 shadow-sm">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                </div>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-950">Stock<span class="text-emerald-500">IQ</span></h1>
                <p class="mt-2 text-sm font-medium text-slate-600">Secure admin login for inventory, purchases, vendors, and reports.</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="app-panel p-6">
                @csrf

                <div>
                    <label class="text-sm font-bold text-slate-950" for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="mt-2 w-full" autocomplete="email" autofocus required>
                    @error('email')
                        <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="text-sm font-bold text-slate-950" for="password">Password</label>
                    <input id="password" name="password" type="password" class="mt-2 w-full" autocomplete="current-password" required>
                    @error('password')
                        <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm">
                            <p class="font-extrabold text-slate-950">Demo Login</p>
                            <p class="mt-1 font-semibold text-slate-600">User: bharath@nexsy.in</p>
                            <p class="font-semibold text-slate-600">Password: StockIQ@2026</p>
                        </div>
                        <button
                            type="button"
                            id="demo-login-fill"
                            class="btn-secondary shrink-0 border-blue-200 text-blue-700 hover:bg-white"
                            data-email="bharath@nexsy.in"
                            data-password="StockIQ@2026"
                        >
                            Autofill
                        </button>
                    </div>
                </div>

                <label class="mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 p-0 shadow-none">
                    Remember this device
                </label>

                <button class="btn-primary mt-6 w-full">Login to Dashboard</button>
            </form>
        </section>
    </main>

    <script>
        document.getElementById('demo-login-fill')?.addEventListener('click', function () {
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            if (! email || ! password) {
                return;
            }

            email.value = this.dataset.email || '';
            password.value = this.dataset.password || '';
            password.focus();
        });
    </script>
</body>
</html>
