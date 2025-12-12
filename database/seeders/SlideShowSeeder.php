<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                DB::table('slideshow')->insert([
            [
                'tenfile' => 'bia_1.jpg',
                'trangthai' => 1,
            ],
            [
                'tenfile' => 'bia_2.jpg',
                'trangthai' => 1,
               ],
        ]);
    }
}
