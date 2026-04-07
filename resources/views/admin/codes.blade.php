@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 pt-[120px] pb-20">

    <div class="flex flex-col lg:flex-row gap-8">

        @include('admin.sidebar')

        <div class="flex-1">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-8 flex items-center gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-display font-black text-slate-800">จัดการโค้ดเติมเงิน</h2>
                    <p class="text-slate-500 font-medium mt-1">สร้างรหัส (Redeem Code) ไว้สำหรับแจกกิจกรรมหรือโปรโมชั่น</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <div class="xl:col-span-1">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 sticky top-[100px]">
                        <div class="flex items-center gap-2 mb-6 border-b border-slate-100 pb-4">
                            <div class="bg-esv-primary/10 p-2 rounded-lg text-esv-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">สร้างโค้ดใหม่</h3>
                        </div>

                        <form action="{{ route('admin.codes.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-sm font-bold text-slate-700">ชื่อโค้ด <span class="text-slate-400 font-normal">(เว้นว่างเพื่อสุ่มอัตโนมัติ)</span></label>
                                <input type="text" name="code" placeholder="เช่น FREEVIP" class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary uppercase font-mono tracking-widest transition-colors">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-700">ยอดเงินที่ได้รับ (บาท)</label>
                                <input type="number" name="reward_amount" required min="1" placeholder="100" class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary font-bold text-green-600 transition-colors">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-700">จำกัดจำนวนคนใช้ (ครั้ง)</label>
                                <input type="number" name="max_uses" required min="1" value="10" class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                            </div>

                            <button type="submit" class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold mt-4 hover:bg-black transition-colors shadow-md flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
                                สร้างและแจกโค้ดเลย
                            </button>
                        </form>
                    </div>
                </div>

                <div class="xl:col-span-2">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 overflow-x-auto">
                        <div class="flex items-center gap-2 mb-6 border-b border-slate-100 pb-4">
                            <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">โค้ดที่สร้างไว้ทั้งหมด</h3>
                        </div>

                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr class="uppercase tracking-wider text-[11px] font-black">
                                    <th class="px-4 py-4 rounded-tl-xl">รหัสโค้ด</th>
                                    <th class="px-4 py-4 text-center">ยอดที่ได้</th>
                                    <th class="px-4 py-4 text-center">ถูกใช้ไป (คน)</th>
                                    <th class="px-4 py-4 text-center">สถานะ</th>
                                    <th class="px-4 py-4 text-center rounded-tr-xl">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($codes as $code)
                                @php $isFull = $code->current_uses >= $code->max_uses; @endphp
                                <tr class="transition-colors group {{ $isFull ? 'opacity-50 grayscale bg-slate-50' : 'hover:bg-slate-50/50' }}">
                                    <td class="px-4 py-4">
                                        <div class="font-mono font-black text-indigo-600 tracking-wider text-base bg-indigo-50 inline-block px-3 py-1 rounded-lg border border-indigo-100">{{ $code->code }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center font-black text-green-600 text-base">+฿{{ number_format($code->reward_amount, 2) }}</td>
                                    <td class="px-4 py-4 text-center font-bold text-slate-600">{{ $code->current_uses }} / {{ $code->max_uses }}</td>
                                    <td class="px-4 py-4 text-center">
                                        @if($isFull)
                                            <span class="bg-red-100 text-red-600 px-2.5 py-1 rounded-md text-[10px] font-bold shadow-sm">เต็มแล้ว</span>
                                        @else
                                            <span class="bg-green-100 text-green-600 px-2.5 py-1 rounded-md text-[10px] font-bold shadow-sm">ใช้งานได้</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.codes.delete', $code->id) }}" onclick="return confirm('ลบโค้ดนี้ทิ้งเลยใช่ไหม? (หากลบ ลูกค้าที่เคยใช้ไปแล้วยอดเงินจะไม่หายไปไหน)')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-slate-400 font-bold">
                                        ยังไม่ได้สร้างโค้ดแจกในระบบครับ
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
