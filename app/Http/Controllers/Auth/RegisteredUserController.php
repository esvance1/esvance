<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้ครับ',
            'username.unique' => 'ชื่อผู้ใช้นี้มีคนใช้งานแล้วครับ โปรดใช้ชื่ออื่น',
            'email.required' => 'กรุณากรอกอีเมลครับ',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้องครับ',
            'email.unique' => 'อีเมลนี้ถูกใช้สมัครไปแล้วครับ',
            'password.required' => 'กรุณากรอกรหัสผ่านครับ',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกันครับ',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษรครับ',
        ]);

        $user = User::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::login($user);

        // 🚨 เปลี่ยนตรงนี้ให้วิ่งกลับไปหน้าหลักแทนครับ จบปัญหาเลย!
        return redirect('/');
    }
}
