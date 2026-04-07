@extends('layouts.frontend')

@section('content')
<div class="max-w-5xl mx-auto px-4 pt-[120px] pb-20 relative z-10">

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">

        <div class="bg-[#1e1b4b] relative overflow-hidden p-8 md:p-10">
            <div class="absolute top-6 right-6 md:top-8 md:right-8 z-20">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-bold transition-colors backdrop-blur-sm border border-white/10 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    กลับหน้าแรก
                </a>
            </div>

            <div class="absolute top-0 right-0 w-64 h-64 bg-esv-primary rounded-full blur-[100px] opacity-50 pointer-events-none translate-x-1/2 -translate-y-1/2"></div>
            <svg class="absolute -right-4 -bottom-4 w-40 h-40 text-white/5 -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>

            <div class="relative z-10 flex items-center gap-4 pr-24">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-esv-accent to-esv-primary flex items-center justify-center text-white shadow-lg shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl md:text-4xl font-display font-black text-white uppercase italic tracking-wide">
                        My <span class="text-esv-accent">Orders</span>
                    </h2>
                    <p class="text-purple-200 text-sm md:text-base font-medium mt-1">ประวัติการสั่งซื้อ เคลมไอดี และดึง OTP</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-slate-50/50 flex-1">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($orders->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-slate-200">
                    <div class="w-20 h-20 mx-auto bg-slate-100 rounded-full flex items-center justify-center text-slate-300 mb-4">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-display font-black text-slate-700">ยังไม่มีประวัติการสั่งซื้อ</h3>
                </div>
            @else
                <div class="space-y-5">
                    @foreach($orders as $order)
                    <div class="flex flex-col xl:flex-row items-center justify-between p-5 md:p-6 border border-slate-200 rounded-2xl bg-white shadow-sm hover:shadow-[0_10px_20px_rgba(107,33,168,0.1)] hover:border-esv-primary/30 transition-all group">

                        <div class="flex items-center gap-5 w-full xl:w-auto mb-5 xl:mb-0">
                            <div class="w-20 h-20 bg-slate-50 rounded-xl flex items-center justify-center shrink-0 border border-slate-100 overflow-hidden relative">
                                @if($order->product && filter_var($order->product->icon, FILTER_VALIDATE_URL))
                                    <img src="{{ $order->product->icon }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h4 class="font-display font-black text-slate-800 text-lg md:text-xl uppercase tracking-wide group-hover:text-esv-primary transition-colors leading-tight">
                                    {{ $order->product->name ?? 'สินค้านี้ถูกลบไปแล้ว' }}
                                </h4>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $order->created_at->timezone('Asia/Bangkok')->format('d/m/Y H:i') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">
                                        ID-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-end w-full xl:w-auto gap-3 pt-4 xl:pt-0 border-t xl:border-t-0 border-slate-100">

                            <button onclick="openOtpModal()" class="px-4 py-2 bg-blue-50 text-blue-600 border border-blue-200 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-600 hover:text-white transition-all flex items-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
                                ดึง OTP
                            </button>

                            @if(isset($order->api_claim_status) && $order->api_claim_status === 'PENDING')
                                <span class="px-4 py-2 bg-amber-50 text-amber-600 border border-amber-200 rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-1.5 shadow-sm cursor-help" title="แอดมินกำลังตรวจสอบคำขอของคุณ">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                    รอตรวจเคลม
                                </span>
                            @elseif(isset($order->api_claim_status) && in_array($order->api_claim_status, ['SUCCESS', 'REFUNDED']))
                                <span class="px-4 py-2 bg-green-50 text-green-600 border border-green-200 rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    เคลมสำเร็จแล้ว
                                </span>
                            @elseif(isset($order->api_claim_status) && $order->api_claim_status === 'FAILED')
                                <span class="px-4 py-2 bg-slate-100 text-slate-500 border border-slate-200 rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    เคลมไม่ผ่าน
                                </span>
                            @else
                                <button onclick="openClaimModal({{ $order->id }})" class="px-4 py-2 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-rose-600 hover:text-white transition-all flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    เคลมไอดี
                                </button>
                            @endif

                            <button data-user="{{ $order->account->game_username ?? 'N/A' }}" data-pass="{{ $order->account->game_password ?? 'N/A' }}" onclick="showAccountDetails(this)" class="px-5 py-2.5 bg-[#1e1b4b] text-white rounded-xl text-xs font-black uppercase tracking-wider shadow-md hover:bg-esv-primary hover:shadow-lg transition-all flex items-center gap-2 skew-x-[-10deg]">
                                <span class="skew-x-[10deg] flex items-center gap-2">
                                    ดูข้อมูลไอดี
                                </span>
                            </button>
                        </div>

                    </div>
                    @endforeach
                </div>

                @if($orders->hasPages())
                    <div class="mt-8 pt-6 border-t border-slate-200">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>

