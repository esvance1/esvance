@extends('layouts.frontend')

@section('content')
<div class="min-h-[85vh] pt-[120px] pb-20 relative z-10 px-4">
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-esv-primary/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-esv-accent/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    <div class="max-w-5xl mx-auto">
        <a href="{{ url('/#category-section') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-500 font-bold rounded-xl hover:bg-slate-50 hover:text-esv-primary transition-colors shadow-sm mb-6 border border-slate-200 w-fit">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            กลับหน้าตลาดซื้อขาย
        </a>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_40px_rgba(107,33,168,0.08)] border border-slate-200 overflow-hidden flex flex-col md:flex-row">

            <div class="md:w-2/5 bg-slate-100 relative overflow-hidden flex items-center justify-center p-8 min-h-[300px]">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-[#1e1b4b] opacity-5"></div>
                @if(filter_var($product->icon, FILTER_VALIDATE_URL))
                    <img src="{{ $product->icon }}" class="w-full max-w-[280px] h-auto object-cover rounded-2xl shadow-2xl relative z-10 hover:scale-105 transition-transform duration-500 border-4 border-white">
                @else
                    <div class="w-full max-w-[280px] aspect-square flex items-center justify-center bg-white rounded-2xl shadow-2xl relative z-10 border-4 border-white text-slate-300">
                        <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                @endif

                @if($product->is_hot)
                    <div class="absolute top-6 left-6 bg-red-500 text-white text-[11px] font-black px-4 py-1.5 skew-x-[-15deg] tracking-widest shadow-lg z-20">
                        <span class="block skew-x-[15deg]">HOT ITEM</span>
                    </div>
                @endif
            </div>

            <div class="md:w-3/5 p-8 md:p-12 flex flex-col relative">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="bg-purple-50 text-esv-primary px-3 py-1 rounded-md text-[10px] font-black tracking-widest uppercase border border-purple-100">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                        <div class="flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-md border {{ $product->stock > 0 ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                            <div class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></div>
                            {{ $product->stock > 0 ? 'มีสินค้าพร้อมส่ง (เหลือ '.$product->stock.' ชิ้น)' : 'สินค้าหมดชั่วคราว' }}
                        </div>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-display font-black text-slate-800 uppercase italic tracking-wide leading-tight mb-4">
                        {{ $product->name }}
                    </h1>

                    <div class="text-3xl font-display font-black text-esv-primary italic mb-8 flex items-end gap-2">
                        ฿{{ number_format($product->price, 0) }}
                        <span class="text-sm text-slate-400 font-medium not-italic mb-1.5">/ ไอดี</span>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-esv-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            รายละเอียดสินค้า
                        </h3>
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 text-slate-600 text-sm leading-relaxed">
                            {{ $product->description ?? 'ไม่มีรายละเอียดเพิ่มเติมสำหรับสินค้านี้ครับ' }}
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <form action="{{ route('buy.product', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('ยืนยันสั่งซื้อ [{{ $product->name }}] ในราคา ฿{{ number_format($product->price, 0) }} ใช่หรือไม่?')"
                                class="w-full py-4 text-white text-lg font-black uppercase tracking-wider skew-x-[-5deg] shadow-lg transition-all flex items-center justify-center gap-2 group {{ $product->stock > 0 ? 'bg-gradient-to-r from-[#1e1b4b] to-esv-primary hover:shadow-[0_15px_30px_rgba(107,33,168,0.3)] hover:-translate-y-1' : 'bg-slate-300 cursor-not-allowed border-2 border-slate-300 shadow-none' }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>

                            <span class="skew-x-[5deg] flex items-center gap-2 group-hover:scale-105 transition-transform">
                                @if($product->stock > 0)
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    สั่งซื้อสินค้านี้เลย
                                @else
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    สินค้าหมดชั่วคราว
                                @endif
                            </span>
                        </button>
                    </form>
                    <p class="text-center text-xs text-slate-400 font-bold mt-4">
                        *ระบบจะส่งข้อมูลไอดีให้คุณอัตโนมัติที่หน้า <a href="{{ route('history') }}" class="text-esv-primary hover:underline">ประวัติการซื้อ</a> ทันทีหลังชำระเงิน
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
