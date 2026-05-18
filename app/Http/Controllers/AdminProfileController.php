<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'mobile' => ['nullable', 'string', 'max:30'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user->name = $data['name'];
        $user->mobile = $data['mobile'] ?? null;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('status', 'Admin profile updated.');
    }
}
