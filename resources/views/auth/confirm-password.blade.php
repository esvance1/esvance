@extends('layouts.frontend')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 pt-[100px] pb-20 relative z-10">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_15px_40px_rgba(107,33,168,0.1)] border border-slate-200 overflow-hidden relative">

        <div class="bg-gradient-to-r from-red-600 to-rose-500 p-8 text-center relative overflow-hidden">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            <div class="w-16 h-16 mx-auto bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 border border-white/30 shadow-inner">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <h2 class="text-3xl font-display font-black text-white uppercase italic tracking-wide relative z-10">
                Secure <span class="text-rose-200">Area</span>
            </h2>
            <p class="text-rose-100 text-sm mt-1 relative z-10">ยืนยันตัวตนเพื่อความปลอดภัย</p>
        </div>

        <div class="p-8">
            <div class="mb-6 text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">
                นี่คือพื้นที่ปลอดภัยของระบบ โปรดยืนยันรหัสผ่านของคุณอีกครั้งก่อนดำเนินการต่อครับ
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="password" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 ml-1">รหัสผ่าน (Password)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-red-500/30 focus:border-red-500 transition-all outline-none" placeholder="กรอกรหัสผ่านของคุณ">
                    </div>
                    @error('password') <p class="text-red-500 text-xs font-bold mt-1.5 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-red-600 text-white text-sm font-black uppercase tracking-wider skew-x-[-5deg] shadow-lg hover:bg-red-700 hover:shadow-xl transition-all flex items-center justify-center group rounded-md">
                        <span class="skew-x-[5deg] group-hover:scale-105 transition-transform flex items-center gap-2">
                            ยืนยันรหัสผ่าน (Confirm)
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
