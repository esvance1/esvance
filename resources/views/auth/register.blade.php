@extends('layouts.frontend')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 pt-[100px] pb-20 relative z-10">
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-esv-primary/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-esv-accent/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_15px_40px_rgba(107,33,168,0.1)] border border-slate-200 overflow-hidden relative">
        <div class="bg-gradient-to-r from-esv-primary to-esv-accent p-8 text-center relative overflow-hidden">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            <div class="w-16 h-16 mx-auto bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 border border-white/30 shadow-inner">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            </div>
            <h2 class="text-3xl font-display font-black text-white uppercase italic tracking-wide relative z-10">
                Create <span class="text-[#1e1b4b]">Account</span>
            </h2>
            <p class="text-white/80 text-sm mt-1 relative z-10">สมัครสมาชิกเพื่อเริ่มต้นใช้งาน</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="username" class="block text-[11px] font-black text-esv-primary uppercase tracking-widest mb-1.5 ml-1">ชื่อผู้ใช้ (Username) *ใช้แสดงและล็อคอิน</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-esv-primary/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" class="block w-full pl-11 pr-4 py-3.5 bg-purple-50/50 border border-purple-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="ภาษาอังกฤษหรือตัวเลข (เช่น player99)">
                    </div>
                    @error('username') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">อีเมล (Email) *ใช้กู้รหัสผ่าน</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="กรอกอีเมลของคุณ">
                    </div>
                    @error('email') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">รหัสผ่าน (Password)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="ตั้งรหัสผ่าน">
                    </div>
                    @error('password') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">ยืนยันรหัสผ่าน</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="กรอกรหัสผ่านอีกครั้ง">
                    </div>
                    @error('password_confirmation') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-[#1e1b4b] text-white text-sm font-black uppercase tracking-wider skew-x-[-5deg] shadow-lg hover:bg-esv-primary hover:shadow-xl transition-all flex items-center justify-center group rounded-md">
                        <span class="skew-x-[5deg] group-hover:scale-105 transition-transform flex items-center gap-2">
                            สมัครสมาชิก (Register)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        </span>
                    </button>
                </div>

                <p class="text-center text-sm font-bold text-slate-500 mt-4 pt-4 border-t border-slate-100">
                    มีบัญชีอยู่แล้ว?
                    <a href="{{ route('login') }}" class="text-esv-primary hover:text-purple-800 hover:underline decoration-2 underline-offset-4 transition-all">เข้าสู่ระบบ</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
