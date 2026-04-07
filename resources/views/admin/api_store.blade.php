@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 pt-[120px] pb-20 relative z-10">
    <div class="flex flex-col lg:flex-row gap-8">
        @include('admin.sidebar')

        <div class="flex-1">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-8 flex items-center gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-gradient-to-r from-[#1e1b4b] to-esv-primary p-6 rounded-3xl text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <svg class="w-7 h-7 text-esv-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-black uppercase italic tracking-wide">API <span class="text-esv-accent">Marketplace</span></h2>
                        <p class="text-purple-200 font-medium text-sm mt-1">คลังสินค้าต้นทาง WichxShop</p>
                    </div>
                </div>
                <div class="bg-black/20 px-5 py-3 rounded-2xl border border-white/10 text-right">
                    <div class="text-[10px] font-black text-purple-200 uppercase tracking-widest">ยอดเงินคงเหลือ (API)</div>
                    <div class="text-2xl font-display font-black text-esv-accent">฿{{ number_format($balance, 2) }}</div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mb-6 mt-4">
                <form action="{{ route('admin.api_store.sync_stock') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-white text-esv-primary border border-esv-primary rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-esv-primary hover:text-white transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        อัปเดตสต๊อกหน้าร้าน
                    </button>
                </form>

                <form action="{{ route('admin.api_store.sync_claims') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-white text-rose-600 border border-rose-200 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        เช็คสถานะงานเคลม
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($apiProducts as $item)
                    @php
                        // 🚨 ค้นหาว่าสินค้านี้ดึงเข้าระบบเราหรือยัง ถ้ามีให้ดึงข้อมูลมาแสดงด้วย
                        $localProduct = \App\Models\Product::where('api_product_id', $item['id'])->first();
                    @endphp
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col group">
                        <div class="h-40 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            @if(filter_var($item['image'], FILTER_VALIDATE_URL))
                                <img src="{{ $item['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <span class="text-slate-400 font-bold">ไม่มีรูปภาพ</span>
                            @endif
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-esv-dark text-[10px] font-bold px-2 py-1 rounded-md shadow-sm">
                                สต๊อก API: {{ $item['stock'] }}
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h4 class="font-bold text-slate-800 text-sm mb-3 line-clamp-2 leading-tight h-10">{{ $item['name'] }}</h4>
                            <div class="text-slate-500 text-xs mb-4">ต้นทุน: <strong class="text-rose-500 text-base">฿{{ number_format($item['price']) }}</strong></div>

                            @if($localProduct)
                                <form action="{{ url('/admin/api-store/quick-update/'.$localProduct->id) }}" method="POST" class="mt-auto flex flex-col gap-2 bg-green-50/50 p-3 rounded-xl border border-green-100">
                                    @csrf
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[10px] font-black text-green-600 bg-green-100 px-2 py-1 rounded-md">✅ นำเข้าแล้ว</span>
                                        <span class="text-[10px] font-bold text-slate-400">กำไร ฿{{ number_format($localProduct->price - $item['price']) }}</span>
                                    </div>

                                    <div>
                                        <label class="text-[10px] font-bold text-slate-500">ชื่อแสดงหน้าเว็บ</label>
                                        <input type="text" name="name" value="{{ $localProduct->name }}" required class="w-full mt-0.5 px-2 py-1.5 bg-white border border-slate-200 rounded-md text-xs font-bold focus:ring-2 focus:ring-green-500 transition-all">
                                    </div>

                                    <div>
                                        <label class="text-[10px] font-bold text-slate-500">ปรับราคาขาย</label>
                                        <input type="number" name="my_price" value="{{ $localProduct->price }}" min="{{ $item['price'] }}" required class="w-full mt-0.5 px-2 py-1.5 bg-white border border-slate-200 rounded-md text-xs font-bold text-esv-primary focus:ring-2 focus:ring-green-500 transition-all">
                                    </div>

                                    <div class="flex gap-2 mt-2">
                                        <button type="submit" class="flex-1 py-2 bg-emerald-500 text-white rounded-lg font-bold text-xs hover:bg-emerald-600 transition-colors shadow-sm">
                                            บันทึก
                                        </button>
                                        <a href="{{ route('admin.products') }}" class="py-2 px-3 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors shadow-sm flex items-center justify-center" title="ตั้งค่าขั้นสูงในหน้าสินค้า">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </a>
                                    </div>
                                </form>

                            @else
                                <form action="{{ route('admin.api_store.import') }}" method="POST" class="mt-auto flex flex-col gap-2">
                                    @csrf
                                    <input type="hidden" name="api_product_id" value="{{ $item['id'] }}">
                                    <input type="hidden" name="name" value="{{ $item['name'] }}">
                                    <input type="hidden" name="image" value="{{ $item['image'] }}">

                                    <div>
                                        <label class="text-[10px] font-bold text-slate-500">ตั้งราคาขายของคุณ (บวกกำไร)</label>
                                        <input type="number" name="my_price" value="{{ $item['price'] + 50 }}" min="{{ $item['price'] }}" required class="w-full mt-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold focus:ring-2 focus:ring-esv-primary">
                                    </div>
                                    <button type="submit" class="w-full py-2.5 bg-esv-dark text-white rounded-lg font-bold text-sm hover:bg-esv-primary transition-colors shadow-md mt-1">
                                        นำเข้าสินค้านี้
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                        <p class="text-slate-500 font-bold">ไม่พบสินค้าจาก API หรือ API Key ไม่ถูกต้องครับ</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
