<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hang;
use App\Models\DanhMuc;

class HangDanhMucSeeder extends Seeder
{
    public function run(): void
    {
   

        DanhMuc::insert([
            ['tendanhmuc' => 'Laptop Gaming', 'mota' => 'Dành cho game thủ'],
            ['tendanhmuc' => 'Laptop Văn Phòng', 'mota' => 'Nhẹ, bền, pin lâu'],
            ['tendanhmuc' => 'Phụ kiện', 'mota' => 'Bàn phím, chuột, tai nghe'],
        ]);
    }
}
