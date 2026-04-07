@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 pt-[120px] pb-20">

    <div class="flex flex-col lg:flex-row gap-8">

        @include('admin.sidebar')

        <div class="flex-1">

            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-black text-slate-800">ภาพรวมระบบ (Overview)</h2>
                <div class="text-sm font-bold text-slate-500 bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-100 flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    ข้อมูลอัปเดตล่าสุด: <span id="last-update-time">{{ now()->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-[2rem] text-white shadow-[0_10px_20px_rgba(34,197,94,0.3)] relative overflow-hidden">
                    <svg class="w-24 h-24 absolute -right-6 -bottom-6 text-white opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-green-100 font-bold mb-1 text-sm uppercase tracking-wider">รายได้รวมทั้งหมด</p>
                    <h3 class="text-3xl font-black truncate" id="stat-revenue">฿{{ number_format($stats['revenue'], 2) }}</h3>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-[2rem] text-white shadow-[0_10px_20px_rgba(59,130,246,0.3)] relative overflow-hidden">
                    <svg class="w-24 h-24 absolute -right-6 -bottom-6 text-white opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <p class="text-blue-100 font-bold mb-1 text-sm uppercase tracking-wider">รายการขายทั้งหมด</p>
                    <h3 class="text-3xl font-black truncate" id="stat-orders">{{ number_format($stats['total_orders']) }} บิล</h3>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-[2rem] text-white shadow-[0_10px_20px_rgba(168,85,247,0.3)] relative overflow-hidden">
                    <svg class="w-24 h-24 absolute -right-6 -bottom-6 text-white opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    <p class="text-purple-100 font-bold mb-1 text-sm uppercase tracking-wider">สต๊อกไอดีคงเหลือ</p>
                    <h3 class="text-3xl font-black truncate" id="stat-stock">{{ number_format($stats['stock']) }} ชิ้น</h3>
                </div>

                <div class="bg-gradient-to-br from-orange-400 to-orange-500 p-6 rounded-[2rem] text-white shadow-[0_10px_20px_rgba(249,115,22,0.3)] relative overflow-hidden">
                    <svg class="w-24 h-24 absolute -right-6 -bottom-6 text-white opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <p class="text-orange-100 font-bold mb-1 text-sm uppercase tracking-wider">สมาชิกลงทะเบียน</p>
                    <h3 class="text-3xl font-black truncate" id="stat-users">{{ number_format($stats['users']) }} คน</h3>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-8">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">ประวัติการขายล่าสุด (10 รายการ)</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-slate-400 border-b-2 border-slate-100 uppercase tracking-wider text-[11px] font-black">
                                <th class="pb-3 pl-2">วันเวลา</th>
                                <th class="pb-3">ผู้ใช้ (User)</th>
                                <th class="pb-3">สินค้าที่ได้รับ</th>
                                <th class="pb-3 text-right pr-2">จำนวนเงิน</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="recent-orders-tbody">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-4 pl-2 text-slate-500 font-medium whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="py-4 font-bold text-slate-800">{{ $order->user->name ?? 'ไม่ระบุ' }}</td>
                                <td class="py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 text-purple-700 font-bold text-xs">
                                        {{ $order->product->name ?? 'สินค้าถูกลบ' }}
                                    </span>
                                </td>
                                <td class="py-4 text-right pr-2 font-black text-green-600">฿{{ number_format($order->price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400 font-bold">
                                    ยังไม่มีประวัติการขายในระบบครับ
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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // ฟังก์ชันอัปเดตเวลาเป็นภาษาไทย (พ.ศ. และเดือนแบบย่อ)
        function updateThaiTime() {
            const now = new Date();
            const thaiDate = now.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
            });
            const thaiTime = now.toLocaleTimeString('th-TH', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            document.getElementById('last-update-time').innerText = thaiDate + ' เวลา ' + thaiTime + ' น.';
        }

        // เรียกใช้ฟังก์ชันทันทีที่เปิดหน้าเว็บ เพื่อเปลี่ยนเวลาให้เป็นภาษาไทยตั้งแต่เริ่ม
        updateThaiTime();

        // อัปเดตข้อมูลทุกๆ 5 วินาที
        setInterval(async function() {
            try {
                const fetchUrl = '{{ route("admin.dashboard") }}?_t=' + new Date().getTime();
                const response = await fetch(fetchUrl);

                if (!response.ok) return;

                const html = await response.text();

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                if (doc.getElementById('stat-revenue')) {
                    document.getElementById('stat-revenue').innerHTML = doc.getElementById('stat-revenue').innerHTML;
                    document.getElementById('stat-orders').innerHTML = doc.getElementById('stat-orders').innerHTML;
                    document.getElementById('stat-stock').innerHTML = doc.getElementById('stat-stock').innerHTML;
                    document.getElementById('stat-users').innerHTML = doc.getElementById('stat-users').innerHTML;
                    document.getElementById('recent-orders-tbody').innerHTML = doc.getElementById('recent-orders-tbody').innerHTML;
                }

                // อัปเดตเวลาไทยทุกๆ ครั้งที่ดึงข้อมูลสำเร็จ
                updateThaiTime();

            } catch (error) {
                console.error("การดึงข้อมูล Real-time ขัดข้อง:", error);
            }
        }, 5000); // 5000 มิลลิวินาที = 5 วินาที

    });
</script>
@endsection
