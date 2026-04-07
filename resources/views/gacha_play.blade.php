@extends('layouts.frontend')

@section('content')
<style>
    .wheel-container {
        position: relative;
        width: 320px;
        height: 320px;
        margin: 0 auto;
    }
    @media (min-width: 768px) {
        .wheel-container {
            width: 380px;
            height: 380px;
        }
    }
    .wheel {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 6px solid #ffffff; /* ขอบขาวคลีนๆ */
        box-shadow: 0 0 25px rgba(217, 70, 239, 0.4), inset 0 0 30px rgba(0,0,0,0.6); /* แสงนีออนม่วงสว่าง */
        position: relative;
        transition: transform 5s cubic-bezier(0.17, 0.67, 0.12, 0.99); /* แอนิเมชันหน่วงตอนจบ */
        transform: rotate(0deg);
        overflow: hidden;
    }
    .pointer {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 45px;
        height: 55px;
        z-index: 10;
        filter: drop-shadow(0 5px 8px rgba(0,0,0,0.5));
    }
    .wheel-center {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 60px; height: 60px;
        background: #ffffff;
        border-radius: 50%;
        border: 5px solid #d946ef; /* ขอบม่วงสว่าง */
        z-index: 5;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.1), 0 0 20px rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .wheel-center-inner {
        width: 24px; height: 24px;
        background: #6b21a8;
        border-radius: 50%;
    }
    /* แต่งป๊อปอัพ SweetAlert2 ให้เข้าธีม */
    .swal2-popup.custom-swal {
        border-radius: 1.5rem !important;
        padding: 2rem !important;
        border: 1px solid #e2e8f0 !important;
    }
    .swal2-confirm.custom-btn {
        background-color: #6b21a8 !important;
        border-radius: 0.75rem !important;
        font-weight: 900 !important;
        padding: 12px 30px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }
</style>

@php
    // คำนวณของรางวัลในตู้ (ถ้ามี product ให้เช็คสต็อก)
    $activeItems = $box->items->where('is_active', true)->values();
    $totalStock = 0;
    foreach($activeItems as $item) {
        if($item->product_id && $item->product) {
            $totalStock += $item->product->stock ?? 0;
        }
    }
    $isOutOfStock = $totalStock <= 0;
@endphp

