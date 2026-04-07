@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 pt-[120px] pb-20 relative z-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-display font-black text-slate-800 uppercase italic">Drag & Drop <span class="text-esv-primary">Sort</span></h2>
            <p class="text-slate-500 font-medium mt-1">คลิกค้างที่สินค้าแล้วลากสลับตำแหน่งได้เลย (ระบบบันทึกอัตโนมัติ)</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors">กลับหน้าแอดมิน</a>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200">
        <ul id="sortable-list" class="space-y-3">
            @foreach($products as $product)
                <li data-id="{{ $product->id }}" class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl cursor-grab active:cursor-grabbing hover:border-esv-primary/50 transition-colors group">

                    <div class="text-slate-400 group-hover:text-esv-primary transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" /></svg>
                    </div>

                    <div class="w-12 h-12 bg-white rounded-xl overflow-hidden shadow-sm shrink-0 flex items-center justify-center">
                        @if(filter_var($product->icon, FILTER_VALIDATE_URL))
                            <img src="{{ $product->icon }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-[10px] text-slate-300 font-bold">NO IMG</span>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h4 class="font-black text-slate-800">{{ $product->name }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID: {{ $product->id }}</p>
                    </div>

                    <div class="text-esv-primary font-black italic">
                        ฿{{ number_format($product->price) }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.getElementById('sortable-list');

        new Sortable(list, {
            animation: 150, // ความพริ้วตอนสลับที่ (ms)
            ghostClass: 'opacity-50', // เอฟเฟกต์ตัวที่กำลังโดนจับลาก
            dragClass: 'shadow-2xl',

            // เมื่อปล่อยเมาส์ (วางเสร็จ)
            onEnd: function (evt) {
                // ดึง ID ของทุกแถวที่เรียงใหม่แล้ว มาใส่ Array
                let items = list.querySelectorAll('li');
                let newOrder = [];
                items.forEach(function(item) {
                    newOrder.push(item.getAttribute('data-id'));
                });

                // ส่งลำดับใหม่ไปให้ Laravel บันทึก (AJAX)
                fetch("{{ route('admin.products.update_order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: newOrder })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // โชว์ป๊อปอัพเล็กๆ มุมขวาบนว่าเซฟแล้ว ไม่ต้องกวนใจมาก
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'บันทึกตำแหน่งใหม่เรียบร้อย!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
