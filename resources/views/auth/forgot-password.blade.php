@extends('layouts.frontend')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 pt-[100px] pb-20 relative z-10">

    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-esv-primary/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-esv-accent/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_15px_40px_rgba(107,33,168,0.1)] border border-slate-200 overflow-hidden relative">

        <div class="bg-gradient-to-r from-[#1e1b4b] to-esv-primary p-8 text-center relative overflow-hidden">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5 -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
            <div class="w-16 h-16 mx-auto bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 border border-white/20 shadow-inner">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
            </div>
            <h2 class="text-3xl font-display font-black text-white uppercase italic tracking-wide relative z-10">
                Recover <span class="text-esv-accent">Password</span>
            </h2>
            <p class="text-purple-200 text-sm mt-1 relative z-10">กู้คืนรหัสผ่านของคุณ</p>
        </div>

        <div class="p-8">
            <div class="mb-6 text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">
                ลืมรหัสผ่านใช่ไหม? ไม่มีปัญหาครับ เพียงกรอกอีเมลของคุณด้านล่าง เราจะส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ไปให้ครับ
            </div>

            @if (session('status'))
                <div class="mb-6 font-bold text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">อีเมล (Email)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="กรอกอีเมลที่ใช้สมัคร">
                    </div>
                    @error('email') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-esv-primary text-white text-sm font-black uppercase tracking-wider skew-x-[-5deg] shadow-lg hover:bg-esv-dark hover:shadow-xl transition-all flex items-center justify-center group rounded-md">
                        <span class="skew-x-[5deg] group-hover:scale-105 transition-transform flex items-center gap-2">
                            ส่งลิงก์รีเซ็ตรหัสผ่าน
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </span>
                    </button>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-esv-primary transition-colors underline decoration-2 underline-offset-4">กลับไปหน้าเข้าสู่ระบบ</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
