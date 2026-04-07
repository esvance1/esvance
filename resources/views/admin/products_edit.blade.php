@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 pt-[120px] pb-20 relative z-10">

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 p-6 lg:p-10 relative overflow-hidden">

        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-400 rounded-full blur-[100px] opacity-10 pointer-events-none translate-x-1/2 -translate-y-1/2"></div>

        <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center shadow-sm border border-amber-100">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-display font-black text-slate-800 uppercase italic">Edit <span class="text-amber-500">Product</span></h2>
                    <p class="text-slate-500 font-medium text-sm mt-1">แก้ไขข้อมูลสินค้า: {{ $product->name }}</p>
                </div>
            </div>

            <a href="{{ url()->previous() }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors shadow-sm text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                กลับ
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-5 relative z-10">
            @csrf
            @method('PUT') <div>
                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ชื่อสินค้า / ไอดีเกม</label>
                <input type="text" name="name" value="{{ $product->name }}" required class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all font-medium text-slate-800">
            </div>

            <div>
                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">รายละเอียดสั้นๆ</label>
                <input type="text" name="description" value="{{ $product->description }}" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all font-medium text-slate-800">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ราคา (บาท)</label>
                    <input type="number" name="price" value="{{ $product->price }}" required min="0" class="w-full mt-1.5 px-4 py-3 bg-amber-50/50 border border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 font-black text-amber-600 transition-all text-lg">
                </div>
                <div>
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">จำนวนสต๊อก</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required min="0" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all font-medium text-slate-800">
                </div>
            </div>

            <div>
                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">หมวดหมู่สินค้า</label>
                <select name="category_id" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all font-medium text-slate-800">
                    <option value="">-- ไม่ระบุหมวดหมู่ --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">สถานะ HOT?</label>
                    <select name="is_hot" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all font-medium text-slate-800">
                        <option value="0" {{ !$product->is_hot ? 'selected' : '' }}>ปกติ</option>
                        <option value="1" {{ $product->is_hot ? 'selected' : '' }}>ใช่ (ติดป้าย HOT)</option>
                    </select>
                </div>
                <div>
                    <label class="text-[11px] font-black text-esv-primary uppercase tracking-widest ml-1">การแสดงผลหน้าเว็บ</label>
                    <select name="is_visible" class="w-full mt-1.5 px-4 py-3 bg-purple-50 border border-purple-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-bold text-esv-primary">
                        <option value="1" {{ $product->is_visible ? 'selected' : '' }}>แสดงขายปกติ</option>
                        <option value="0" {{ !$product->is_visible ? 'selected' : '' }}>ซ่อน (ใช้สุ่มเท่านั้น)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">รูป/ไอคอน (URL)</label>
                <input type="text" name="icon" value="{{ $product->icon }}" placeholder="ใส่ Link รูปภาพ" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-400/30 focus:border-amber-400 transition-all text-xs font-mono">

                @if(filter_var($product->icon, FILTER_VALIDATE_URL))
                    <div class="mt-4 flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <img src="{{ $product->icon }}" class="w-16 h-16 rounded-xl object-cover shadow-sm border border-slate-200">
                        <span class="text-xs font-bold text-slate-400 uppercase">รูปปัจจุบัน</span>
                    </div>
                @endif
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-4 rounded-xl font-black uppercase tracking-wider mt-6 hover:shadow-[0_10px_20px_rgba(245,158,11,0.3)] transition-all shadow-md flex items-center justify-center gap-2 skew-x-[-5deg] group">
                <span class="skew-x-[5deg] flex items-center gap-2 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    บันทึกการแก้ไข
                </span>
            </button>
        </form>

    </div>
</div>
@endsection
