@extends('layouts.frontend')

@section('content')
<style>
    /* แอนิเมชันตอนสลับแท็บ */
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="max-w-2xl mx-auto px-4 pt-[120px] pb-20 relative">

    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-3/4 h-3/4 bg-blue-500 rounded-full mix-blend-multiply filter blur-[80px] opacity-10 pointer-events-none"></div>

    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] p-6 md:p-10 border border-slate-100 relative z-10">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 mb-4 shadow-sm border border-blue-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <h2 class="text-2xl md:text-3xl font-display font-black text-slate-800 mb-2">ระบบเติมเงินอัตโนมัติ</h2>
            <p class="text-slate-500 text-sm">สะดวก รวดเร็ว ปลอดภัย รองรับทุกธนาคาร</p>
        </div>

        <div class="bg-slate-100/80 p-1.5 rounded-2xl grid grid-cols-3 gap-1 mb-8">
            <button onclick="switchTab('promptpay', this)" class="tab-btn active bg-white shadow-sm text-blue-700 py-3 rounded-xl font-bold flex flex-col items-center justify-center gap-1 transition-all">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                <span class="text-[11px] md:text-xs">พร้อมเพย์</span>
            </button>
            <button onclick="switchTab('wallet', this)" class="tab-btn text-slate-500 hover:text-slate-700 py-3 rounded-xl font-bold flex flex-col items-center justify-center gap-1 transition-all">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                <span class="text-[11px] md:text-xs">วอเลท</span>
            </button>
            <button onclick="switchTab('redeem', this)" class="tab-btn text-slate-500 hover:text-slate-700 py-3 rounded-xl font-bold flex flex-col items-center justify-center gap-1 transition-all">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                <span class="text-[11px] md:text-xs">โค้ดเติมเงิน</span>
            </button>
        </div>

        <div id="tab-promptpay" class="tab-content active">
            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5 mb-8 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Kasikornbank_Logo.svg/1024px-Kasikornbank_Logo.svg.png" class="w-7 h-7 object-contain">
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">พร้อมเพย์ (PromptPay)</h3>
                    <p class="text-slate-500 text-sm">เบอร์รับเงิน: 0909324097</p>
                </div>
            </div>

            <div id="qr-container" class="hidden text-center mb-8 bg-slate-50 py-6 rounded-2xl border border-slate-200">
                <div class="bg-white p-3 rounded-2xl shadow-sm inline-block border border-slate-100 mb-3">
                    <img id="qr-image" src="" alt="QR Code" class="w-40 h-40 object-contain">
                </div>
                <p class="text-sm text-slate-500">ยอดชำระเงิน</p>
                <p class="text-2xl font-bold text-blue-700">฿ <span id="show-amount">0.00</span></p>
            </div>

            <form action="{{ route('topup.slip') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="method" value="promptpay">

                <div class="mb-5">
                    <label class="block text-sm font-bold text-slate-700 mb-2">ระบุจำนวนเงิน (บาท) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" min="0.01" step="0.01" required placeholder="เช่น 150.50" oninput="generateQR(this.value)" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 font-bold text-lg transition-colors">
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-2">แนบสลิปโอนเงิน <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="file" name="slip" id="slip-promptpay" required accept="image/*" onchange="document.getElementById('file-name-pp').innerText = this.files[0] ? this.files[0].name : 'คลิกเพื่อเลือกไฟล์สลิป'" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="w-full px-4 py-4 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center gap-2 text-slate-500 hover:border-blue-500 hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            <span id="file-name-pp" class="font-medium text-sm">คลิกเพื่อเลือกไฟล์สลิป</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-800 shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    แจ้งโอนเงิน
                </button>
            </form>
        </div>

        <div id="tab-wallet" class="tab-content">
            <div class="bg-orange-50/50 border border-orange-100 rounded-2xl p-5 mb-8 flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0">
                    <span class="text-2xl">📱</span>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">TrueMoney Wallet</h3>
                    <p class="text-slate-500 text-sm">เบอร์รับเงิน: 081-234-5678</p>
                </div>
            </div>

            <form action="{{ route('topup.slip') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="method" value="truemoney">

                <div class="mb-5">
                    <label class="block text-sm font-bold text-slate-700 mb-2">ระบุจำนวนเงิน (บาท) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" min="0.01" step="0.01" required placeholder="เช่น 150.50" oninput="generateQR(this.value)" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 font-bold text-lg transition-colors">
                </div>

                <div class="mb-8 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">เลขอ้างอิง 14 หลัก (ถ้ามี)</label>
                        <input type="text" name="ref_code" placeholder="เช่น 50001234567890" class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-orange-500 bg-slate-50/50 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">แนบสลิป <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="file" name="slip" id="slip-wallet" required accept="image/*" onchange="document.getElementById('file-name-wl').innerText = this.files[0] ? this.files[0].name : 'คลิกเพื่อเลือกไฟล์สลิป'" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="w-full px-4 py-4 rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center gap-2 text-slate-500 hover:border-orange-500 hover:text-orange-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                <span id="file-name-wl" class="font-medium text-sm">คลิกเพื่อเลือกไฟล์สลิป</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white py-4 rounded-xl font-bold text-lg hover:bg-orange-600 shadow-md hover:shadow-lg transition-all">
                    แจ้งโอนเงิน TrueMoney
                </button>
            </form>
        </div>

        <div id="tab-redeem" class="tab-content">
            <div class="text-center mb-8 px-4 mt-6">
                <div class="w-16 h-16 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl">🎁</span>
                </div>
                <h3 class="font-bold text-slate-800 text-lg mb-1">มีโค้ดเติมเงินใช่ไหม?</h3>
                <p class="text-slate-500 text-sm">นำรหัส 16 หลักมากรอกด้านล่างเพื่อรับเครดิตทันที</p>
            </div>

            <form action="{{ route('topup.redeem') }}" method="POST">
                @csrf
                <div class="mb-8">
                    <input type="text" name="code" required placeholder="ESV-XXXX-XXXX" class="w-full px-4 py-4 rounded-xl border-2 border-slate-200 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-600 uppercase text-center font-mono font-bold text-xl bg-slate-50 text-purple-700 placeholder:text-sm placeholder:font-sans placeholder:tracking-normal transition-all">
                </div>

                <button type="submit" class="w-full bg-[#401268] text-white py-4 rounded-xl font-bold text-lg hover:bg-purple-900 shadow-md hover:shadow-lg transition-all">
                    ใช้งานโค้ด (Redeem)
                </button>
            </form>
        </div>

    </div>

    <div class="mt-8 text-center">
        <a href="{{ url('/') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">← กลับหน้าแรก</a>
    </div>
</div>

<script>
    // ฟังก์ชันสลับแท็บ (ให้เปลี่ยนสีพื้นหลังและตัวหนังสือ)
    function switchTab(tabId, btnElement) {
        // ซ่อนเนื้อหาทั้งหมด
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));

        // ล้างสไตล์ปุ่มทั้งหมดให้เป็นสีเทา
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('active', 'bg-white', 'shadow-sm', 'text-blue-700');
            el.classList.add('text-slate-500');
        });

        // แสดงเนื้อหาแท็บที่เลือก
        document.getElementById('tab-' + tabId).classList.add('active');

        // ใส่สไตล์ให้ปุ่มที่โดนกด (เปลี่ยนเป็นสีขาว ตัวหนังสือสีน้ำเงิน)
        btnElement.classList.remove('text-slate-500');
        btnElement.classList.add('active', 'bg-white', 'shadow-sm', 'text-blue-700');
    }

    // ฟังก์ชันสร้าง QR Code
    let qrTimeout;
    function generateQR(amount) {
        clearTimeout(qrTimeout);
        const qrContainer = document.getElementById('qr-container');
        const qrImage = document.getElementById('qr-image');
        const showAmount = document.getElementById('show-amount');

        if (!amount || amount <= 0) {
            qrContainer.classList.add('hidden');
            return;
        }

        qrTimeout = setTimeout(() => {
            fetch(`/api/promptpay/qr?amount=${amount}`)
                .then(res => res.json())
                .then(data => {
                    if(data.qr_url) {
                        qrImage.src = data.qr_url;
                        showAmount.innerText = data.amount;
                        qrContainer.classList.remove('hidden');
                    }
                })
                .catch(err => console.error('สร้าง QR ล้มเหลว', err));
        }, 500);
    }
</script>
@endsection