<div class="max-w-4xl mx-auto px-4 pt-[120px] pb-20 text-center relative z-10">

    <div class="flex items-center justify-center gap-3 mb-2">
        @if(filter_var($box->icon, FILTER_VALIDATE_URL))
            <img src="{{ $box->icon }}" class="w-12 h-12 rounded-xl object-cover shadow-md border 2 border-slate-200">
        @else
            <div class="w-12 h-12 bg-esv-primary/10 text-esv-primary rounded-xl flex items-center justify-center shadow-sm border border-esv-primary/20">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            </div>
        @endif
        <h2 class="text-3xl md:text-4xl font-display font-black text-slate-800 uppercase italic tracking-wide">{{ $box->name }}</h2>
    </div>

    <div class="text-slate-600 mb-8 bg-white inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold border border-slate-200 shadow-sm text-sm md:text-base">
        <span class="flex items-center gap-1.5">
            <svg class="w-5 h-5 text-esv-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            ราคาสุ่ม: ฿{{ number_format($box->price) }}
        </span>
        <span class="text-slate-300 mx-1">|</span>
        <span class="text-esv-accent flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            อีก <span id="pityCount" class="text-lg md:text-xl font-black">{{ $remainingPity }}</span> ครั้งการันตี!
        </span>
    </div>

    <div class="bg-[#1e1b4b] p-10 md:p-14 rounded-[3rem] shadow-[0_20px_40px_rgba(107,33,168,0.2)] mb-10 relative overflow-hidden border border-slate-200">

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-esv-accent rounded-full blur-[100px] opacity-30 pointer-events-none"></div>

        <div class="wheel-container mb-10 relative z-10">
            <div class="pointer">
                <svg viewBox="0 0 24 24" class="w-full h-full drop-shadow-lg" style="fill: #d946ef; stroke: #ffffff; stroke-width: 1.5px;"><path d="M12 22 L4 14 H9 V2 H15 V14 H20 L12 22 Z"/></svg>
            </div>

            <div class="wheel-center">
                <div class="wheel-center-inner"></div>
            </div>

            @php
                $totalSlices = $activeItems->count();
                $sliceAngle = $totalSlices > 0 ? 360 / $totalSlices : 0;

                // ใช้สีม่วงเข้ม สลับ ม่วงหลักของเว็บ ดูพรีเมียมไม่เลอะเทอะ
                $colors = ['#1e1b4b', '#6b21a8'];
                $conicParts = [];
                $currentAngle = 0;
                foreach($activeItems as $idx => $item) {
                    $color = $colors[$idx % count($colors)];
                    $nextAngle = $currentAngle + $sliceAngle;
                    $conicParts[] = "$color {$currentAngle}deg {$nextAngle}deg";
                    $currentAngle = $nextAngle;
                }
                $conicStr = implode(', ', $conicParts);
            @endphp

            <div class="wheel" id="wheel" style="background: conic-gradient({{ $conicStr }});">
                @foreach($activeItems as $index => $item)
                    @php
                        // หามุมกึ่งกลางของช่อง เพื่อวางไอเทม
                        $angle = ($index * $sliceAngle) + ($sliceAngle / 2);
                    @endphp
                    <div class="absolute w-14 h-14 left-1/2 top-1/2 -ml-7 -mt-7 flex items-center justify-center flex-col drop-shadow-md z-0"
                         style="transform: rotate({{ $angle }}deg) translateY(-120px) rotate(-{{ $angle }}deg);">

                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" class="w-11 h-11 md:w-12 md:h-12 rounded-full object-cover border-2 border-white bg-white shadow-[0_0_10px_rgba(255,255,255,0.5)]">
                        @else
                            <div class="bg-white w-11 h-11 md:w-12 md:h-12 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-200">
                                @if($item->product_id)
                                    <svg class="w-6 h-6 text-esv-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                @else
                                    <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @if($isOutOfStock)
            <button disabled class="relative z-10 px-10 py-4 bg-slate-300 text-slate-500 text-sm md:text-base font-black uppercase tracking-widest rounded-xl shadow-none cursor-not-allowed border-2 border-slate-300">
                ของรางวัลหมดตู้แล้ว
            </button>
            <p class="text-rose-400 text-xs font-bold mt-3 relative z-10">ขออภัย ไอดีในตู้สุ่มนี้ถูกจับจองไปหมดแล้ว</p>
        @else
            <button id="spinBtn" onclick="playGacha()" class="relative z-10 px-12 py-4 bg-gradient-to-r from-esv-primary to-purple-800 text-white text-lg md:text-xl font-black uppercase tracking-wider skew-x-[-10deg] rounded-md shadow-[0_10px_20px_rgba(107,33,168,0.4)] hover:shadow-[0_15px_30px_rgba(107,33,168,0.6)] hover:-translate-y-1 transition-all group">
                <span class="skew-x-[10deg] flex items-center gap-2">
                    หมุนวงล้อ (฿{{ number_format($box->price) }})
                    <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </span>
            </button>
        @endif

    </div>

    <div class="mb-4 text-left border-l-4 border-esv-primary pl-3">
        <h3 class="font-display font-black text-slate-800 text-lg uppercase italic">Item <span class="text-esv-primary">List</span></h3>
        <p class="text-xs text-slate-500 font-bold">ของรางวัลที่มีโอกาสได้รับในตู้นี้</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        @foreach($activeItems as $item)
            <div class="bg-white p-3 md:p-4 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-esv-primary/30 transition-all flex items-center gap-3 group">
                @if($item->image_url)
                    <img src="{{ $item->image_url }}" class="w-10 h-10 md:w-12 md:h-12 rounded-full border-2 border-slate-100 object-cover shrink-0 group-hover:scale-110 transition-transform">
                @else
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-slate-50 flex items-center justify-center border-2 border-slate-100 shrink-0 group-hover:scale-110 transition-transform">
                        @if($item->product_id)
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-esv-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                        @else
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @endif
                    </div>
                @endif
                <div class="text-left overflow-hidden flex-1">
                    <div class="font-display font-black text-slate-800 text-xs md:text-sm truncate leading-tight">{{ $item->product->name ?? 'เกลือ (ไม่ได้รางวัล)' }}</div>
                    <div class="text-[9px] md:text-[10px] text-esv-primary font-bold uppercase tracking-widest mt-0.5">{{ $item->rarity }}</div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const boxId = {{ $box->id }};

    // โครงสร้างข้อมูลไอเทมในตู้ (ดึงลงมาเพื่อเช็คว่าช่องไหนคือเกลือ ช่องไหนคือของ)
    const wheelItems = @json($activeItems->map(function($item) {
        return [
            'id' => $item->id,
            'is_salt' => empty($item->product_id)
        ];
    }));

    const sliceAngle = {{ $sliceAngle }};
    let currentRotation = 0; // องศาปัจจุบันที่วงล้อค้างอยู่

    async function playGacha() {
        const btn = document.getElementById('spinBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <span class="skew-x-[10deg] flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                กำลังประมวลผล...
            </span>
        `;

        try {
            const response = await fetch(`/gacha/${boxId}/draw`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (!response.ok) { throw new Error('ระบบขัดข้อง'); }

            const data = await response.json();

            if(data.error || !data.status) {
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: data.error || data.message,
                    icon: 'warning',
                    customClass: { popup: 'custom-swal', confirmButton: 'custom-btn' }
                });
                resetButton();
                return;
            }

            // 🚨 อัปเดตตัวเลข Pity สดๆ
            document.getElementById('pityCount').innerText = data.remaining_pity;

            // 🎯 ระบบค้นหาเป้าหมายการหยุดที่แม่นยำ 100%
            let wonIndex = 0;

            if (data.is_salt) {
                const saltIndices = wheelItems.reduce((arr, item, index) => {
                    if(item.is_salt) arr.push(index);
                    return arr;
                }, []);

                if (saltIndices.length > 0) {
                    wonIndex = saltIndices[Math.floor(Math.random() * saltIndices.length)];
                }
            } else {
                wonIndex = wheelItems.findIndex(item => item.id === data.won_item_id);
                if (wonIndex === -1) wonIndex = 0; // กันพลาด
            }

            // 📐 สมการคำนวณองศาแบบสัมบูรณ์ (ไม่มีทางเพี้ยน)
            const targetDegreeOnCircle = 360 - ((wonIndex * sliceAngle) + (sliceAngle / 2));
            const currentDegreeOnCircle = currentRotation % 360;
            let degreeDifference = targetDegreeOnCircle - currentDegreeOnCircle;
            if (degreeDifference < 0) degreeDifference += 360;

            // 3. หมุนหลอก 6 รอบ (2160 องศา) + องศาที่ต้องไปหยุด เพื่อความลุ้น
            currentRotation += (360 * 6) + degreeDifference;

            const wheel = document.getElementById('wheel');
            wheel.style.transform = `rotate(${currentRotation}deg)`;

            // รอแอนิเมชันวงล้อจบ (5 วินาที) แล้วเด้งป๊อปอัพ
            setTimeout(() => {
                if(data.is_salt) {
                    Swal.fire({
                        title: 'อ๊ะ! คุณได้เกลือ',
                        text: data.message,
                        icon: 'error',
                        customClass: {
                            popup: 'custom-swal',
                            title: 'text-2xl font-display font-black text-slate-800 italic',
                            confirmButton: 'custom-btn'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'แจ็คพอตแตก!',
                        html: `
                            <p class="mb-4 text-slate-500 font-bold text-sm">คุณได้รับรางวัลสุดแรร์ ด้านล่างนี้คือข้อมูลไอดีของคุณ</p>
                            <div class="bg-slate-50 p-5 rounded-2xl text-left border border-slate-200 shadow-inner">
                                <div class="mb-3 border-b border-slate-200 pb-3">
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block mb-1">Username (ไอดี)</span>
                                    <span class="text-esv-primary font-mono font-black text-xl tracking-wide select-all">${data.username}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block mb-1">Password (รหัส)</span>
                                    <span class="text-esv-accent font-mono font-black text-xl tracking-wide select-all">${data.password}</span>
                                </div>
                            </div>
                            <p class="text-xs text-rose-500 mt-4 font-bold">*อย่าลืมเปลี่ยนรหัสผ่านทันที เพื่อความปลอดภัย!</p>
                        `,
                        icon: 'success',
                        customClass: {
                            popup: 'custom-swal',
                            title: 'text-3xl font-display font-black text-esv-primary italic uppercase',
                            confirmButton: 'custom-btn'
                        }
                    });
                }
                resetButton();
            }, 5100);

        } catch (err) {
            Swal.fire({
                title: 'เกิดข้อผิดพลาด!',
                text: 'การเชื่อมต่อมีปัญหา กรุณาลองใหม่',
                icon: 'error',
                customClass: { popup: 'custom-swal', confirmButton: 'custom-btn' }
            });
            resetButton();
        }

        function resetButton() {
            btn.disabled = false;
            btn.innerHTML = `
                <span class="skew-x-[10deg] flex items-center gap-2">
                    หมุนอีกครั้ง (฿{{ number_format($box->price) }})
                    <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </span>
            `;
        }
    }
</script>
@endsection
