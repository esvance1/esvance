@extends('layouts.frontend')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 pt-[100px] pb-20 relative z-10">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_15px_40px_rgba(107,33,168,0.1)] border border-slate-200 overflow-hidden relative">

        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center relative overflow-hidden">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/10 -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            <div class="w-16 h-16 mx-auto bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-4 border border-white/30 shadow-inner">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <h2 class="text-3xl font-display font-black text-white uppercase italic tracking-wide relative z-10">
                Verify <span class="text-blue-200">Email</span>
            </h2>
            <p class="text-blue-100 text-sm mt-1 relative z-10">ยืนยันอีเมลของคุณ</p>
        </div>

        <div class="p-8">
            <div class="mb-6 text-sm font-medium text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">
                ขอบคุณที่สมัครสมาชิก! ก่อนเริ่มต้นใช้งาน รบกวนยืนยันอีเมลของคุณโดยคลิกลิงก์ที่เราเพิ่งส่งไปให้ครับ หากไม่ได้รับอีเมล สามารถกดส่งใหม่ได้เลยครับ
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 font-bold text-sm text-green-600 bg-green-50 p-4 rounded-xl border border-green-200 text-center flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    ส่งลิงก์ยืนยันใหม่ไปยังอีเมลของคุณเรียบร้อยแล้วครับ
                </div>
            @endif

            <div class="flex flex-col gap-4 mt-6">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full py-3.5 bg-blue-600 text-white text-sm font-black uppercase tracking-wider skew-x-[-5deg] shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all flex items-center justify-center group rounded-md">
                        <span class="skew-x-[5deg] group-hover:scale-105 transition-transform">
                            ส่งอีเมลยืนยันอีกครั้ง
                        </span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-colors underline decoration-2 underline-offset-4 mt-2">
                        ออกจากระบบ (Log Out)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
