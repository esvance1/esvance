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
                <div class="w-14 h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-display font-black text-slate-800">จัดการหมวดหมู่</h2>
                    <p class="text-slate-500 font-medium mt-1">แบ่งประเภทสินค้า เพื่อให้ลูกค้าค้นหาได้ง่ายขึ้น</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 sticky top-[100px]">
                        <div class="flex items-center gap-2 mb-6 border-b border-slate-100 pb-4">
                            <div class="bg-esv-primary/10 p-2 rounded-lg text-esv-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">เพิ่มหมวดหมู่ใหม่</h3>
                        </div>

                        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-sm font-bold text-slate-700">ชื่อหมวดหมู่</label>
                                <input type="text" name="name" required placeholder="เช่น ไอดีสายฟรี, แพ็กเกจ VIP" class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-700">รูปลิงก์ไอคอน (ถ้ามี)</label>
                                <input type="text" name="icon" placeholder="https://..." class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors text-xs">
                            </div>
                            <button type="submit" class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold mt-4 hover:bg-black transition-colors shadow-md">
                                บันทึกหมวดหมู่
                            </button>
                        </form>
                    </div>
                </div>

                <div class="xl:col-span-2">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr class="uppercase tracking-wider text-[11px] font-black">
                                    <th class="px-4 py-4 rounded-tl-xl w-16">ไอคอน</th>
                                    <th class="px-4 py-4">ชื่อหมวดหมู่</th>
                                    <th class="px-4 py-4 text-center">จำนวนสินค้า</th>
                                    <th class="px-4 py-4 text-center rounded-tr-xl">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($categories as $category)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-4">
                                        @if($category->icon)
                                            <img src="{{ $category->icon }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200 shadow-sm">
                                        @else
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 font-bold text-slate-800 text-base">{{ $category->name }}</td>
                                    <td class="px-4 py-4 text-center font-bold text-esv-primary bg-purple-50/50 rounded-lg">{{ $category->products_count }} ชิ้น</td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.categories.delete', $category->id) }}" onclick="return confirm('ลบหมวดหมู่นี้? (สินค้าในหมวดจะไม่ถูกลบ แต่จะไม่มีหมวดหมู่แทน)')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-10 text-center text-slate-400 font-bold">ยังไม่มีหมวดหมู่ครับ</td></tr>
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
