<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;
use App\Models\Account;
use App\Models\RandomBox;
use App\Models\RandomItem;
use App\Models\RateHistory;
use App\Models\DropStat;
use App\Models\DrawLog;
use App\Models\RedeemCode;
use App\Models\RedeemLog;
use App\Models\UserBoxStat;

/*
|--------------------------------------------------------------------------
| 🌍 โซน PUBLIC (ผู้ใช้งานทั่วไปเข้าถึงได้ ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/

Route::get('/', function (Illuminate\Http\Request $request) {
    // โหลดข้อมูลต่างๆ ตามปกติ
    $categories = App\Models\Category::all();

    $query = App\Models\Product::query();
    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }
    $products = $query->orderBy('sort_order', 'asc')->get();
    $boxes = App\Models\RandomBox::all();

    // 🚨 [เพิ่มใหม่] คำนวณสถิติจริงจากฐานข้อมูล
    $stats = [
        'users_count' => App\Models\User::count(),
        'total_stock' => App\Models\Product::sum('stock'),
        'total_sold' => App\Models\Order::count() // จำนวนบิลที่ซื้อ/สุ่มสำเร็จ
    ];

    return view('welcome', compact('products', 'boxes', 'categories', 'stats'));
});

// เปิดหน้ารายละเอียดสินค้า
Route::get('/product/{id}', function ($id) {
    // หาข้อมูลสินค้า ถ้าระบุว่าต้องมองเห็นได้ (is_visible) ถึงจะเปิดดูได้
    $product = \App\Models\Product::where('id', $id)
                ->where(function($query) {
                    $query->where('is_visible', 1)->orWhereNull('is_visible');
                })->firstOrFail();

    return view('product_detail', compact('product'));
})->name('product.show');

// ----------------------------------------
// API สำหรับรับยอดเงิน แล้วแปลงเป็นภาพ QR Code
// ----------------------------------------
Route::get('/api/promptpay/qr', function (Illuminate\Http\Request $request) {
    $amount = floatval($request->amount);
    $phone = "0909324097"; // 👈 เปลี่ยนเบอร์พร้อมเพย์รับเงินตรงนี้ได้เลย

    if ($amount <= 0) {
        return response()->json(['qr_url' => null]);
    }

    $pp = new PromptPayQR();
    $payload = $pp->generatePayload($phone, $amount);
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=" . urlencode($payload);

    return response()->json([
        'qr_url' => $qrUrl,
        'amount' => number_format($amount, 2)
    ]);
})->name('api.promptpay');


/*
|--------------------------------------------------------------------------
| 👤 โซน USER & AUTH (ต้องล็อกอินถึงจะใช้งานได้)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ==========================================
    // ระบบจัดการโปรไฟล์ & หน้าประวัติ
    // ==========================================
    Route::get('/dashboard', function () {
        $user = Illuminate\Support\Facades\Auth::user();

        // คำนวณระดับ VIP
        if ($user->points >= 10000) {
            $vip = 'Platinum'; $next = 'MAX'; $progress = 100;
        } elseif ($user->points >= 5000) {
            $vip = 'Gold'; $next = 10000; $progress = ($user->points / 10000) * 100;
        } elseif ($user->points >= 1000) {
            $vip = 'Silver'; $next = 5000; $progress = ($user->points / 5000) * 100;
        } else {
            $vip = 'Member'; $next = 1000; $progress = ($user->points / 1000) * 100;
        }

        if ($user->vip_level !== $vip) {
            $user->vip_level = $vip;
            $user->save();
        }

        $ordersCount = App\Models\Order::where('user_id', $user->id)->count();

        return view('profile_custom', compact('user', 'vip', 'next', 'progress', 'ordersCount'));
    })->middleware('verified')->name('dashboard');

    Route::get('/history', function () {
        $orders = App\Models\Order::with('product', 'account')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10);

        return view('history', compact('orders'));
    })->name('history');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // ระบบสั่งซื้อสินค้า & เคลม
    // ==========================================
    // 🚨 คำเตือน: อันนี้คือ Route ซื้อสินค้าตัวใหม่ (API)
    Route::post('/buy/product/{id}', function (\Illuminate\Http\Request $request, $id, \App\Services\WichxShopApi $api) {
        $user = auth()->user();
        $product = \App\Models\Product::findOrFail($id);

        if ($user->balance < $product->price) return back()->with('error', 'ยอดเงินไม่เพียงพอ กรุณาเติมเงินครับ!');

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $gameUsername = ''; $gamePassword = '';

            if ($product->is_api_product) {
                $apiResponse = $api->buyProduct($product->api_product_id, 1);
                if (!isset($apiResponse['success']) || !$apiResponse['success']) throw new \Exception('อ๊ะ! สินค้าต้นทางหมดชั่วคราว หรือระบบขัดข้อง: ' . ($apiResponse['message'] ?? ''));

                $apiData = $apiResponse['data'];
                $itemKey = isset($apiData[0]) ? $apiData[0]['key'] : ($apiData['key'] ?? 'No_Key_Found');

                if (strpos($itemKey, ':') !== false) {
                    $parts = explode(':', $itemKey, 2);
                    $gameUsername = $parts[0]; $gamePassword = $parts[1];
                } else {
                    $gameUsername = $itemKey; $gamePassword = 'API Auto Delivered';
                }
            } else {
                if ($product->stock <= 0) throw new \Exception('สินค้าหมดสต๊อกแล้วครับ!');

                $stockAccount = \App\Models\Account::where('product_id', $product->id)->where('is_sold', false)->first();
                if (!$stockAccount) throw new \Exception('ไอดีในระบบขัดข้อง ติดต่อแอดมินด่วนครับ');

                $gameUsername = $stockAccount->game_username; $gamePassword = $stockAccount->game_password;
                $stockAccount->update(['is_sold' => true]);
                $product->decrement('stock');
            }

            $user->decrement('balance', $product->price);
            $order = \App\Models\Order::create([
                'user_id' => $user->id, 'product_id' => $product->id, 'price' => $product->price,
                'api_order_id' => $product->is_api_product ? ($apiItem['id'] ?? null) : null,
                'api_claim_status' => 'NOT_CLAIMED'
            ]);

            \App\Models\Account::create([
                'order_id' => $order->id, 'game_username' => $gameUsername, 'game_password' => $gamePassword,
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return back()->with('success', 'สั่งซื้อสำเร็จ! ไปรับไอดีได้ที่หน้า "ประวัติการซื้อ" เลยครับ 🎮');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    })->name('buy.product');

    // 🚨 คำเตือน: อันนี้คือ Route ซื้อสินค้าตัวเก่า! (ควรลบหรือปิดไว้ถ้าไม่ได้ใช้แล้ว)
    Route::post('/buy/{product}', function (Request $request, Product $product) {
        $userId = Auth::id();
        return DB::transaction(function() use ($userId, $product) {
            $user = App\Models\User::lockForUpdate()->find($userId);
            if ($user->balance < $product->price) return back()->with('error', 'ยอดเงินไม่เพียงพอ กรุณาเติมเงินครับ!');
            $account = App\Models\Account::where('product_id', $product->id)->where('usage_type', 'sale')->where('status', 'available')->lockForUpdate()->first();
            if (!$account) return back()->with('error', 'ขออภัย สินค้านี้หมดสต๊อกแล้ว!');

            $user->balance -= $product->price; $user->points += $product->price; $user->save();
            $account->update(['status' => 'sold', 'sold_at' => now()]);
            $product->decrement('stock');

            Order::create(['user_id' => $user->id, 'product_id' => $product->id, 'account_id' => $account->id, 'price' => $product->price]);
            return back()->with('success', "สั่งซื้อสำเร็จ! ไอดี: {$account->game_username} | รหัสผ่าน: {$account->game_password}");
        });
    })->name('buy.product.old'); // เปลี่ยนชื่อ name ไม่ให้ซ้ำ

    Route::post('/claim/order/{order_id}', function (\Illuminate\Http\Request $request, $order_id, \App\Services\WichxShopApi $api) {
        $request->validate(['reason' => 'required|string|max:300'], ['reason.required' => 'กรุณาระบุเหตุผลในการเคลมด้วยครับ']);
        $order = \App\Models\Order::where('id', $order_id)->where('user_id', auth()->id())->firstOrFail();

        if (!$order->product->is_api_product) return back()->with('error', 'สินค้านี้เป็นของทางร้านเราโดยตรง กรุณาติดต่อแอดมินทางแชทเพื่อเคลมครับ');

        $account = \App\Models\Account::where('order_id', $order->id)->first();
        if (!$account || empty($account->api_order_id)) return back()->with('error', 'ไม่พบเลขออร์เดอร์อ้างอิงของร้านต้นทาง ติดต่อแอดมินด่วนครับ');

        $apiResponse = $api->claimProduct($account->api_order_id, $request->reason);
        if (isset($apiResponse['success']) && $apiResponse['success']) return back()->with('success', 'ส่งคำขอเคลมเรียบร้อยแล้วครับ! โปรดรอแอดมินตรวจสอบ');
        return back()->with('error', 'ไม่สามารถเคลมได้: ' . ($apiResponse['message'] ?? 'ระบบขัดข้อง'));
    })->name('claim.api_order');

    Route::post('/tools/get-otp', function (\Illuminate\Http\Request $request, \App\Services\WichxShopApi $api) {
        $type = $request->type;
        try {
            if ($type === 'netflix') {
                $request->validate(['email' => 'required|email']);
                $res = $api->getNetflixOtp($request->email);
            } else if ($type === 'rockstar') {
                $request->validate(['refresh_token' => 'required', 'client_id' => 'required']);
                $res = $api->getRockstarOtp($request->refresh_token, $request->client_id);
            } else {
                throw new \Exception('ประเภทการดึง OTP ไม่ถูกต้อง');
            }
            if (isset($res['data']) && count($res['data']) > 0) {
                $otpInfo = $res['data'][0];
                return back()->with('success', 'ดึง OTP สำเร็จ! รหัสของคุณคือ: ' . $otpInfo['otp']);
            }
            return back()->with('error', 'ยังไม่พบ OTP ในระบบ โปรดรอสักครู่แล้วกดดึงใหม่ครับ (ระบบจะค้นหาย้อนหลัง 3 นาที)');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    })->name('tools.get_otp');

    // ==========================================
    // ระบบเติมเงิน & โค้ด
    // ==========================================
    Route::get('/topup', function () { return view('topup'); })->name('topup');

    Route::post('/topup/slip', function (Illuminate\Http\Request $request) {
        $request->validate(['amount' => 'required|numeric|min:0.01', 'slip' => 'required|image|max:5120']);
        $user = Illuminate\Support\Facades\Auth::user();
        $methodName = $request->method == 'promptpay' ? 'พร้อมเพย์' : 'ทรูมันนี่วอเลท';

        // 🚨 โค้ดระบบจำลอง
        $user->balance += $request->amount;
        $user->points += $request->amount;
        $user->save();
        return redirect('/')->with('success', "ตรวจสอบสลิป {$methodName} สำเร็จ! ได้รับเงิน " . number_format($request->amount, 2) . " บาทเรียบร้อยแล้ว");
    })->name('topup.slip');

    Route::post('/topup/redeem', function (Illuminate\Http\Request $request) {
        $request->validate(['code' => 'required|string']);
        $codeStr = strtoupper(trim($request->code));
        $code = App\Models\RedeemCode::where('code', $codeStr)->first();

        if (!$code) return back()->with('error', '❌ โค้ดเติมเงินไม่ถูกต้อง หรือไม่มีในระบบ!');
        if ($code->max_uses > 0 && $code->current_uses >= $code->max_uses) return back()->with('error', '❌ โค้ดนี้ถูกใช้งานครบตามจำนวนที่กำหนดแล้ว!');

        $alreadyUsed = App\Models\RedeemLog::where('user_id', Auth::id())->where('redeem_code_id', $code->id)->exists();
        if ($alreadyUsed) return back()->with('error', '⚠️ คุณเคยใช้งานโค้ดนี้ไปแล้ว!');

        $user = Auth::user();
        $user->balance += $code->reward_amount;
        $user->points += $code->reward_amount;
        $user->save();

        $code->increment('current_uses');
        App\Models\RedeemLog::create(['user_id' => $user->id, 'redeem_code_id' => $code->id]);

        return redirect('/')->with('success', "🎉 ใช้งานโค้ดสำเร็จ! คุณได้รับเงิน " . number_format($code->reward_amount) . " บาท");
    })->name('topup.redeem');

    // ==========================================
    // ระบบ Gacha Engine
    // ==========================================
    Route::get('/gacha/{boxId}/play', function ($boxId) {
        $box = App\Models\RandomBox::with(['items.product'])->findOrFail($boxId);
        $stat = App\Models\UserBoxStat::where('user_id', Auth::id())->where('random_box_id', $boxId)->first();
        $currentPity = $stat ? $stat->pity_counter : 0;
        $remainingPity = max(0, $box->pity_limit - $currentPity);
        return view('gacha_play', compact('box', 'remainingPity'));
    })->name('gacha.play');

    Route::post('/gacha/{boxId}/draw', function (Illuminate\Http\Request $request, $boxId) {
        $userId = Auth::id();
        return DB::transaction(function() use ($userId, $boxId, $request) {
            $user = App\Models\User::lockForUpdate()->find($userId);
            $box = App\Models\RandomBox::lockForUpdate()->findOrFail($boxId);

            if ($user->balance < $box->price) {
                if ($request->wantsJson()) return response()->json(['status' => false, 'error' => 'ยอดเงินไม่พอสำหรับการสุ่ม!']);
                return back()->with('error', 'ยอดเงินไม่พอสำหรับการสุ่ม!');
            }

            $items = App\Models\RandomItem::where('random_box_id', $box->id)->where('is_active', true)->get();
            if ($items->isEmpty()) {
                if ($request->wantsJson()) return response()->json(['status' => false, 'error' => 'ตู้นี้ยังไม่มีของรางวัลครับ!']);
                return back()->with('error', 'ตู้นี้ยังไม่มีของรางวัลครับ!');
            }

            $stat = App\Models\UserBoxStat::firstOrCreate(['user_id' => $user->id, 'random_box_id' => $box->id], ['pity_counter' => 0]);
            $wonItem = null; $isPity = false;

            if ($box->pity_limit > 0 && $stat->pity_counter >= $box->pity_limit - 1) {
                $wonItem = $items->where('rarity', 'legendary')->whereNotNull('product_id')->first() ?? $items->whereNotNull('product_id')->first();
                $isPity = true;
            } else {
                $totalWeight = $items->sum('weight');
                $rand = rand(1, $totalWeight); $cumulative = 0;
                foreach ($items as $item) {
                    $cumulative += $item->weight;
                    if ($rand <= $cumulative) { $wonItem = $item; break; }
                }
            }

            if (!$wonItem || empty($wonItem->product_id)) {
                $user->balance -= $box->price;
                $user->points += $box->price;
                $user->save();

                $stat->pity_counter += 1; $stat->save();

                if ($wonItem) {
                     $ds = App\Models\DropStat::firstOrCreate(['random_item_id' => $wonItem->id]);
                     $ds->increment('total_attempts'); $ds->increment('total_drops');
                     foreach($items as $i) { if ($i->id != $wonItem->id) App\Models\DropStat::firstOrCreate(['random_item_id' => $i->id])->increment('total_attempts'); }
                }

                $remainingPity = max(0, $box->pity_limit - $stat->pity_counter);
                $saltMsg = 'เสียใจด้วย! รอบนี้คุณเกลือ 🧂 แต่อย่าเพิ่งท้อ Pity สะสมเพิ่มขึ้นแล้ว!';

                if ($request->wantsJson()) {
                    return response()->json(['status' => true, 'won_item_id' => $wonItem ? $wonItem->id : null, 'is_salt' => true, 'message' => $saltMsg, 'remaining_pity' => $remainingPity]);
                }
                return back()->with('error', $saltMsg);
            }

            $account = App\Models\Account::where('product_id', $wonItem->product_id)->where('usage_type', 'gacha')->where('status', 'available')->lockForUpdate()->first();
            if (!$account) {
                if ($request->wantsJson()) return response()->json(['status' => false, 'error' => 'เสียใจด้วย! ของที่สุ่มได้ดันหมดสต๊อกพอดี']);
                return back()->with('error', 'เสียใจด้วย! ของที่สุ่มได้ดันหมดสต๊อกพอดี');
            }

            $user->balance -= $box->price;
            $user->points += $box->price;
            $user->save();

            $account->update(['status' => 'sold', 'sold_at' => now()]);

            $product = App\Models\Product::find($wonItem->product_id);
            $product->decrement('stock_gacha');

            $stat->pity_counter = ($isPity || $wonItem->rarity === 'legendary') ? 0 : $stat->pity_counter + 1;
            $stat->save();

            App\Models\DrawLog::create(['user_id' => $user->id, 'random_box_id' => $box->id, 'account_id' => $account->id, 'was_pity' => $isPity, 'ip_address' => $request->ip()]);
            App\Models\Order::create(['user_id' => $user->id, 'product_id' => $product->id, 'account_id' => $account->id, 'price' => $box->price]);

            foreach($items as $item) {
                $ds = App\Models\DropStat::firstOrCreate(['random_item_id' => $item->id]);
                $ds->increment('total_attempts');
                if ($wonItem->id == $item->id) $ds->increment('total_drops');
            }

            $remainingPity = max(0, $box->pity_limit - $stat->pity_counter);
            $msg = "🎉 สุ่มได้: {$product->name} | ไอดี: {$account->game_username} | รหัสผ่าน: {$account->game_password}";

            if ($request->wantsJson()) {
                return response()->json(['status' => true, 'won_item_id' => $wonItem->id, 'message' => $msg, 'is_salt' => false, 'username' => $account->game_username, 'password' => $account->game_password, 'remaining_pity' => $remainingPity]);
            }
            return back()->with('success', $msg);
        });
    })->name('gacha.draw');


    /*
    |--------------------------------------------------------------------------
    | 🛡️ โซน ADMIN (ผู้ดูแลระบบ)
    |--------------------------------------------------------------------------
    | (หมายเหตุ: ปัจจุบันใช้เช็ค is_admin ด้านในฟังก์ชัน แนะนำให้สร้าง Middleware สำหรับ Admin ในอนาคต)
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // ------------------------------------------
        // Dashboard
        // ------------------------------------------
        Route::get('/dashboard', function () {
            if (!Auth::user()->is_admin) return redirect('/');

            $stats = [
                'users' => App\Models\User::count(),
                'revenue' => App\Models\Order::sum('price'),
                'stock' => App\Models\Account::where('status', 'available')->count(),
                'total_orders' => App\Models\Order::count()
            ];
            $recentOrders = App\Models\Order::with(['user', 'product'])->latest()->take(10)->get();

            return view('admin.dashboard', compact('stats', 'recentOrders'));
        })->name('dashboard');

        // ------------------------------------------
        // API Store (WichxShop)
        // ------------------------------------------
        Route::get('/api-store', function (\App\Services\WichxShopApi $api) {
            if (!Auth::user()->is_admin) return redirect('/');
            $balanceData = $api->getBalance();
            $productsData = $api->getProducts();

            $balance = $balanceData['success'] ? $balanceData['data']['balance'] : 0;
            $apiProducts = $productsData['success'] ? $productsData['data'] : [];
            $importedApiIds = \App\Models\Product::where('is_api_product', true)->pluck('api_product_id')->toArray();

            return view('admin.api_store', compact('balance', 'apiProducts', 'importedApiIds'));
        })->name('api_store');

        Route::post('/api-store/import', function (\Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            \App\Models\Product::create([
                'api_product_id' => $request->api_product_id, 'is_api_product' => true,
                'name' => $request->name, 'description' => 'สินค้านำเข้าอัตโนมัติ พร้อมส่ง 24 ชม.',
                'price' => $request->my_price, 'stock' => 999, 'icon' => $request->image, 'is_visible' => true,
            ]);
            return back()->with('success', 'นำเข้าสินค้า: '.$request->name.' เข้าร้านเรียบร้อยแล้ว!');
        })->name('api_store.import');

        Route::post('/api-store/sync-stock', function (\App\Services\WichxShopApi $api) {
            if (!Auth::user()->is_admin) return redirect('/');
            $apiResponse = $api->getProducts();
            if (!$apiResponse['success']) return back()->with('error', 'ไม่สามารถดึงข้อมูลจาก API ได้');

            $apiProducts = $apiResponse['data']; $count = 0;
            foreach ($apiProducts as $apiItem) {
                $product = \App\Models\Product::where('api_product_id', $apiItem['id'])->first();
                if ($product) { $product->update(['stock' => $apiItem['stock']]); $count++; }
            }
            return back()->with('success', "ซิงค์สต๊อกสินค้า API สำเร็จทั้งหมด $count รายการ!");
        })->name('api_store.sync_stock');

        Route::post('/api-store/sync-claims', function (\App\Services\WichxShopApi $api) {
            if (!Auth::user()->is_admin) return redirect('/');
            $pendingOrders = \App\Models\Order::where('api_claim_status', 'PENDING')->get();
            $updatedCount = 0;

            foreach ($pendingOrders as $order) {
                if ($order->api_order_id) {
                    $res = \Illuminate\Support\Facades\Http::withHeaders(['x-api-key' => env('WICHXSHOP_API_KEY')])
                            ->get(env('WICHXSHOP_API_URL')."/store/history/{$order->api_order_id}")->json();

                    if (isset($res['success']) && $res['success']) {
                        $newStatus = $res['data']['claimStatus'];
                        if ($newStatus !== $order->api_claim_status) {
                            $order->update(['api_claim_status' => $newStatus]); $updatedCount++;
                        }
                    }
                }
            }
            return back()->with('success', "อัปเดตสถานะเคลมให้ลูกค้าแล้ว $updatedCount รายการ!");
        })->name('api_store.sync_claims');

        Route::post('/api-store/quick-update/{id}', function (\Illuminate\Http\Request $request, $id) {
            if (!Auth::user()->is_admin) return redirect('/');
            $product = \App\Models\Product::findOrFail($id);
            $product->update(['name' => $request->name, 'price' => $request->my_price]);
            return back()->with('success', '✅ อัปเดต "ชื่อและราคา" ของสินค้าสำเร็จแล้วครับ!');
        })->name('api_store.quick_update');

        // ------------------------------------------
        // Products (จัดการสินค้าในร้าน)
        // ------------------------------------------
        Route::get('/products', function () {
            if (!Auth::user()->is_admin) return redirect('/');
            $products = Product::latest()->get();
            $categories = Category::all();
            return view('admin.products', compact('products', 'categories'));
        })->name('products');

        Route::post('/products', function (Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            Product::create($request->all());
            return back()->with('success', 'เพิ่มสินค้าใหม่ลงร้านเรียบร้อยเฟี้ยวๆ!');
        })->name('products.store');

        Route::delete('/products/{id}', function ($id) {
            if (!Auth::user()->is_admin) return redirect('/');

            $product = App\Models\Product::findOrFail($id);

            // 1. ไปเคลียร์ข้อมูลในตู้สุ่ม (Gacha) ก่อน
            $randomItems = App\Models\RandomItem::where('product_id', $product->id)->get();
            foreach ($randomItems as $item) {
                try {
                    \Illuminate\Support\Facades\DB::table('drop_stats')->where('random_item_id', $item->id)->delete();
                } catch (\Exception $e) {}

                try {
                    \Illuminate\Support\Facades\DB::table('rate_history')->where('random_item_id', $item->id)->delete();
                } catch (\Exception $e) {}

                $item->delete();
            }

            // 2. เคลียร์สต๊อกไอดี (Accounts) ที่เชื่อมกับสินค้านี้ทิ้ง
            App\Models\Account::where('product_id', $product->id)->delete();

            // 3. สุดท้าย ลบตัวสินค้าหลักได้อย่างปลอดภัย
            $product->delete();

            // 🚨 แก้ไขตรงนี้: บังคับให้ Redirect กลับไปที่หน้า admin/products ชัวร์ๆ
            return redirect()->route('admin.products')->with('success', 'ลบสินค้าและข้อมูลที่เกี่ยวข้องออกจากระบบเรียบร้อยครับ!');
        })->name('products.destroy');

        Route::get('/products/{id}/edit', function ($id) {
            if (!Auth::user()->is_admin) return redirect('/');
            $product = Product::findOrFail($id);
            $categories = Category::all();
            return view('admin.products_edit', compact('product', 'categories'));
        })->name('products.edit');

        Route::put('/products/{id}', function (Request $request, $id) {
            if (!Auth::user()->is_admin) return redirect('/');
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return redirect('/admin/products')->with('success', 'อัปเดตข้อมูลสินค้าเรียบร้อยครับ!');
        })->name('products.update');

        Route::get('/products/sort', function () {
            if (!Auth::user()->is_admin) return redirect('/');
            $products = \App\Models\Product::orderBy('sort_order', 'asc')->get();
            return view('admin.sort_products', compact('products'));
        })->name('products.sort');

        Route::post('/products/update-order', function (\Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            $orderIds = $request->order;
            foreach ($orderIds as $index => $id) { \App\Models\Product::where('id', $id)->update(['sort_order' => $index]); }
            return response()->json(['success' => true]);
        })->name('products.update_order');

        // ------------------------------------------
        // Categories (จัดการหมวดหมู่)
        // ------------------------------------------
        Route::get('/categories', function () {
            if (!Auth::user()->is_admin) return redirect('/');
            $categories = App\Models\Category::withCount('products')->latest()->get();
            return view('admin.categories', compact('categories'));
        })->name('categories');

        Route::post('/categories', function (Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            App\Models\Category::create($request->all());
            return back()->with('success', 'เพิ่มหมวดหมู่ใหม่เรียบร้อยแล้ว!');
        })->name('categories.store');

        Route::get('/categories/delete/{id}', function ($id) {
            if (!Auth::user()->is_admin) return redirect('/');
            App\Models\Category::findOrFail($id)->delete();
            return back()->with('success', 'ลบหมวดหมู่ทิ้งแล้ว!');
        })->name('categories.delete');

        Route::post('/categories/{id}/update', function (Illuminate\Http\Request $request, $id) {
            if (!Auth::user()->is_admin) return redirect('/');
            App\Models\Category::findOrFail($id)->update($request->except('_token'));
            return back()->with('success', 'อัปเดตหมวดหมู่สำเร็จ!');
        })->name('categories.update');

        // ------------------------------------------
        // Stocks (จัดการสต๊อกทำมือ)
        // ------------------------------------------
        Route::get('/stocks', function () {
            if (!Auth::user()->is_admin) return redirect('/');
            $products = App\Models\Product::all();
            $accounts = App\Models\Account::with('product')->latest()->limit(100)->get();
            return view('admin.stocks', compact('products', 'accounts'));
        })->name('stocks');

        Route::post('/stocks/import', function (Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            $request->validate(['product_id' => 'required|exists:products,id', 'usage_type' => 'required|in:sale,gacha', 'accounts_data' => 'required|string']);

            $lines = explode("\n", str_replace("\r", "", $request->accounts_data));
            $count = 0;

            foreach($lines as $line) {
                $line = trim($line);
                if(empty($line)) continue;
                $data = explode(":", $line, 2);
                if(count($data) == 2 && !empty(trim($data[0])) && !empty(trim($data[1]))) {
                    App\Models\Account::create(['product_id' => $request->product_id, 'usage_type' => $request->usage_type, 'game_username' => trim($data[0]), 'game_password' => trim($data[1]), 'status' => 'available']);
                    $count++;
                }
            }

            if($count == 0) return back()->with('error', '❌ นำเข้าไม่สำเร็จ! กรุณาตรวจสอบข้อมูล ต้องมีเครื่องหมาย : (โคลอน) คั่นกลางระหว่างไอดีกับรหัสผ่านครับ');

            $product = App\Models\Product::find($request->product_id);
            if ($request->usage_type == 'sale') {
                $product->update(['stock' => App\Models\Account::where('product_id', $product->id)->where('usage_type', 'sale')->where('status', 'available')->count()]);
            } else {
                $product->update(['stock_gacha' => App\Models\Account::where('product_id', $product->id)->where('usage_type', 'gacha')->where('status', 'available')->count()]);
            }
            $typeName = $request->usage_type == 'sale' ? 'ขายตรง' : 'ตู้สุ่ม';
            return back()->with('success', "นำเข้าสต็อก $typeName สำเร็จจำนวน $count ไอดี!");
        })->name('stocks.import');

        Route::get('/stocks/delete/{id}', function ($id) {
            if (!Auth::user()->is_admin) return redirect('/');
            $account = App\Models\Account::findOrFail($id);
            $productId = $account->product_id;
            $usageType = $account->usage_type;
            $account->delete();

            $product = App\Models\Product::find($productId);
            if ($usageType == 'sale') {
                $product->update(['stock' => App\Models\Account::where('product_id', $product->id)->where('usage_type', 'sale')->where('status', 'available')->count()]);
            } else {
                $product->update(['stock_gacha' => App\Models\Account::where('product_id', $product->id)->where('usage_type', 'gacha')->where('status', 'available')->count()]);
            }
            return back()->with('success', 'ลบไอดีออกจากระบบแล้ว!');
        })->name('stocks.delete');

        // ------------------------------------------
        // Gacha (จัดการกาชาปอง)
        // ------------------------------------------
        Route::get('/gacha', function () {
            if (!Auth::user()->is_admin) return redirect('/');
            $boxes = App\Models\RandomBox::with('items.product')->get();
            $products = \App\Models\Product::orderBy('sort_order', 'asc')->latest()->get();
            return view('admin.gacha', compact('boxes', 'products'));
        })->name('gacha');

        Route::post('/gacha/create-box', function (Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            App\Models\RandomBox::create($request->all() + ['is_vip' => $request->is_vip ?? false, 'pity_limit' => $request->pity_limit ?? 50]);
            return back()->with('success', 'สร้างตู้สำเร็จ!');
        })->name('gacha.create_box');

        Route::post('/gacha/add-item', function (Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');
            App\Models\RandomItem::create($request->all() + ['is_active' => true]);
            return back()->with('success', 'เพิ่มของรางวัลสำเร็จ!');
        })->name('gacha.add_item');

        Route::post('/gacha/update-item/{id}', function (Illuminate\Http\Request $request, $id) {
            if (!Auth::user()->is_admin) return redirect('/');
            $item = App\Models\RandomItem::findOrFail($id);
            App\Models\RateHistory::create(['random_box_id' => $item->random_box_id, 'random_item_id' => $item->id, 'old_weight' => $item->weight, 'new_weight' => $request->weight, 'changed_by' => Auth::id()]);
            $item->update(['weight' => $request->weight, 'image_url' => $request->image_url, 'is_active' => $request->has('is_active') ? true : false]);
            return back()->with('success', 'อัปเดตเรทและรูปภาพเรียบร้อย!');
        })->name('gacha.update_item');

        Route::get('/gacha/delete-item/{id}', function ($id) {
            if (!Auth::user()->is_admin) return redirect('/');
            \Illuminate\Support\Facades\DB::table('drop_stats')->where('random_item_id', $id)->delete();
            $item = \App\Models\RandomItem::findOrFail($id);
            $item->delete();
            return back()->with('success', 'ลบไอเทมสำเร็จแล้วครับ!');
        })->name('gacha.delete_item');

        // ------------------------------------------
        // Codes (จัดการโค้ดเติมเงิน)
        // ------------------------------------------
        Route::get('/codes', function () {
            if (!Auth::user()->is_admin) return redirect('/');
            $codes = App\Models\RedeemCode::latest()->get();
            return view('admin.codes', compact('codes'));
        })->name('codes');

        Route::post('/codes', function (Illuminate\Http\Request $request) {
            if (!Auth::user()->is_admin) return redirect('/');

            // 🚨 เพิ่มระบบดักจับ (Validate) โค้ดซ้ำตรงนี้!
            $request->validate([
                'code' => 'nullable|string|unique:redeem_codes,code'
            ], [
                'code.unique' => '❌ โค้ดนี้มีอยู่ในระบบแล้วครับ กรุณาตั้งชื่ออื่น!'
            ]);

            $codeStr = $request->code ? strtoupper($request->code) : strtoupper(\Illuminate\Support\Str::random(12));

            App\Models\RedeemCode::create([
                'code' => $codeStr,
                'reward_amount' => $request->reward_amount,
                'max_uses' => $request->max_uses ?? 1
            ]);

            return back()->with('success', "สร้างโค้ด {$codeStr} สำเร็จ!");
        })->name('codes.store');

        Route::get('/codes/delete/{id}', function ($id) {
            if (!Auth::user()->is_admin) return redirect('/');
            App\Models\RedeemCode::findOrFail($id)->delete();
            return back()->with('success', 'ลบโค้ดทิ้งแล้ว!');
        })->name('codes.delete');

    }); // จบกลุ่ม Admin
}); // จบกลุ่ม Auth

// Class สร้าง QR PromptPay (วางไว้นอกกลุ่มได้เลย ไม่เกี่ยวกับการเข้าถึง Route)
class PromptPayQR {
    public function generatePayload($target, $amount = null) {
        $target = preg_replace("/[^0-9]/", "", $target);
        $data = ["000201"];
        $data[] = $amount !== null && $amount > 0 ? "010212" : "010211";
        $merchantInfo = "0016A000000677010111";

        if (strlen($target) == 10) {
            $target = "0066" . substr($target, 1);
            $merchantInfo .= "01" . sprintf("%02d", strlen($target)) . $target;
        } elseif (strlen($target) == 13) {
            $merchantInfo .= "02" . sprintf("%02d", strlen($target)) . $target;
        } elseif (strlen($target) == 15) {
            $merchantInfo .= "03" . sprintf("%02d", strlen($target)) . $target;
        } else {
            $merchantInfo .= "01" . sprintf("%02d", strlen($target)) . $target;
        }

        $data[] = "29" . sprintf("%02d", strlen($merchantInfo)) . $merchantInfo;
        $data[] = "5802TH";
        $data[] = "5303764";

        if ($amount !== null && $amount > 0) {
            $formattedAmount = number_format($amount, 2, '.', '');
            $data[] = "54" . sprintf("%02d", strlen($formattedAmount)) . $formattedAmount;
        }

        $rawPayload = implode("", $data) . "6304";
        return $rawPayload . $this->crc16($rawPayload);
    }

    private function crc16($data) {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $x = (($crc >> 8) ^ ord($data[$i])) & 0xFF;
            $x ^= $x >> 4;
            $crc = (($crc << 8) ^ ($x << 12) ^ ($x << 5) ^ $x) & 0xFFFF;
        }
        return strtoupper(sprintf("%04x", $crc));
    }
}

require __DIR__.'/auth.php';
