@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 pt-[120px] pb-20">

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">

        <div class="h-40 bg-gradient-to-r from-[#210934] to-[#401268] relative">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            @if($vip == 'Platinum') <div class="absolute top-4 right-4 bg-gradient-to-r from-gray-200 to-gray-400 text-black font-black px-4 py-1.5 rounded-full shadow-lg text-sm border-2 border-white">💎 PLATINUM VIP</div>
            @elseif($vip == 'Gold') <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-300 to-yellow-500 text-black font-black px-4 py-1.5 rounded-full shadow-lg text-sm border-2 border-white">👑 GOLD VIP</div>
            @elseif($vip == 'Silver') <div class="absolute top-4 right-4 bg-gradient-to-r from-slate-300 to-slate-400 text-black font-black px-4 py-1.5 rounded-full shadow-lg text-sm border-2 border-white">🥈 SILVER VIP</div>
            @else <div class="absolute top-4 right-4 bg-slate-800 text-white font-bold px-4 py-1.5 rounded-full shadow-lg text-sm border border-slate-600">👤 MEMBER</div>
            @endif
        </div>

        <div class="px-8 pb-10 relative">
            <div class="w-28 h-28 bg-white rounded-full border-4 border-white shadow-xl absolute -top-14 flex items-center justify-center text-5xl overflow-hidden">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6b21a8&color=fff" class="w-full h-full object-cover">
            </div>

            <div class="pt-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h2 class="text-3xl font-display font-black text-slate-800">{{ $user->name }}</h2>
                    <p class="text-slate-500 font-medium">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-sm">ยอดเงิน: ฿{{ number_format($user->balance, 2) }}</span>
                        <a href="{{ route('topup') }}" class="text-xs bg-esv-primary text-white font-bold px-3 py-1.5 rounded-full hover:bg-purple-800 transition">เติมเงินเพิ่ม</a>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-center min-w-[100px]">
                        <p class="text-xs font-bold text-slate-500 mb-1">แต้มสะสม</p>
                        <p class="text-xl font-black text-purple-700">{{ number_format($user->points) }} <span class="text-sm">pts</span></p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-center min-w-[100px]">
                        <p class="text-xs font-bold text-slate-500 mb-1">ซื้อไปแล้ว</p>
                        <p class="text-xl font-black text-blue-600">{{ $ordersCount }} <span class="text-sm">ครั้ง</span></p>
                    </div>
                </div>
            </div>

            <div class="mt-10 bg-slate-50 border border-slate-100 p-6 rounded-2xl">
                <div class="flex justify-between items-end mb-2">
                    <h3 class="font-bold text-slate-700">ระดับถัดไป: <span class="text-esv-primary font-black">{{ $next === 'MAX' ? 'ระดับสูงสุดแล้ว' : number_format($next) . ' แต้ม' }}</span></h3>
                    <span class="text-sm font-bold text-slate-500">{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="w-full bg-slate-200 h-3 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-yellow-400 h-full rounded-full transition-all duration-1000" style="width: {{ min($progress, 100) }}%"></div>
                </div>
                <p class="text-xs text-slate-400 mt-3 text-center">สะสมแต้มจากการเติมเงินและซื้อไอดีเกม (ทุกการใช้จ่าย 1 บาท = 1 แต้ม)</p>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('history') }}" class="px-6 py-3 bg-slate-800 text-white font-bold rounded-xl hover:bg-black transition shadow-md">ดูประวัติการซื้อ</a>

                <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition shadow-sm">ตั้งค่าบัญชี / รหัสผ่าน</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-red-100 text-red-600 font-bold rounded-xl hover:bg-red-500 hover:text-white transition shadow-sm">ออกจากระบบ</button>
                </form>
            </div>

        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ url('/') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">← กลับหน้าแรก</a>
    </div>

</div>
@endsection
