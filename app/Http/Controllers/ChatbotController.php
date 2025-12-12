<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    private const CACHE_TTL = 300; // 5 phút
    private const MAX_PRODUCTS = 5;
    
    public function chat(Request $request)
    {
        $userId = $request->header('X-User-ID', 'guest_' . $request->ip());
        $message = trim($request->input('message', ''));
        $lower = mb_strtolower($this->normalizeText($message));

        if (empty($message)) {
            return $this->reply("Xin chào! Bạn cần hỗ trợ tìm laptop hay có thắc mắc gì ạ? Mình sẵn sàng tư vấn chi tiết!");
        }

        $history = Cache::get("chat_history_{$userId}", []);

        if ($this->contains($lower, ['hi', 'hello', 'chào', 'xin chào', 'alo', 'hey'])) {
            $greeting = $this->getGreeting();
            $this->saveHistory($userId, $message, $greeting);
            return $this->reply($greeting . "\n\nBạn đang quan tâm đến laptop để làm gì ạ? (Học tập, văn phòng, đồ họa, gaming...) Mình sẽ gợi ý mẫu phù hợp nhất!");
        }

        if ($this->contains($lower, ['giao hàng', 'ship', 'vận chuyển', 'giao tận nơi'])) {
            $response = "Bên mình **giao hàng toàn quốc** qua Viettel Post, Giao Hàng Nhanh. \n" .
                        "• Phí ship: 20.000 – 40.000đ (miễn phí cho đơn từ 5 triệu).\n" .
                        "• Thời gian: 1-3 ngày (nội thành), 3-5 ngày (tỉnh xa).\n\n" .
                        "Bạn ở khu vực nào để mình check giúp thời gian chính xác ạ?";
            $this->saveHistory($userId, $message, $response);
            return $this->reply($response);
        }

        if ($this->contains($lower, ['đổi trả', 'bảo hành', 'lỗi', 'hỏng'])) {
            $response = "Sản phẩm **chính hãng 100%**, bảo hành từ 12-36 tháng tùy model.\n" .
                        "• **Đổi mới 1-1** trong 7 ngày nếu lỗi nhà sản xuất.\n" .
                        "• Hỗ trợ bảo hành tận nơi (tùy khu vực).\n\n" .
                        "Bạn đang lo lắng về model nào để mình kiểm tra chính sách cụ thể?";
            $this->saveHistory($userId, $message, $response);
            return $this->reply($response);
        }

        // ====== 3. TÌM KIẾM SẢN PHẨM NÂNG CAO ======
        if ($this->contains($lower, ['laptop', 'máy tính', 'tìm', 'mua', 'cần', 'muốn', 'gợi ý'])) {
            $context = $this->extractContext($history);
            $filters = $this->extractFilters($lower, $context);

            $products = $this->searchProductsAdvanced($filters);

            if ($products->count() === 0) {
                $suggestion = $this->suggestNextQuestion($filters, $history);
                $this->saveHistory($userId, $message, $suggestion);
                return $this->reply($suggestion);
            }

            $reply = $this->buildProductResponse($products, $filters);
            $this->saveHistory($userId, $message, $reply['reply']);

            return response()->json($reply);
        }

        // ====== 4. HỎI NGƯỢC THÔNG MINH KHI THIẾU THÔNG TIN ======
        $smartReply = $this->handleUnknown($lower, $history, $userId);
        return $this->reply($smartReply);
    }


    private function searchProductsAdvanced($filters)
    {
        $cacheKey = 'search_' . md5(serialize($filters));
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($filters) {
            $query = SanPham::with(['hang'])
                ->where('trangthai', 1)
                ->where(function ($q) {
                    $q->where('giamoi', '>', 0)->orWhere('giacu', '>', 0);
                });

            // Lọc hãng
            if (!empty($filters['brand'])) {
                $query->whereHas('hang', fn($q) => $q->whereRaw('LOWER(tenhang) LIKE ?', ["%{$filters['brand']}%"]));
            }

            // Lọc CPU
            if (!empty($filters['cpu'])) {
                $cpu = $filters['cpu'];
                $query->where(function ($q) use ($cpu) {
                    $q->whereRaw('LOWER(tensp) LIKE ?', ["%{$cpu}%"])
                      ->orWhereRaw('LOWER(cauhinh) LIKE ?', ["%{$cpu}%"]);
                });
            }

            // Lọc RAM
            if (!empty($filters['ram'])) {
                $query->whereRaw('LOWER(cauhinh) LIKE ?', ["%{$filters['ram']}gb%"]);
            }

            // Lọc giá
            if (!empty($filters['price_min']) || !empty($filters['price_max'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where(function ($sub) use ($filters) {
                        $sub->where('giamoi', '>', 0)
                            ->where('giamoi', '>=', $filters['price_min'] ?? 0)
                            ->where('giamoi', '<=', $filters['price_max'] ?? PHP_INT_MAX);
                    })->orWhere(function ($sub) use ($filters) {
                        $sub->where('giamoi', 0)
                            ->where('giacu', '>=', $filters['price_min'] ?? 0)
                            ->where('giacu', '<=', $filters['price_max'] ?? PHP_INT_MAX);
                    });
                });
            }

            // Ưu tiên giá mới > khuyến mãi > giá cũ
            return $query->orderByRaw('
                CASE 
                    WHEN giamoi > 0 THEN giamoi 
                    ELSE giacu 
                END ASC
            ')->get();
        });
    }


    private function extractFilters($text, $context)
    {
        $filters = [
            'brand' => $this->extractBrand($text . ' ' . $context),
            'cpu' => $this->extractCPU($text . ' ' . $context),
            'ram' => $this->extractRAM($text),
            'price_min' => null,
            'price_max' => null,
        ];

        [$min, $max] = $this->extractPriceRange($text);
        $filters['price_min'] = $min;
        $filters['price_max'] = $max;

        return $filters;
    }

    private function extractBrand($text)
    {
        $brands = ['dell', 'asus', 'hp', 'lenovo', 'acer', 'msi', 'macbook', 'apple', 'gigabyte', 'lg', ];
        foreach ($brands as $b) {
            if (str_contains($text, $b)) return $b;
        }
        return null;
    }

    private function extractCPU($text)
    {
        $cpus = [
            'i3' => 'i3', 'core i3' => 'i3',
            'i5' => 'i5', 'core i5' => 'i5',
            'i7' => 'i7', 'core i7' => 'i7',
            'i9' => 'i9',
            'ryzen 3' => 'ryzen 3', 'r3' => 'ryzen 3',
            'ryzen 5' => 'ryzen 5', 'r5' => 'ryzen 5',
            'ryzen 7' => 'ryzen 7', 'r7' => 'ryzen 7',
        ];
        foreach ($cpus as $key => $val) {
            if (str_contains($text, $key)) return $val;
        }
        return null;
    }

    private function extractRAM($text)
    {
        if (preg_match('/(\d{1,2})\s*(gb|g)\b/', $text, $m)) {
            return $m[1];
        }
        return null;
    }

    private function extractPriceRange($text)
    {
        $text = str_replace(['.', ','], '', $text);
        $min = $max = null;

        if (preg_match('/dưới\s+(\d+)\s*(triệu|tr)\b/', $text, $m)) {
            $max = $m[1] * 1000000;
        }
        elseif (preg_match('/trên\s+(\d+)\s*(triệu|tr)\b/', $text, $m)) {
            $min = $m[1] * 1000000;
        }
        elseif (preg_match('/(\d+)\s*[-~]\s*(\d+)\s*(triệu|tr)\b/', $text, $m)) {
            $min = $m[1] * 1000000;
            $max = $m[2] * 1000000;
        }
        elseif (preg_match('/(\d+)\s*(triệu|tr)\b/', $text, $m)) {
            $price = $m[1] * 1000000;
            $min = $price * 0.9;
            $max = $price * 1.2;
        }

        return [$min, $max];
    }


    private function buildProductResponse($products, $filters)
    {
        $count = $products->count();
        $shown = $products->take(self::MAX_PRODUCTS);

        $intro = "Mình tìm thấy **{$count} mẫu laptop** phù hợp với nhu cầu của bạn!\n";
        if ($count > self::MAX_PRODUCTS) {
            $intro .= "(Hiển thị 5 mẫu nổi bật nhất)\n\n";
        } else {
            $intro .= "\n";
        }

        return [
            "reply" => $intro . "Bạn có thể chọn mẫu dưới đây hoặc nói rõ hơn để mình lọc chính xác hơn nhé!",
            "products" => $shown->map(function ($sp) {
                $price = $sp->giamoi > 0 ? $sp->giamoi : $sp->giacu;
                $oldPrice = $sp->giamoi > 0 ? $sp->giacu : null;

                return [
                    "tensp" => Str::limit($sp->tensp, 60),
                    "hang" => $sp->hang?->tenhang ?? "Không rõ",
                    "gia" => $price,
                    "giacu" => $oldPrice,
                    "anhdaidien" => $sp->anhdaidien ? asset("storage/img/" . $sp->anhdaidien) : null,
                    "masp" => $sp->masp,
                ];
            })
        ];
    }


    private function suggestNextQuestion($filters, $history)
    {
        $asked = [];
        foreach ($history as $h) {
            if (isset($h['user'])) $asked[] = $h['user'];
        }
        $asked = implode(' ', $asked);

        $suggestions = [];

        if (empty($filters['brand']) && !$this->contains($asked, ['dell','asus','hp','lenovo','acer','msi'])) {
            $suggestions[] = "Bạn đang quan tâm hãng nào ạ? (Asus, Dell, HP, Lenovo, MacBook...)";
        }
        if (empty($filters['cpu']) && !$this->contains($asked, ['i5','i7','ryzen'])) {
            $suggestions[] = "Bạn cần CPU mạnh cỡ nào? (i3/i5/i7, Ryzen 5/7...)";
        }
        if (empty($filters['price_min']) && empty($filters['price_max'])) {
            $suggestions[] = "Ngân sách của bạn khoảng bao nhiêu? (dưới 10tr, 15-20tr...)";
        }
        if (empty($filters['ram'])) {
            $suggestions[] = "Bạn cần RAM bao nhiêu GB? (8GB, 16GB...)";
        }

        $base = "Mình chưa tìm được mẫu phù hợp. Để tư vấn chính xác hơn, bạn có thể cho mình biết thêm:\n";
        $list = "• " . implode("\n• ", $suggestions ?: ["Nhu cầu sử dụng (học tập, làm việc, chơi game...)"]);

        return $base . $list;
    }


    private function handleUnknown($text, $history, $userId)
    {
        $context = collect($history)->pluck('bot')->implode(' ');

        if ($this->contains($text . ' ' . $context, ['học', 'văn phòng', 'office'])) {
            $this->saveHistory($userId, $text, "Mình gợi ý dòng laptop văn phòng mỏng nhẹ, pin tốt nhé!");
            return $this->reply("Bạn cần laptop để **học tập/làm văn phòng** đúng không ạ? Mình gợi ý các mẫu mỏng nhẹ, pin trâu, giá từ 10-15 triệu. Bạn muốn xem không?");
        }

        if ($this->contains($text . ' ' . $context, ['game', 'đồ họa', 'thiết kế', 'render'])) {
            return $this->reply("Bạn cần máy **chơi game/đồ họa**? Mình sẽ gợi ý cấu hình mạnh (i5/Ryzen 5 trở lên, card rời). Ngân sách khoảng bao nhiêu ạ?");
        }

        return "Mình hơi khó hiểu yêu cầu của bạn. Bạn có thể nói rõ hơn về:\n" .
               "• Hãng máy?\n" .
               "• Cấu hình (CPU, RAM)?\n" .
               "• Mức giá?\n" .
               "Mình sẽ hỗ trợ ngay!";
    }


    private function saveHistory($userId, $userMsg, $botReply)
    {
        $key = "chat_history_{$userId}";
        $history = Cache::get($key, []);
        $history = array_slice($history, -2); // Giữ 3 lượt gần nhất
        $history[] = ['user' => $userMsg, 'bot' => $botReply];
        Cache::put($key, $history, now()->addHours(1));
    }

    private function extractContext($history)
    {
        return collect($history)->pluck('user')->implode(' ');
    }

    private function getGreeting()
    {
        $hour = now()->hour;
        if ($hour < 12) return "Chào buổi sáng";
        if ($hour < 18) return "Chào buổi chiều";
        return "Chào buổi tối";
    }

    private function normalizeText($text)
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }


    private function contains($text, $words)
    {
        return collect($words)->contains(fn($w) => str_contains($text, $w));
    }

    private function reply($text)
    {
        return response()->json(['reply' => $text]);
    }
}