<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (User::query()->exists()) {
            return;
        }

        User::create([
            'name' => env('ADMIN_NAME', 'Bharath'),
            'email' => env('ADMIN_EMAIL', 'admin@stockiq.local'),
            'mobile' => env('ADMIN_MOBILE'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'StockIQ@12345')),
        ]);
    }
}
