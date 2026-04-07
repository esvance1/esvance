<nav class="fixed top-0 w-full z-50 white-nav transition-all duration-300 border-b border-slate-200 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-[70px]">

            <a href="{{ url('/') }}" class="flex items-center gap-2 group shrink-0">
                <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-esv-primary to-purple-800 flex items-center justify-center font-display font-black text-white shadow-md group-hover:scale-105 transition-transform">
                    E
                </div>
                <span class="font-display font-black text-xl md:text-2xl tracking-tight text-esv-dark uppercase italic drop-shadow-sm">
                    Esvance<span class="text-esv-accent">Shop</span>
                </span>
            </a>

            <div class="flex items-center gap-2 md:gap-4">

                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-[10px] md:text-xs font-bold shadow-inner mr-1 md:mr-0">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-esv-primary animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span id="nav-clock" class="tracking-wider text-esv-primary font-mono font-black">--:--:--</span>
                </div>

                @auth
                    <div class="flex items-center gap-2 md:gap-4 ml-1 md:ml-2">

                        <div class="text-right hidden md:block bg-slate-50 border border-slate-200 px-4 py-1.5 rounded-xl shadow-inner">
                            <div class="text-[10px] text-slate-400 font-black uppercase tracking-wider">สวัสดี, {{ Auth::user()->name }}</div>
                            <div class="text-sm font-display font-black text-esv-primary leading-tight">฿ {{ number_format(Auth::user()->balance, 2) }}</div>
                        </div>

                        <div class="md:hidden flex items-center gap-1.5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg shadow-inner">
                            <svg class="w-4 h-4 text-esv-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-xs font-display font-black text-esv-primary leading-tight">{{ number_format(Auth::user()->balance, 0) }}</span>
                        </div>

                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="p-2 md:px-4 md:py-2 rounded-xl bg-slate-800 text-white border border-slate-700 text-sm font-bold hover:bg-black transition-all shadow-sm flex items-center gap-1.5" title="ระบบหลังบ้าน">
                                <svg class="w-4 h-4 md:w-4 md:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span class="hidden md:block">ระบบหลังบ้าน</span>
                            </a>
                        @endif

                        <a href="{{ url('/dashboard') }}" class="p-2 md:px-5 md:py-2 rounded-xl bg-esv-primary text-white text-sm font-bold shadow-md hover:bg-purple-800 transition-all flex items-center gap-2" title="ข้อมูลผู้ใช้">
                            <svg class="w-4 h-4 md:w-4 md:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            <span class="hidden md:block">ข้อมูลผู้ใช้</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="ml-0.5">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors" title="ออกจากระบบ">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            </button>
                        </form>

                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 md:px-6 md:py-2.5 rounded-xl bg-esv-primary text-white text-xs md:text-sm font-bold shadow-[0_4px_15px_rgba(107,33,168,0.3)] hover:bg-purple-800 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                        เข้าสู่ระบบ
                    </a>
                @endauth

            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateNavClock() {
            const now = new Date();
            // จัดรูปแบบเวลา
            const timeStr = now.toLocaleTimeString('th-TH', {
                hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
            });
            // จัดรูปแบบวันที่ (พ.ศ.)
            const dateStr = now.toLocaleDateString('th-TH', {
                day: 'numeric', month: 'short', year: 'numeric'
            });

            const clockEl = document.getElementById('nav-clock');
            if (clockEl) {
                // ซ่อนวันที่ในมือถือ โชว์แค่นาฬิกา / ในคอมโชว์เต็ม
                clockEl.innerHTML = `<span class="hidden md:inline text-slate-500 mr-1.5 font-sans">${dateStr}</span>${timeStr}`;
            }
        }

        // ให้อัปเดตทุกๆ 1 วินาที (1000ms)
        setInterval(updateNavClock, 1000);
        updateNavClock(); // เรียกครั้งแรกทันทีไม่ต้องรอ 1 วินาที
    });
</script>
