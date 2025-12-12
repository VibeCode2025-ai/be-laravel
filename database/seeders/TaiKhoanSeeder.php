<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\Hash;
class TaiKhoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaiKhoan::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'), 
            'fullname' => 'Quản trị viên',
            'sdt' => '0909123456',
            'diachi' => 'TP. HCM',
            'email' => 'admin@example.com',
            'hoatdong' => 1,
            'loaiTK' => '1',
            'trangthai' => 1,
        ]);
        TaiKhoan::create([
            'username' => 'khachhang1',
            'password' => Hash::make('123456'),
            'fullname' => 'Nguyễn Văn A',
            'sdt' => '0987654321',
            'diachi' => 'Hà Nội',
            'email' => 'nva@example.com',
            'hoatdong' => 1,
            'loaiTK' => '2',
            'trangthai' => 1,
        ]);
    }
}
