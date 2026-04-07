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

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-display font-black text-slate-800">ระบบบริหารกาชาปอง</h2>
                        <p class="text-slate-500 font-medium mt-1">สร้างตู้สุ่ม เพิ่มของรางวัล และปรับเรทการออก (Weight)</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-6 lg:p-8 mb-10">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-100 pb-4">
                    <div class="bg-esv-primary/10 p-2 rounded-lg text-esv-primary">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">สร้างตู้สุ่มใหม่</h3>
                </div>

                <form action="{{ route('admin.gacha.create_box') }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-1">
                        <label class="text-sm font-bold text-slate-700">รูปปกตู้ (URL)</label>
                        <input type="text" name="icon" placeholder="ใส่ลิงก์รูป" class="w-full mt-1.5 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary text-xs transition-colors">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-bold text-slate-700">ชื่อตู้สุ่ม</label>
                        <input type="text" name="name" required placeholder="เช่น กล่อง VIP S-Class" class="w-full mt-1.5 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <label class="text-sm font-bold text-slate-700">ราคา (บาท)</label>
                        <input type="number" name="price" required min="1" class="w-full mt-1.5 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary font-bold text-esv-primary transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <label class="text-sm font-bold text-slate-700">Pity (การันตี)</label>
                        <input type="number" name="pity_limit" required min="1" value="50" class="w-full mt-1.5 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                    </div>
                    <div class="md:col-span-1">
                        <button type="submit" class="w-full bg-slate-800 text-white py-2.5 rounded-xl font-bold hover:bg-black transition-colors shadow-md">
                            สร้างตู้เลย!
                        </button>
                    </div>
                </form>
            </div>

            @foreach($boxes as $box)
            <div class="bg-white rounded-[2rem] shadow-lg mb-10 overflow-hidden border border-slate-100">

                <div class="bg-slate-900 p-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

                    <div class="flex items-center gap-4 relative z-10">
                        @if(filter_var($box->icon, FILTER_VALIDATE_URL))
                            <img src="{{ $box->icon }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-white/20 shadow-md">
                        @else
                            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center font-bold text-xl border-2 border-white/20 text-white/50 shadow-md">IMG</div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-yellow-400">{{ $box->name }}</h3>
                            <p class="text-sm text-slate-300 mt-1">ราคาสุ่ม: ฿{{ number_format($box->price) }} | Weight รวมตู้: <span id="total-w-{{ $box->id }}">{{ $box->items->sum('weight') }}</span></p>
                        </div>
                    </div>

                    <div class="relative z-10 text-sm bg-white/10 px-5 py-3 rounded-xl border border-white/10 flex items-center gap-2 font-medium backdrop-blur-sm">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        การันตี Pity: <span class="text-yellow-400 font-bold text-lg">{{ $box->pity_limit }}</span> ครั้ง
                    </div>
                </div>

                <div class="p-6 lg:p-8 grid grid-cols-1 xl:grid-cols-3 gap-8">

                    <div class="xl:col-span-1 bg-slate-50 p-6 rounded-2xl border border-slate-200 h-fit">
                        <div class="flex items-center gap-2 mb-4 border-b border-slate-200 pb-2">
                            <svg class="w-5 h-5 text-esv-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <h4 class="font-bold text-slate-800">เพิ่มของรางวัลลงตู้</h4>
                        </div>

                        <form action="{{ route('admin.gacha.add_item') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="random_box_id" value="{{ $box->id }}">

                            <div>
                                <label class="text-sm font-bold text-slate-700">เลือกสินค้า/ไอดีเกม</label>
                                <select name="product_id" class="w-full mt-1.5 px-3 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                                    <option value="">-- เกลือ (ไม่ได้ของ) --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (สต๊อก: {{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-700">ระดับความแรร์ (Rarity)</label>
                                <select name="rarity" class="w-full mt-1.5 px-3 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors">
                                    <option value="common">Common (ทั่วไป)</option>
                                    <option value="epic">Epic (หายาก)</option>
                                    <option value="legendary">Legendary (ตำนาน/แรร์สุด)</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-700">ลิงก์รูปภาพ (โชว์ในวงล้อ)</label>
                                <input type="text" name="image_url" placeholder="https://..." class="w-full mt-1.5 px-3 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-esv-primary transition-colors text-xs">
                            </div>

                            <div>
                                <label class="text-sm font-bold text-slate-700">โอกาสออก (Weight)</label>
                                <input type="number" name="weight" required min="1" value="10" class="w-full mt-1.5 px-3 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-esv-primary text-center font-bold text-lg text-esv-primary transition-colors">
                            </div>

                            <button type="submit" class="w-full bg-esv-primary text-white py-3 rounded-xl font-bold hover:bg-purple-800 transition-colors shadow-md mt-2">
                                ยัดลงตู้เลย!
                            </button>
                        </form>
                    </div>

                    <div class="xl:col-span-2 overflow-x-auto">
                        <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            <h4 class="font-bold text-slate-800">ปรับเรท และสถิติการออก (Analytics)</h4>
                        </div>

                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-slate-500 border-b-2 border-slate-100">
                                    <th class="py-3 px-4 text-left min-w-[180px]">ของรางวัล</th>
                                    <th class="text-center px-2">รูปภาพ</th>
                                    <th class="text-center px-2">น้ำหนัก (Weight)</th>
                                    <th class="text-center px-2">ตั้งไว้ (%)</th>
                                    <th class="text-center px-2 min-w-[100px]">ออกจริง (Actual)</th>
                                    <th class="text-center px-2">เปิดใช้งาน</th>
                                    <th class="text-center px-4">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php $totalBoxWeight = $box->items->where('is_active', true)->sum('weight'); @endphp

                                @forelse($box->items as $item)
                                @php
                                    $stat = App\Models\DropStat::where('random_item_id', $item->id)->first();
                                    $actualPct = ($stat && $stat->total_attempts > 0) ? ($stat->total_drops / $stat->total_attempts) * 100 : 0;
                                    $expectedPct = ($item->is_active && $totalBoxWeight > 0) ? ($item->weight / $totalBoxWeight) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors {{ !$item->is_active ? 'opacity-50 grayscale' : '' }}">
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-slate-800 text-base">{{ $item->product->name ?? 'เกลือ (ไม่ได้ของ)' }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-1 bg-slate-100 inline-block px-2 py-0.5 rounded">{{ $item->rarity }}</div>
                                    </td>

                                    <form action="{{ route('admin.gacha.update_item', $item->id) }}" method="POST">
                                        @csrf
                                        <td class="text-center px-2">
                                            <input type="text" name="image_url" value="{{ $item->image_url }}" placeholder="URL รูป" class="w-24 text-[10px] border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-esv-primary transition-colors bg-white">
                                        </td>
                                        <td class="text-center px-2">
                                            <input type="number" name="weight" value="{{ $item->weight }}" class="w-20 text-center border border-slate-300 rounded-lg p-2 font-bold text-esv-primary focus:ring-2 focus:ring-esv-primary transition-colors bg-white">
                                        </td>
                                        <td class="text-center font-black text-slate-500 text-lg">{{ number_format($expectedPct, 2) }}%</td>
                                        <td class="text-center px-2">
                                            <div class="text-[11px] mb-1 font-bold {{ $actualPct > $expectedPct ? 'text-red-500' : 'text-green-600' }}">
                                                {{ number_format($actualPct, 2) }}%
                                            </div>
                                            <div class="w-full max-w-[100px] mx-auto bg-slate-200 h-1.5 rounded-full overflow-hidden">
                                                <div class="bg-{{ $actualPct > $expectedPct ? 'red' : 'green' }}-500 h-full" style="width: {{ min($actualPct, 100) }}%"></div>
                                            </div>
                                        </td>
                                        <td class="text-center px-2">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" onchange="this.form.submit()" {{ $item->is_active ? 'checked' : '' }}>
                                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-esv-primary"></div>
                                            </label>
                                        </td>
                                        <td class="text-center px-4">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <button type="submit" class="text-xs bg-slate-800 text-white px-3 py-2 rounded-lg hover:bg-black font-bold transition-colors">บันทึก</button>
                                                <a href="{{ route('admin.gacha.delete_item', $item->id) }}" onclick="return confirm('ถอดของชิ้นนี้ออกจากตู้?')" class="text-xs bg-red-50 text-red-600 border border-red-200 px-3 py-2 rounded-lg hover:bg-red-500 hover:text-white font-bold transition-colors">ลบ</a>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-slate-400">
                                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                        ยังไม่มีของรางวัลในตู้นี้ เริ่มเพิ่มของด้านซ้ายมือได้เลยครับ
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
