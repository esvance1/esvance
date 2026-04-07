@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 pt-[120px] pb-20">

    <div class="text-center mb-12">
        <div class="w-20 h-20 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-4 text-esv-primary shadow-sm border border-slate-200">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h2 class="text-3xl md:text-4xl font-display font-black text-slate-800 tracking-wide">ตั้งค่าบัญชี</h2>
        <p class="text-slate-500 font-medium mt-2">ปรับแต่งข้อมูลส่วนตัว และความปลอดภัยของบัญชี</p>
    </div>

    <div class="space-y-8">

        <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>

            <h3 class="text-2xl font-bold text-slate-800 mb-2">ข้อมูลบัญชี</h3>
            <p class="text-sm text-slate-500 mb-6">อัปเดตชื่อผู้ใช้งานและอีเมลของคุณ</p>

            <form method="post" action="{{ route('profile.update') }}" class="max-w-xl space-y-5">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">ชื่อผู้ใช้งาน</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 transition-colors">
                    @error('name') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">อีเมล</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 transition-colors">
                    @error('email') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="px-8 py-3.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        บันทึกข้อมูล
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-sm text-green-600 font-bold flex items-center gap-1 animate-pulse">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            บันทึกสำเร็จ
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-purple-600"></div>

            <h3 class="text-2xl font-bold text-slate-800 mb-2">เปลี่ยนรหัสผ่าน</h3>
            <p class="text-sm text-slate-500 mb-6">ตั้งรหัสผ่านใหม่เพื่อความปลอดภัยของบัญชีคุณ</p>

            <form method="post" action="{{ route('password.update') }}" class="max-w-xl space-y-5">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">รหัสผ่านปัจจุบัน</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-slate-50 transition-colors">
                    @error('current_password', 'updatePassword') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">รหัสผ่านใหม่</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-slate-50 transition-colors">
                    @error('password', 'updatePassword') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-slate-50 transition-colors">
                    @error('password_confirmation', 'updatePassword') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="px-8 py-3.5 bg-purple-700 text-white font-bold rounded-xl hover:bg-purple-800 hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        อัปเดตรหัสผ่าน
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-sm text-green-600 font-bold flex items-center gap-1 animate-pulse">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            รหัสผ่านถูกเปลี่ยนแล้ว
                        </span>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-red-50/50 rounded-[2rem] border border-red-200 p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-red-500"></div>

            <h3 class="text-2xl font-bold text-red-600 mb-2">ลบบัญชีผู้ใช้ (Danger Zone)</h3>
            <p class="text-sm text-red-500 mb-6">หากลบบัญชีแล้ว ข้อมูลทุกอย่างรวมถึงแต้ม VIP และไอดีเกมที่ซื้อไปจะหายไปถาวร ไม่สามารถกู้คืนได้</p>

            <form method="post" action="{{ route('profile.destroy') }}" class="max-w-xl" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบบัญชี? (ข้อมูลทั้งหมดจะหายไปถาวร)');">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <label class="block text-sm font-bold text-red-700 mb-2">กรุณาใส่รหัสผ่านเพื่อยืนยันการลบบัญชี</label>
                    <input type="password" name="password" required placeholder="รหัสผ่านของคุณ" class="w-full px-4 py-3 rounded-xl border border-red-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white transition-colors">
                    @error('password', 'userDeletion') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    ยืนยันการลบบัญชี
                </button>
            </form>
        </div>

    </div>

    <div class="mt-12 text-center">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-800 text-white font-bold rounded-xl hover:bg-black transition shadow-md hover:-translate-y-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            กลับไปหน้าโปรไฟล์ VIP
        </a>
    </div>

</div>
@endsection
