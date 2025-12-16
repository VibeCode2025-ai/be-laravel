<?php

namespace App\Http\Controllers;

use App\Models\Hang;
use App\Models\SanPham;
use App\Models\DanhMuc;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    private const CACHE_TTL = 300; // 5 phút

    private const MAX_PRODUCTS = 5;

    public function chat(Request $request)
    {
        $userId = $request->header('X-User-ID', 'guest_'.$request->ip());
        $message = trim($request->input('message', ''));
        $lower = mb_strtolower($this->normalizeText($message));

        if ($message === '') {
            return $this->reply('Xin chào! Bạn cần tìm laptop theo nhu cầu nào ạ?');
        }

        $history = Cache::get("chat_history_{$userId}", []);

        // ===== CHÀO HỎI =====
        if ($this->contains($lower, ['hi', 'hello', 'chào', 'xin chào', 'alo'])) {
            $reply = $this->getGreeting()." 👋\nBạn đang tìm laptop để làm gì ạ?";
            $this->saveHistory($userId, $message, $reply);

            return $this->reply($reply);
        }

        // ===== TÌM KIẾM =====
        if ($this->contains($lower, ['laptop', 'mua', 'tìm', 'cần', 'muốn', 'gợi ý'])) {
            $context = $this->extractContext($history);
            $filters = $this->extractFilters($lower, $context);

            $products = $this->searchProducts($filters);

            if ($products->count() === 0) {
                $suggest = $this->suggestNextQuestion($filters);
                $this->saveHistory($userId, $message, $suggest);

                return $this->reply($suggest);
            }

            $reply = $this->buildProductResponse($products);
            $this->saveHistory($userId, $message, $reply['reply']);

            return response()->json($reply);
        }

        return $this->reply(
            "Mình chưa hiểu rõ lắm 🤔\n".
            "Bạn có thể nói rõ hơn về:\n".
            "• Hãng laptop\n• Cấu hình\n• Ngân sách"
        );
    }

    // ======================================================
    // SEARCH
    // ======================================================

    private function searchProducts(array $filters)
    {
        return SanPham::with('hang')
            ->where('trangthai', 1)
            ->when($filters['brand'], function ($q) use ($filters) {
                $q->whereHas('hang', fn ($h) => $h->whereRaw('LOWER(tenhang) LIKE ?', ["%{$filters['brand']}%"])
                );
            })
            ->when($filters['cpu'], function ($q) use ($filters) {
                $q->whereRaw('LOWER(tensp) LIKE ?', ["%{$filters['cpu']}%"])
                    ->orWhereRaw('LOWER(thongso) LIKE ?', ["%{$filters['cpu']}%"]);
            })
            ->when($filters['ram'], function ($q) use ($filters) {
                $q->whereRaw('LOWER(thongso) LIKE ?', ["%{$filters['ram']}gb%"]);
            })
            ->when($filters['price_min'] || $filters['price_max'], function ($q) use ($filters) {
                $min = $filters['price_min'] ?? 0;
                $max = $filters['price_max'] ?? PHP_INT_MAX;

                $q->where(function ($s) use ($min, $max) {
                    $s->whereBetween('giamoi', [$min, $max])
                        ->orWhereBetween('giacu', [$min, $max]);
                });
            })
            ->orderByRaw('CASE WHEN giamoi > 0 THEN giamoi ELSE giacu END ASC')
            ->limit(20)
            ->get();
    }

    // ======================================================
    // FILTERS
    // ======================================================

    private function extractFilters($text, $context)
    {
        [$min, $max] = $this->extractPriceRange($text);

        return [
            'brand' => $this->extractBrand($text.' '.$context),
            'cpu' => $this->extractCPU($text.' '.$context),
            'ram' => $this->extractRAM($text),
            'price_min' => $min,
            'price_max' => $max,
        ];
    }

    private function extractBrand($text)
    {
        $brands = Cache::remember('chatbot_brands', 3600, fn () => Hang::pluck('tenhang')->map(fn ($b) => mb_strtolower($b))->toArray()
        );

        foreach ($brands as $brand) {
            if (str_contains($text, $brand)) {
                return $brand;
            }
        }

        return null;
    }

    private function extractCPU($text)
    {
        preg_match('/(i[3579]|ryzen\s?[3579])/i', $text, $m);

        return $m[0] ?? null;
    }

    private function extractRAM($text)
    {
        preg_match('/(\d{1,2})\s*gb/i', $text, $m);

        return $m[1] ?? null;
    }

    private function extractPriceRange($text)
    {
        $text = str_replace(['.', ','], '', $text);
        $min = $max = null;

        if (preg_match('/dưới\s+(\d+)\s*(tr|triệu)/', $text, $m)) {
            $max = $m[1] * 1000000;
        } elseif (preg_match('/trên\s+(\d+)\s*(tr|triệu)/', $text, $m)) {
            $min = $m[1] * 1000000;
        } elseif (preg_match('/(\d+)\s*[-~]\s*(\d+)\s*(tr|triệu)/', $text, $m)) {
            $min = $m[1] * 1000000;
            $max = $m[2] * 1000000;
        }

        return [$min, $max];
    }

    // ======================================================
    // RESPONSE
    // ======================================================

    private function buildProductResponse($products)
    {
        $shown = $products->take(self::MAX_PRODUCTS);

        return [
            'reply' => "Mình tìm thấy **{$products->count()} laptop** phù hợp 👇",
            'products' => $shown->map(fn ($sp) => [
                'masp' => $sp->masp,
                'tensp' => Str::limit($sp->tensp, 60),
                'hang' => $sp->hang?->tenhang,
                'gia' => $sp->giamoi > 0 ? $sp->giamoi : $sp->giacu,
                'giacu' => $sp->giamoi > 0 ? $sp->giacu : null,
                'anhdaidien' => $sp->anhdaidien
                    ? asset('storage/img/'.$sp->anhdaidien)
                    : null,
            ]),
        ];
    }

    private function suggestNextQuestion($filters)
    {
        $questions = [];

        if (! $filters['brand']) {
            $brands = Hang::limit(6)->pluck('tenhang')->implode(', ');
            $questions[] = "Bạn muốn hãng nào ạ? ({$brands})";
        }
        if (! $filters['cpu']) {
            $questions[] = 'Bạn cần CPU mức nào? (i5, i7, Ryzen 5...)';
        }
        if (! $filters['ram']) {
            $questions[] = 'Bạn cần RAM bao nhiêu GB? (8GB / 16GB)';
        }
        if (! $filters['price_min'] && ! $filters['price_max']) {
            $questions[] = 'Ngân sách khoảng bao nhiêu ạ?';
        }

        return "Để mình tư vấn chính xác hơn, bạn cho mình biết thêm:\n• "
            .implode("\n• ", $questions);
    }

    // ======================================================
    // HELPERS
    // ======================================================

    private function saveHistory($userId, $userMsg, $botReply)
    {
        $key = "chat_history_{$userId}";
        $history = Cache::get($key, []);
        $history[] = ['user' => $userMsg, 'bot' => $botReply];
        Cache::put($key, array_slice($history, -3), now()->addHour());
    }

    private function extractContext($history)
    {
        return collect($history)->pluck('user')->implode(' ');
    }

    private function normalizeText($text)
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }

    private function contains($text, $words)
    {
        foreach ($words as $w) {
            if (str_contains($text, $w)) {
                return true;
            }
        }

        return false;
    }

    private function getGreeting()
    {
        $h = now()->hour;

        return $h < 12 ? 'Chào buổi sáng' : ($h < 18 ? 'Chào buổi chiều' : 'Chào buổi tối');
    }

    private function reply($text)
    {
        return response()->json(['reply' => $text]);
    }
}
