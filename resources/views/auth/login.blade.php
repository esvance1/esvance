@extends('layouts.frontend')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 pt-[100px] pb-20 relative z-10">
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-esv-primary/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-esv-accent/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_15px_40px_rgba(107,33,168,0.1)] border border-slate-200 overflow-hidden relative">
        <div class="bg-gradient-to-r from-[#1e1b4b] to-esv-primary p-8 text-center relative overflow-hidden">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5 -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
            <div class="w-16 h-16 mx-auto bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 border border-white/20 shadow-inner">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
            </div>
            <h2 class="text-3xl font-display font-black text-white uppercase italic tracking-wide relative z-10">
                Welcome <span class="text-esv-accent">Back</span>
            </h2>
            <p class="text-purple-200 text-sm mt-1 relative z-10">เข้าสู่ระบบเพื่อดำเนินการต่อ</p>
        </div>

        <div class="p-8">
            @if (session('status'))
                <div class="mb-6 font-bold text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">ชื่อผู้ใช้ (Username)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="กรอกชื่อผู้ใช้ของคุณ">
                    </div>
                    @error('username') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5 ml-1 mr-1">
                        <label for="password" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest">รหัสผ่าน (Password)</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-esv-primary hover:text-purple-800 transition-colors">ลืมรหัสผ่าน?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all outline-none" placeholder="••••••••">
                    </div>
                    @error('password') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center ml-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-esv-primary shadow-sm focus:ring-esv-primary/30 w-4 h-4 transition-all cursor-pointer">
                        <span class="ml-2 text-sm font-bold text-slate-500 group-hover:text-slate-700 transition-colors">จดจำฉันไว้ในระบบ</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-esv-primary text-white text-sm font-black uppercase tracking-wider skew-x-[-5deg] shadow-lg hover:bg-esv-dark hover:shadow-xl transition-all flex items-center justify-center group rounded-md">
                        <span class="skew-x-[5deg] group-hover:scale-105 transition-transform flex items-center gap-2">
                            เข้าสู่ระบบ (Login)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </span>
                    </button>
                </div>

                <p class="text-center text-sm font-bold text-slate-500 mt-6 pt-6 border-t border-slate-100">
                    ยังไม่มีบัญชีใช่ไหม?
                    <a href="{{ route('register') }}" class="text-esv-primary hover:text-purple-800 hover:underline decoration-2 underline-offset-4 transition-all">สมัครสมาชิกเลย</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
