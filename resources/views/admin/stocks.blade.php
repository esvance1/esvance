@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 pt-[120px] pb-20">

    <div class="flex flex-col lg:flex-row gap-8">
        @include('admin.sidebar')

        <div class="flex-1 overflow-hidden">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-8 flex items-center gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-display font-black text-slate-800">สต็อกไอดีเกม</h2>
                    <p class="text-slate-500 font-medium mt-1">นำเข้าข้อมูลไอดีแบบทีละเยอะๆ (Bulk Import) และดูสถานะไอดี</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 sticky top-[100px]">
                        <div class="flex items-center gap-2 mb-6 border-b border-slate-100 pb-4">
                            <div class="bg-esv-primary/10 p-2 rounded-lg text-esv-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">นำเข้าไอดี (Import)</h3>
                        </div>

                        <form action="{{ route('admin.stocks.import') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-sm font-bold text-slate-700">จุดประสงค์</label>
                                <select name="usage_type" required class="w-full mt-1.5 px-4 py-2.5 bg-blue-50 border border-blue-200 text-blue-700 font-bold rounded-xl focus:ring-2 focus:ring-blue-500 transition-colors">
                                    <option value="sale">🛒 สต็อกสำหรับขายหน้าเว็บ</option>
                                    <option value="gacha">🎲 สต็อกสำหรับลงตู้สุ่ม</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-bold text-slate-700">เลือกสินค้าที่จะเติมสต็อก</label>
                                <select name="product_id" required class="w-full mt-1.5 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                                    <option value="">-- เลือกสินค้า --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} (ขาย: {{ $product->stock }} | สุ่ม: {{ $product->stock_gacha }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <div class="flex justify-between items-end mb-1.5">
                                    <label class="text-sm font-bold text-slate-700">ข้อมูลไอดี (บรรทัดละ 1 ไอดี)</label>
                                    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded-md font-bold">รูปแบบ ID:Pass</span>
                                </div>
                                <textarea name="accounts_data" required rows="8" placeholder="username1:password123&#10;user2:pass456" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors font-mono text-sm leading-relaxed"></textarea>
                                <p class="text-[11px] text-slate-400 mt-2">💡 คั่นไอดีและรหัสผ่านด้วยเครื่องหมาย <b>: (โคลอน)</b> เท่านั้น</p>
                            </div>
                            <button type="submit" class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold mt-4 hover:bg-black transition-colors shadow-md">
                                เพิ่มเข้าสต็อก
                            </button>
                        </form>
                    </div>
                </div>

                <div class="xl:col-span-2">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr class="uppercase tracking-wider text-[11px] font-black">
                                    <th class="px-4 py-4 rounded-tl-xl">สินค้า</th>
                                    <th class="px-4 py-4 text-center">ประเภท</th>
                                    <th class="px-4 py-4">ไอดี (Username)</th>
                                    <th class="px-4 py-4 text-center">สถานะ</th>
                                    <th class="px-4 py-4 text-center rounded-tr-xl">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($accounts as $acc)
                                <tr class="hover:bg-slate-50/50 transition-colors {{ $acc->status == 'sold' ? 'opacity-50' : '' }}">
                                    <td class="px-4 py-4 font-bold text-esv-primary truncate max-w-[150px]">
                                        {{ $acc->product->name ?? 'สินค้าถูกลบ' }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($acc->usage_type == 'sale')
                                            <span class="bg-blue-50 text-blue-600 border border-blue-200 px-2 py-1 rounded-md text-[10px] font-bold">🛒 ขาย</span>
                                        @else
                                            <span class="bg-purple-50 text-purple-600 border border-purple-200 px-2 py-1 rounded-md text-[10px] font-bold">🎲 สุ่ม</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 font-mono font-bold text-slate-700">{{ $acc->game_username }}</td>
                                    <td class="px-4 py-4 text-center">
                                        @if($acc->status == 'available')
                                            <span class="bg-green-100 text-green-600 px-2.5 py-1 rounded-md text-[10px] font-bold shadow-sm">พร้อมขาย</span>
                                        @else
                                            <span class="bg-slate-200 text-slate-500 px-2.5 py-1 rounded-md text-[10px] font-bold shadow-sm">ขายแล้ว</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.stocks.delete', $acc->id) }}" onclick="return confirm('ลบไอดีนี้ออกจากระบบ?')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="py-10 text-center text-slate-400 font-bold">สต็อกว่างเปล่า</td></tr>
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
