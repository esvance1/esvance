<footer class="bg-white border-t border-slate-200 pt-16 pb-8 mt-20 relative z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <div class="flex justify-center items-center gap-2 mb-6 opacity-60 hover:opacity-100 transition-opacity cursor-default">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-esv-primary to-purple-800 flex items-center justify-center font-display font-black text-white text-sm shadow-sm">E</div>
                <span class="font-display font-black text-xl text-slate-800 tracking-tight uppercase italic">Esvance<span class="text-esv-primary">Shop</span></span>
            </div>

            <p class="text-slate-500 text-xs md:text-sm font-medium max-w-md mx-auto leading-relaxed">
                ศูนย์รวมไอดีเกม eFootball ระดับพรีเมียม สุ่มกาชาปองเรทโปร่งใส จัดส่งไอดีอัตโนมัติ 24 ชั่วโมง
            </p>

            <div class="mt-10 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] font-bold text-slate-400">
                <p>© 2026 Esvance Shop. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-esv-primary transition-colors">เงื่อนไขการใช้งาน</a>
                    <a href="#" class="hover:text-esv-primary transition-colors">นโยบายความเป็นส่วนตัว</a>
                    <a href="#" class="hover:text-esv-primary transition-colors">ติดต่อเรา</a>
                </div>
            </div>

        </div>
    </footer>

    <div id="toast" class="fixed bottom-6 right-6 md:bottom-8 md:right-8 bg-white border border-slate-200 text-slate-700 px-5 py-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] transform translate-y-24 opacity-0 transition-all duration-300 z-[60] flex items-center gap-3">
        <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center text-green-500 shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        </div>
        <span id="toast-msg" class="text-sm font-bold">ทำรายการสำเร็จ</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