<form id="claimForm" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="reason" id="claimReasonInput">
</form>

<form id="otpForm" action="{{ route('tools.get_otp') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="type" id="otpTypeInput">
    <input type="hidden" name="email" id="otpEmailInput">
    <input type="hidden" name="refresh_token" id="otpRtInput">
    <input type="hidden" name="client_id" id="otpCiInput">
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ฟังก์ชัน 1: ดูข้อมูลไอดี (ของเดิม)
    function showAccountDetails(button) {
        let username = button.getAttribute('data-user');
        let password = button.getAttribute('data-pass');

        Swal.fire({
            title: 'ข้อมูลไอดีเกม',
            html: `
                <div class="text-left p-5 bg-[#f8fafc] rounded-2xl border border-slate-200 mt-2 shadow-inner relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-esv-primary"></div>
                    <div class="mb-4">
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">Username (ไอดี)</p>
                        <div class="bg-white px-4 py-2 rounded-lg border border-slate-200 font-mono text-lg font-black text-slate-800 break-all select-all">${username}</div>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">Password (รหัสผ่าน)</p>
                        <div class="bg-white px-4 py-2 rounded-lg border border-slate-200 font-mono text-lg font-black text-esv-primary break-all select-all">${password}</div>
                    </div>
                </div>
            `,
            icon: 'success',
            confirmButtonText: 'ปิดหน้าต่าง',
            customClass: {
                popup: 'rounded-3xl',
                title: 'font-display font-black text-2xl text-esv-dark',
                confirmButton: 'bg-esv-primary text-white font-bold rounded-xl px-8 py-3'
            }
        });
    }

    // ฟังก์ชัน 2: ระบบเคลมไอดี
    function openClaimModal(orderId) {
        Swal.fire({
            title: 'แจ้งปัญหา / เคลมไอดี',
            html: `
                <p class="text-sm text-slate-500 mb-4 font-medium">โปรดระบุปัญหาที่พบ แอดมินจะรีบตรวจสอบและดำเนินการเคลมให้ครับ (รองรับเฉพาะสินค้านำเข้า)</p>
                <textarea id="swal-claim-reason" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none font-medium text-sm h-28 resize-none" placeholder="เช่น รหัสผ่านไม่ถูกต้อง, ไอดีโดนแบน..."></textarea>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ส่งคำขอเคลม',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#e11d48',
            preConfirm: () => {
                const reason = document.getElementById('swal-claim-reason').value;
                if (!reason) {
                    Swal.showValidationMessage('กรุณาระบุเหตุผลด้วยครับ!');
                }
                return reason;
            },
            customClass: {
                popup: 'rounded-3xl',
                title: 'font-display font-black text-2xl text-slate-800',
                confirmButton: 'font-bold rounded-xl px-6',
                cancelButton: 'font-bold rounded-xl px-6'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งข้อมูลไปที่ Form
                document.getElementById('claimReasonInput').value = result.value;
                document.getElementById('claimForm').action = `/claim/order/${orderId}`;
                document.getElementById('claimForm').submit();
            }
        });
    }

    // ฟังก์ชัน 3: ระบบดึง OTP
    function openOtpModal() {
        Swal.fire({
            title: 'ระบบดึงรหัส OTP',
            html: `
                <p class="text-sm text-slate-500 mb-5 font-medium">เลือกแพลตฟอร์มที่ต้องการดึง OTP (ค้นหาย้อนหลัง 3 นาที)</p>

                <div class="space-y-4 text-left">
                    <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-blue-50 transition-colors">
                        <input type="radio" name="otp_type" value="netflix" class="w-5 h-5 text-blue-600 focus:ring-blue-500" checked onchange="toggleOtpFields()">
                        <span class="font-black text-slate-700 uppercase tracking-wide">Netflix (ใช้ Email)</span>
                    </label>

                    <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-orange-50 transition-colors">
                        <input type="radio" name="otp_type" value="rockstar" class="w-5 h-5 text-orange-500 focus:ring-orange-500" onchange="toggleOtpFields()">
                        <span class="font-black text-slate-700 uppercase tracking-wide">Rockstar Games</span>
                    </label>

                    <div id="netflix-fields" class="block space-y-2 mt-4">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">กรอกอีเมล (Email)</label>
                        <input type="email" id="swal-otp-email" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 font-medium text-sm" placeholder="example@gmail.com">
                    </div>

                    <div id="rockstar-fields" class="hidden space-y-3 mt-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Refresh Token</label>
                            <input type="text" id="swal-otp-rt" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-500 font-medium text-sm" placeholder="ใส่ Refresh Token">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Client ID</label>
                            <input type="text" id="swal-otp-ci" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-orange-500 font-medium text-sm" placeholder="ใส่ Client ID">
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'ดึง OTP เลย!',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#2563eb',
            preConfirm: () => {
                const type = document.querySelector('input[name="otp_type"]:checked').value;
                if (type === 'netflix') {
                    const email = document.getElementById('swal-otp-email').value;
                    if (!email) Swal.showValidationMessage('กรุณากรอกอีเมลครับ');
                    return { type, email };
                } else {
                    const rt = document.getElementById('swal-otp-rt').value;
                    const ci = document.getElementById('swal-otp-ci').value;
                    if (!rt || !ci) Swal.showValidationMessage('กรุณากรอกข้อมูลให้ครบถ้วนครับ');
                    return { type, refresh_token: rt, client_id: ci };
                }
            },
            customClass: { popup: 'rounded-3xl', title: 'font-display font-black text-2xl text-slate-800', confirmButton: 'font-bold rounded-xl px-6', cancelButton: 'font-bold rounded-xl px-6' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('otpTypeInput').value = result.value.type;
                if (result.value.type === 'netflix') {
                    document.getElementById('otpEmailInput').value = result.value.email;
                } else {
                    document.getElementById('otpRtInput').value = result.value.refresh_token;
                    document.getElementById('otpCiInput').value = result.value.client_id;
                }

                // โชว์ Loading สวยๆ ตอนรอ
                Swal.fire({ title: 'กำลังค้นหา OTP...', html: 'กรุณารอสักครู่ ระบบกำลังค้นหาในอีเมล', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
                document.getElementById('otpForm').submit();
            }
        });
    }

    // สลับฟอร์ม OTP
    function toggleOtpFields() {
        const type = document.querySelector('input[name="otp_type"]:checked').value;
        if (type === 'netflix') {
            document.getElementById('netflix-fields').classList.remove('hidden');
            document.getElementById('rockstar-fields').classList.add('hidden');
        } else {
            document.getElementById('netflix-fields').classList.add('hidden');
            document.getElementById('rockstar-fields').classList.remove('hidden');
        }
    }
</script>
@endpush
