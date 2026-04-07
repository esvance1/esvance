@extends('layouts.frontend')

@section('content')
    <div class="max-w-6xl mx-auto px-4 pt-[90px]">
        <div class="rounded-3xl overflow-hidden shadow-[0_15px_30px_rgba(107,33,168,0.2)] w-full h-[250px] md:h-[400px] relative group border border-slate-200">
            <div class="swiper mySwiper w-full h-full bg-slate-900">
                <div class="swiper-wrapper">
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover opacity-80">
                        <div class="absolute inset-0 bg-gradient-to-r from-esv-dark/90 via-esv-primary/60 to-transparent flex flex-col justify-center px-8 md:px-16">
                            <div class="bg-esv-accent text-white text-[10px] font-black px-4 py-1.5 w-fit mb-4 skew-x-[-15deg] shadow-lg">
                                <span class="block skew-x-[15deg] tracking-widest uppercase">Official Store</span>
                            </div>
                            <h2 class="text-white text-4xl md:text-6xl font-display font-black italic tracking-wider mb-2 uppercase drop-shadow-md">
                                ESVANCE <span class="text-esv-accent">SHOP</span>
                            </h2>
                            <p class="text-purple-100 text-sm md:text-base max-w-lg font-medium border-l-4 border-esv-accent pl-4 bg-black/20 py-2 pr-4 backdrop-blur-sm rounded-r-lg">
                                ศูนย์รวมไอดี eFootball ระดับพรีเมียม รวบรวมนักเตะ Big Time & Epic ครบจบในที่เดียว จัดส่งอัตโนมัติ 24 ชม.
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover opacity-80">
                        <div class="absolute inset-0 bg-gradient-to-r from-esv-dark/90 via-esv-primary/60 to-transparent flex flex-col justify-center px-8 md:px-16">
                            <div class="bg-red-500 text-white text-[10px] font-black px-4 py-1.5 w-fit mb-4 skew-x-[-15deg] shadow-lg">
                                <span class="block skew-x-[15deg] tracking-widest uppercase">Hot Promotion</span>
                            </div>
                            <h2 class="text-white text-4xl md:text-6xl font-display font-black italic tracking-wider mb-2 uppercase drop-shadow-md">
                                ไอดีดองทอง<span class="text-esv-accent">สุดคุ้ม</span>
                            </h2>
                            <p class="text-purple-100 text-sm md:text-base max-w-lg font-medium border-l-4 border-red-500 pl-4 bg-black/20 py-2 pr-4 backdrop-blur-sm rounded-r-lg">
                                แพ็กเกจพิเศษสำหรับสายสร้างทีม รวบรวมแรร์ไอเทม เริ่มสร้าง Dream Team ของคุณได้แล้ววันนี้!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next !text-esv-accent !scale-75 drop-shadow-lg"></div>
                <div class="swiper-button-prev !text-esv-accent !scale-75 drop-shadow-lg"></div>
            </div>
        </div>
    </div>

    <div class="max-w-[800px] mx-auto px-4 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 border-l-4 border-l-esv-primary flex items-center gap-4 hover:shadow-lg transition-shadow group">
                <div class="w-14 h-14 rounded-xl bg-purple-50 text-esv-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ผู้ใช้งานระบบ</div>
                    <div class="text-2xl font-black text-esv-dark font-display">{{ number_format($stats['users_count'] ?? 19184) }} <span class="text-xs text-slate-400 font-medium">คน</span></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 border-l-4 border-l-esv-accent flex items-center gap-4 hover:shadow-lg transition-shadow group">
                <div class="w-14 h-14 rounded-xl bg-fuchsia-50 text-esv-accent flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ไอดีพร้อมขาย</div>
                    <div class="text-2xl font-black text-esv-dark font-display">{{ number_format($stats['total_stock'] ?? 506) }} <span class="text-xs text-slate-400 font-medium">ชิ้น</span></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 border-l-4 border-l-green-500 flex items-center gap-4 hover:shadow-lg transition-shadow group">
                <div class="w-14 h-14 rounded-xl bg-green-50 text-green-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ส่งมอบสำเร็จ</div>
                    <div class="text-2xl font-black text-esv-dark font-display">{{ number_format($stats['total_sold'] ?? 27542) }} <span class="text-xs text-slate-400 font-medium">ครั้ง</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[800px] mx-auto px-4 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <a href="#" class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-esv-dark to-esv-primary p-6 flex items-center group transition-transform hover:-translate-y-1 shadow-lg">
                <div class="absolute right-0 top-0 w-32 h-full bg-white/5 skew-x-[-20deg] translate-x-10 group-hover:bg-white/10 transition-colors"></div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-white relative z-10 border border-white/20 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                </div>
                <div class="ml-5 relative z-10 flex-1">
                    <h4 class="text-[10px] font-black text-esv-accent tracking-widest uppercase">Support</h4>
                    <h3 class="text-xl font-display font-black text-white italic uppercase tracking-wide">ติดต่อเรา</h3>
                </div>
                <svg class="w-5 h-5 text-white/50 relative z-10 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            <a href="{{ route('history') }}" class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-esv-dark to-esv-primary p-6 flex items-center group transition-transform hover:-translate-y-1 shadow-lg">
                <div class="absolute right-0 top-0 w-32 h-full bg-white/5 skew-x-[-20deg] translate-x-10 group-hover:bg-white/10 transition-colors"></div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-white relative z-10 border border-white/20 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div class="ml-5 relative z-10 flex-1">
                    <h4 class="text-[10px] font-black text-esv-accent tracking-widest uppercase">My Orders</h4>
                    <h3 class="text-xl font-display font-black text-white italic uppercase tracking-wide">ประวัติการซื้อ</h3>
                </div>
                <svg class="w-5 h-5 text-white/50 relative z-10 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            <a href="{{ route('topup') }}" class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-esv-dark to-esv-primary p-6 flex items-center group transition-transform hover:-translate-y-1 shadow-lg">
                <div class="absolute right-0 top-0 w-32 h-full bg-white/5 skew-x-[-20deg] translate-x-10 group-hover:bg-white/10 transition-colors"></div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-white relative z-10 border border-white/20 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="ml-5 relative z-10 flex-1">
                    <h4 class="text-[10px] font-black text-esv-accent tracking-widest uppercase">Add Funds</h4>
                    <h3 class="text-xl font-display font-black text-white italic uppercase tracking-wide">เติมเงิน</h3>
                </div>
                <svg class="w-5 h-5 text-white/50 relative z-10 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

            <a href="#category-section" class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-esv-dark to-esv-primary p-6 flex items-center group transition-transform hover:-translate-y-1 shadow-lg">
                <div class="absolute right-0 top-0 w-32 h-full bg-white/5 skew-x-[-20deg] translate-x-10 group-hover:bg-white/10 transition-colors"></div>
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center text-white relative z-10 border border-white/20 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                </div>
                <div class="ml-5 relative z-10 flex-1">
                    <h4 class="text-[10px] font-black text-esv-accent tracking-widest uppercase">Products</h4>
                    <h3 class="text-xl font-display font-black text-white italic uppercase tracking-wide">หมวดหมู่</h3>
                </div>
                <svg class="w-5 h-5 text-white/50 relative z-10 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>

        </div>
    </div>


    @php
        $hotProducts = $products->filter(function($item) {
            return (!isset($item->is_visible) || $item->is_visible == 1) && $item->is_hot == 1;
        });
    @endphp

    @if($hotProducts->count() > 0)
    <div class="max-w-6xl mx-auto px-4 mt-20 mb-10">
        <div class="flex flex-col items-center justify-center mb-8 text-center">
            <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-black tracking-widest uppercase mb-3 flex items-center gap-1.5 border border-red-200">
                <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span></span>
                Recommend
            </div>
            <h2 class="text-3xl md:text-4xl font-display font-black text-esv-dark uppercase italic tracking-wide">
                HOT <span class="text-red-500">ITEMS</span>
            </h2>
            <div class="w-16 h-1.5 bg-red-500 mt-2 skew-x-[-20deg]"></div>
            <p class="text-slate-500 mt-3 font-medium text-sm">สินค้าขายดี แอดมินแนะนำ คุ้มค่าที่สุด!</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($hotProducts as $product)
            <div class="bg-white rounded-2xl border overflow-hidden shadow-sm transition-all group flex flex-col h-full relative {{ $product->stock <= 0 ? 'border-slate-200 opacity-80 grayscale-[20%]' : 'border-red-200 hover:shadow-[0_15px_30px_rgba(239,68,68,0.15)] hover:-translate-y-1 hover:border-red-400' }}">
                <a href="{{ route('product.show', $product->id) }}" class="block h-40 bg-slate-100 flex items-center justify-center relative overflow-hidden">
                    @if(filter_var($product->icon, FILTER_VALIDATE_URL))
                        <img src="{{ $product->icon }}" class="w-full h-full object-cover {{ $product->stock > 0 ? 'group-hover:scale-110 transition-transform duration-500' : '' }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400 {{ $product->stock > 0 ? 'group-hover:scale-110 transition-transform duration-500' : '' }}">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>

                    @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center backdrop-blur-[2px]">
                            <div class="bg-rose-600 text-white text-sm md:text-base font-black px-6 py-2 skew-x-[-15deg] tracking-widest shadow-xl border-2 border-white">
                                <span class="block skew-x-[15deg] uppercase">Sold Out</span>
                            </div>
                        </div>
                    @endif

                    @if($product->is_hot && $product->stock > 0)
                        <div class="absolute top-3 left-3 bg-red-500 text-white text-[9px] font-black px-3 py-1 skew-x-[-15deg] tracking-widest shadow-md z-20">
                            <span class="block skew-x-[15deg]">HOT</span>
                        </div>
                    @endif

                    <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur-sm text-[10px] font-bold px-2.5 py-1 rounded-md flex items-center gap-1.5 shadow-sm z-20 {{ $product->stock > 0 ? 'text-green-600 border border-green-200' : 'text-rose-600 border border-rose-200' }}">
                        @if($product->stock > 0)
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            เหลือ {{ $product->stock }}
                        @else
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            หมดสต๊อก
                        @endif
                    </div>
                </a>

                <div class="p-4 md:p-5 flex flex-col flex-1 border-t-[3px] {{ $product->stock > 0 ? 'border-red-500 group-hover:border-red-600' : 'border-slate-200' }} transition-colors">
                    <a href="{{ route('product.show', $product->id) }}" class="block {{ $product->stock > 0 ? 'hover:text-red-500 transition-colors' : 'pointer-events-none' }}">
                        <h4 class="font-display font-black text-slate-800 text-sm md:text-base mb-1 uppercase tracking-wide line-clamp-2 leading-tight transition-colors">{{ $product->name }}</h4>
                    </a>
                    <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="font-display font-black text-lg italic {{ $product->stock > 0 ? 'text-red-500' : 'text-slate-400' }}">฿{{ number_format($product->price, 0) }}</span>
                        <form action="{{ route('buy.product', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('ยืนยันสั่งซื้อ [{{ $product->name }}] ใช่หรือไม่?')"
                                class="px-4 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg shadow-md transition-colors {{ $product->stock > 0 ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none border border-slate-300' }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                @if($product->stock > 0)
                                    เลือกซื้อเลย
                                @else
                                    Sold Out
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div id="category-section" class="max-w-6xl mx-auto px-4 mt-20 pb-20 scroll-mt-[100px]">

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-5 py-4 rounded-xl mb-8 flex items-center gap-3 font-bold shadow-sm">
                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-5 py-4 rounded-xl mb-8 flex items-center gap-3 font-bold shadow-sm">
                <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col items-center justify-center mb-10 text-center">
            <h2 class="text-3xl md:text-4xl font-display font-black text-esv-dark uppercase italic tracking-wide">
                Transfer <span class="text-esv-primary">MARKET</span>
            </h2>
            <div class="w-16 h-1.5 bg-esv-accent mt-2 skew-x-[-20deg]"></div>
            <p class="text-slate-500 mt-3 font-medium text-sm">ตลาดซื้อขายไอดี เลือกรหัสที่ใช่แล้วลุยเลย!</p>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-6 mb-4 hide-scrollbar justify-center">
            <a href="{{ url('/') }}#category-section" class="shrink-0 px-6 py-3 font-black uppercase tracking-wider text-xs transition-all shadow-sm skew-x-[-15deg] border-2 {{ !request('category_id') ? 'bg-esv-primary text-white border-esv-primary' : 'bg-white text-slate-500 border-slate-200 hover:border-esv-primary hover:text-esv-primary' }}">
                <span class="block skew-x-[15deg]">ทั้งหมด</span>
            </a>
            @foreach($categories as $cat)
            <a href="{{ url('/?category_id='.$cat->id) }}#category-section" class="shrink-0 px-6 py-3 font-black uppercase tracking-wider text-xs transition-all shadow-sm skew-x-[-15deg] border-2 flex items-center gap-2 {{ request('category_id') == $cat->id ? 'bg-esv-primary text-white border-esv-primary' : 'bg-white text-slate-500 border-slate-200 hover:border-esv-primary hover:text-esv-primary' }}">
                <span class="flex items-center gap-2 skew-x-[15deg]">
                    @if($cat->icon)
                        <img src="{{ $cat->icon }}" class="w-4 h-4 rounded-sm object-cover">
                    @endif
                    {{ $cat->name }}
                </span>
            </a>
            @endforeach
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @php
                // กรองให้เหลือแค่สินค้าที่เปิดให้แสดงหน้าเว็บ (is_visible = 1 หรือ true)
                $visibleProducts = $products->filter(function($item) {
                    return !isset($item->is_visible) || $item->is_visible == 1;
                });
            @endphp
            @forelse($visibleProducts as $product)

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-[0_5px_15px_rgba(0,0,0,0.05)] transition-all group flex flex-col h-full {{ $product->stock <= 0 ? 'opacity-80 grayscale-[20%]' : 'hover:shadow-[0_15px_30px_rgba(107,33,168,0.15)] hover:-translate-y-1 hover:border-esv-primary/30' }}">

                <a href="{{ route('product.show', $product->id) }}" class="block h-36 md:h-44 bg-slate-100 flex items-center justify-center relative overflow-hidden">
                    @if(filter_var($product->icon, FILTER_VALIDATE_URL))
                        <img src="{{ $product->icon }}" class="w-full h-full object-cover {{ $product->stock > 0 ? 'group-hover:scale-110 transition-transform duration-500' : '' }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400 {{ $product->stock > 0 ? 'group-hover:scale-110 transition-transform duration-500' : '' }}">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>

                    @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center backdrop-blur-[2px]">
                            <div class="bg-rose-600 text-white text-sm md:text-base font-black px-6 py-2 skew-x-[-15deg] tracking-widest shadow-xl border-2 border-white">
                                <span class="block skew-x-[15deg] uppercase">Sold Out</span>
                            </div>
                        </div>
                    @endif

                    @if($product->is_hot && $product->stock > 0)
                        <div class="absolute top-3 left-3 bg-red-500 text-white text-[9px] font-black px-3 py-1 skew-x-[-15deg] tracking-widest shadow-md z-20">
                            <span class="block skew-x-[15deg]">HOT</span>
                        </div>
                    @endif

                    <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur-sm text-[10px] font-bold px-2.5 py-1 rounded-md flex items-center gap-1.5 shadow-sm z-20 {{ $product->stock > 0 ? 'text-green-600 border border-green-200' : 'text-rose-600 border border-rose-200' }}">
                        @if($product->stock > 0)
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            เหลือ {{ $product->stock }}
                        @else
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            หมดสต๊อก
                        @endif
                    </div>
                </a>

                <div class="p-4 md:p-5 flex flex-col flex-1 border-t-[3px] border-slate-200 {{ $product->stock > 0 ? 'group-hover:border-esv-primary transition-colors' : '' }}">

                    <a href="{{ route('product.show', $product->id) }}" class="block {{ $product->stock > 0 ? 'hover:text-esv-primary transition-colors' : 'pointer-events-none' }}">
                        <h4 class="font-display font-black text-slate-800 text-sm md:text-base mb-1 uppercase tracking-wide line-clamp-2 leading-tight transition-colors">{{ $product->name }}</h4>
                    </a>

                    <p class="text-[11px] md:text-xs text-slate-500 mb-4 line-clamp-2 font-medium">{{ $product->description }}</p>

                    <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="font-display font-black text-lg md:text-xl italic {{ $product->stock > 0 ? 'text-esv-primary' : 'text-slate-400' }}">฿{{ number_format($product->price, 0) }}</span>
                        </div>

                        <form action="{{ route('buy.product', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('ยืนยันสั่งซื้อ [{{ $product->name }}] ราคา ฿{{ number_format($product->price, 0) }} ใช่หรือไม่?')"
                                class="px-4 py-2 text-xs font-black uppercase tracking-wider skew-x-[-15deg] transition-colors shadow-md flex items-center justify-center min-w-[80px] {{ $product->stock > 0 ? 'bg-esv-dark text-white hover:bg-esv-primary' : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none border border-slate-300' }}"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <span class="skew-x-[15deg]">
                                    @if($product->stock > 0)
                                        Buy
                                    @else
                                        Sold
                                    @endif
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 md:col-span-4 text-center py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-bold text-lg">ยังไม่มีสินค้าในตลาดซื้อขายครับ</p>
            </div>
            @endforelse
        </div>
    </div>


    <div id="gacha" class="max-w-6xl mx-auto px-4 mt-10 mb-20">
        <div class="flex flex-col items-center justify-center mb-10 text-center">
            <h2 class="text-3xl md:text-4xl font-display font-black text-esv-dark uppercase italic tracking-wide">
                Special Packs <span class="text-esv-accent">GACHA</span>
            </h2>
            <div class="w-16 h-1.5 bg-esv-primary mt-2 skew-x-[-20deg]"></div>
            <p class="text-slate-500 mt-3 font-medium text-sm">ตู้สุ่มกาชาปอง ลุ้นรับไอดีแรร์ระดับ Epic & Big Time</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($boxes as $box)
            <div class="bg-white rounded-3xl p-6 text-center relative overflow-hidden shadow-[0_10px_20px_rgba(0,0,0,0.05)] hover:shadow-[0_15px_30px_rgba(107,33,168,0.15)] hover:-translate-y-2 transition-all border-2 {{ $box->is_vip ? 'border-esv-accent' : 'border-esv-primary/20' }} group">

                @if($box->is_vip)
                    <div class="absolute top-4 right-4 bg-gradient-to-r from-esv-accent to-fuchsia-500 text-white text-[10px] font-black px-4 py-1.5 skew-x-[-15deg] shadow-md tracking-widest z-10">
                        <span class="block skew-x-[15deg]">VIP S-CLASS</span>
                    </div>
                @endif

                <div class="mb-6 flex justify-center">
                    <div class="relative">
                        @if(filter_var($box->icon, FILTER_VALIDATE_URL))
                            <img src="{{ $box->icon }}" class="w-32 h-32 object-cover rounded-2xl border-[3px] {{ $box->is_vip ? 'border-esv-accent shadow-[0_10px_20px_rgba(217,70,239,0.3)]' : 'border-esv-primary shadow-[0_10px_20px_rgba(107,33,168,0.2)]' }} group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-32 h-32 flex items-center justify-center bg-slate-50 rounded-2xl border-[3px] {{ $box->is_vip ? 'border-esv-accent text-esv-accent' : 'border-esv-primary text-esv-primary' }} group-hover:scale-105 transition-transform duration-300 shadow-inner">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                        @endif
                    </div>
                </div>

                <h3 class="text-2xl font-display font-black mb-2 tracking-wide uppercase italic text-esv-dark">{{ $box->name }}</h3>

                <div class="text-[11px] text-slate-500 mb-6 bg-slate-50 py-2.5 rounded-xl border border-slate-100 flex items-center justify-center gap-1.5 font-bold">
                    <svg class="w-4 h-4 {{ $box->is_vip ? 'text-esv-accent' : 'text-esv-primary' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    การันตี Pity: สุ่มครบ {{ $box->pity_limit }} ครั้ง ออกของแรร์ชัวร์
                </div>

                <a href="{{ route('gacha.play', $box->id) }}" class="inline-flex justify-center items-center w-full py-4 font-black transition-all text-sm uppercase tracking-wider skew-x-[-10deg] shadow-md {{ $box->is_vip ? 'bg-esv-accent hover:bg-fuchsia-500 text-white' : 'bg-esv-primary hover:bg-purple-800 text-white' }}">
                    <span class="skew-x-[10deg]">เริ่มสุ่ม (฿{{ number_format($box->price) }})</span>
                </a>

            </div>
            @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-3xl border-2 border-dashed border-slate-300">
                <p class="text-slate-400 font-bold text-lg">แอดมินยังไม่ได้ตั้งค่าตู้สุ่มครับ</p>
            </div>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
<script>
    new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
@endpush
