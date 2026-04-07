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

            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-esv-primary to-purple-800 text-white rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-display font-black text-slate-800 italic uppercase tracking-wide">Product <span class="text-esv-primary">Manager</span></h2>
                    <p class="text-slate-500 font-medium mt-1">เพิ่ม แก้ไข ลบ และซ่อน/แสดงสต๊อกสินค้าในระบบ</p>
                </div>
            </div>

            <div class="flex flex-col gap-8">

                <div class="bg-white rounded-[2rem] shadow-[0_10px_30px_rgba(107,33,168,0.05)] border border-slate-200 p-6 lg:p-8">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="bg-esv-primary/10 p-2.5 rounded-xl text-esv-primary">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        <h3 class="text-xl font-display font-black text-slate-800">เพิ่มสินค้าใหม่</h3>
                    </div>

                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="md:col-span-2 lg:col-span-1">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ชื่อสินค้า / ไอดีเกม</label>
                                <input type="text" name="name" required placeholder="เช่น บัญชี PES สายฟรี" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-medium">
                            </div>

                            <div class="md:col-span-2 lg:col-span-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">รายละเอียดสั้นๆ</label>
                                <input type="text" name="description" placeholder="บอกจุดเด่นของสินค้า" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-medium">
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ราคา (บาท)</label>
                                <input type="number" name="price" required min="0" placeholder="0" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary font-black text-esv-primary transition-all">
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">จำนวนสต๊อกเริ่มต้น</label>
                                <input type="number" name="stock" required min="1" value="1" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-medium">
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">หมวดหมู่สินค้า</label>
                                <select name="category_id" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-medium">
                                    <option value="">-- ไม่ระบุหมวดหมู่ --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">สถานะ HOT?</label>
                                <select name="is_hot" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-medium">
                                    <option value="0">ปกติ</option>
                                    <option value="1">ใช่ (ติดป้าย HOT)</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-esv-primary uppercase tracking-widest ml-1">การแสดงผล</label>
                                <select name="is_visible" class="w-full mt-1.5 px-4 py-3 bg-purple-50 border border-purple-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all font-bold text-esv-primary">
                                    <option value="1">แสดงขายปกติ</option>
                                    <option value="0">ซ่อน (ใช้สุ่มเท่านั้น)</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">รูป/ไอคอน (URL)</label>
                                <input type="text" name="icon" placeholder="ใส่ Link รูปภาพ" class="w-full mt-1.5 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-esv-primary/30 focus:border-esv-primary transition-all text-xs font-mono">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="w-full md:w-auto px-8 bg-[#1e1b4b] text-white py-3.5 rounded-xl font-black uppercase tracking-wider hover:bg-esv-primary transition-all shadow-lg flex items-center justify-center gap-2 skew-x-[-5deg] group">
                                <span class="skew-x-[5deg] flex items-center gap-2 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                                    บันทึกสินค้า
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-[2rem] shadow-[0_10px_30px_rgba(107,33,168,0.05)] border border-slate-200 p-6 lg:p-8 overflow-hidden">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                        <div class="bg-esv-accent/10 p-2.5 rounded-xl text-esv-accent">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                        </div>
                        <h3 class="text-xl font-display font-black text-slate-800">รายการสินค้าในระบบ</h3>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar pb-4">
                        <table class="w-full text-sm text-left whitespace-nowrap">
                            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
                                <tr class="uppercase tracking-wider text-[10px] font-black">
                                    <th class="px-4 py-4 rounded-tl-xl w-16">รูป/ไอคอน</th>
                                    <th class="px-4 py-4 min-w-[250px]">ข้อมูลสินค้า</th>
                                    <th class="px-4 py-4 text-center w-32">สต๊อก</th>
                                    <th class="px-4 py-4 text-center w-32">สถานะการขาย</th>
                                    <th class="px-4 py-4 text-center rounded-tr-xl w-32">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($products as $product)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-4 py-4">
                                        @if(filter_var($product->icon, FILTER_VALIDATE_URL))
                                            <img src="{{ $product->icon }}" class="w-12 h-12 object-cover rounded-xl shadow-sm border-2 border-white">
                                        @else
                                            <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center font-black text-[10px] border-2 border-white shadow-sm">IMG</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-black text-slate-800 text-base leading-tight mb-1 whitespace-normal line-clamp-2">{{ $product->name }}</div>
                                        <div class="text-esv-primary font-black italic">฿{{ number_format($product->price) }}</div>
                                        @if($product->is_hot)
                                            <span class="inline-block mt-1 bg-red-100 text-red-600 px-2 py-0.5 rounded text-[9px] font-black tracking-widest uppercase">HOT Item</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-col gap-1 items-center">
                                            <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-md text-[10px] font-bold border border-blue-100 w-full max-w-[80px] text-center">
                                                ขาย: {{ $product->stock }}
                                            </span>
                                            <span class="bg-purple-50 text-purple-600 px-2.5 py-1 rounded-md text-[10px] font-bold border border-purple-100 w-full max-w-[80px] text-center">
                                                สุ่ม: {{ $product->stock_gacha ?? 0 }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($product->is_visible ?? true)
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black tracking-wide border border-green-200">
                                                <span class="inline-block w-1.5 h-1.5 bg-green-500 rounded-full mr-1 animate-pulse"></span> แสดงขาย
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-[10px] font-black tracking-wide border border-slate-200">
                                                ซ่อน (ตู้สุ่ม)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white flex items-center justify-center transition-all shadow-sm hover:scale-110" title="แก้ไข">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </a>

                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" id="delete-form-{{ $product->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm hover:scale-110" title="ลบสินค้า">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-3 border border-slate-100">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold">ยังไม่มีสินค้าในระบบครับ</p>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            html: `คุณแน่ใจหรือไม่ที่จะลบสินค้า <b class="text-slate-800">"${name}"</b>?<br><span class="text-rose-500 text-sm">*การลบจะไม่สามารถกู้คืนได้</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก',
            customClass: {
                popup: 'rounded-3xl',
                title: 'font-display font-black text-slate-800',
                confirmButton: 'font-bold rounded-xl px-6',
                cancelButton: 'font-bold rounded-xl px-6'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
