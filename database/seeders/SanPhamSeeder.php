<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [];

        // Danh sách mẫu sản phẩm & ảnh
        $names = [
            "Asus ROG Strix Scar 18",
            "Asus TUF Gaming F15",
            "MSI Katana 15",
            "Acer Predator Helios 16",
            "Dell G15 Gaming",
            "HP Omen 16",
            "Lenovo Legion 5 Pro",
            "Gigabyte Aorus 15",
            "MacBook Air M2 2022",
            "MacBook Pro M3 2024",
        ];

        $images = [
            "rog-scar.jpg", "tuf-f15.jpg", "katana15.jpg", "helios16.jpg",
            "g15.jpg", "omen16.jpg", "legion5.jpg", "aorus15.jpg",
            "macbook-air-m2.jpg", "macbook-pro-m3.jpg"
        ];

        // tạo 80 sản phẩm
        for ($i = 1; $i <= 80; $i++) {
            $index = $i % count($names);
            $hang_id = [1, 2, 3, 4][($i - 1) % 4]; // chia đều 4 hãng
            $danhmuc_id = [1, 2, 15][($i - 1) % 3]; // chia đều 3 danh mục
            $chuyenmuc_id = [1, 2, 3, 4][($i - 1) % 4]; // chia đều 4 chuyên mục

            $giaMoi = rand(15000000, 35000000);
            $giaCu = $giaMoi + rand(2000000, 6000000);

            $products[] = [
                'tensp' => $names[$index] . " #" . $i,
                'anhdaidien' => $images[$index],
                'mota' => "Hiệu năng mạnh mẽ với chip AMD Ryzen 9 hoặc Intel Core i9, RAM 16GB, SSD 1TB, GPU RTX 4070.",
                'hinhanhkhac1' => $images[$index],
                'giamoi' => number_format($giaMoi, 2, '.', ''),
                'giacu' => number_format($giaCu, 2, '.', ''),
                'trangthai' => 1,
                'hang_id' => $hang_id,
                'danhmuc_id' => $danhmuc_id,
                'chuyenmuc_id' => $chuyenmuc_id,
               
            ];
        }

        DB::table('sanpham')->insert($products);
    }
}
