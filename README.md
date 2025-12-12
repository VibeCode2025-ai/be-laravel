<!-- <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). -->

```
├── 📁 .scribe
│   ├── 📁 endpoints
│   │   ├── ⚙️ 00.yaml
│   │   └── ⚙️ custom.0.yaml
│   ├── ⚙️ .filehashes
│   ├── 📝 auth.md
│   └── 📝 intro.md
├── 📁 app
│   ├── 📁 Events
│   │   └── 🐘 NewMessage.php
│   ├── 📁 Http
│   │   ├── 📁 Controllers
│   │   │   ├── 🐘 AccountController.php
│   │   │   ├── 🐘 AuthController.php
│   │   │   ├── 🐘 BinhLuanController.php
│   │   │   ├── 🐘 ChatController.php
│   │   │   ├── 🐘 ChatbotController.php
│   │   │   ├── 🐘 ChuyenMucController.php
│   │   │   ├── 🐘 Controller.php
│   │   │   ├── 🐘 DanhMucController.php
│   │   │   ├── 🐘 DonHangController.php
│   │   │   ├── 🐘 GoogleController.php
│   │   │   ├── 🐘 HangController.php
│   │   │   ├── 🐘 KhachHangController.php
│   │   │   ├── 🐘 KhoController.php
│   │   │   ├── 🐘 SanPhamController.php
│   │   │   ├── 🐘 SlideShowController.php
│   │   │   └── 🐘 VnpayController.php
│   │   ├── 📁 Middleware
│   │   │   ├── 🐘 AdminMiddleware.php
│   │   │   ├── 🐘 Cors.php
│   │   │   └── 🐘 KhachHangMiddleware.php
│   │   └── 🐘 Kernel.php
│   ├── 📁 Mail
│   │   └── 🐘 LoginNotification.php
│   ├── 📁 Models
│   │   ├── 🐘 BinhLuan.php
│   │   ├── 🐘 ChiTietDonHang.php
│   │   ├── 🐘 ChuyenMuc.php
│   │   ├── 🐘 DanhMuc.php
│   │   ├── 🐘 DonHang.php
│   │   ├── 🐘 Hang.php
│   │   ├── 🐘 Kho.php
│   │   ├── 🐘 Message.php
│   │   ├── 🐘 PendingOrder.php
│   │   ├── 🐘 SanPham.php
│   │   ├── 🐘 SlideShow.php
│   │   └── 🐘 TaiKhoan.php
│   └── 📁 Providers
│       └── 🐘 AppServiceProvider.php
├── 📁 bootstrap
│   ├── 🐘 app.php
│   └── 🐘 providers.php
├── 📁 config
│   ├── 🐘 app.php
│   ├── 🐘 auth.php
│   ├── 🐘 broadcasting.php
│   ├── 🐘 cache.php
│   ├── 🐘 cors.php
│   ├── 🐘 database.php
│   ├── 🐘 filesystems.php
│   ├── 🐘 logging.php
│   ├── 🐘 mail.php
│   ├── 🐘 queue.php
│   ├── 🐘 sanctum.php
│   ├── 🐘 services.php
│   ├── 🐘 session.php
│   └── 🐘 vnpay.php
├── 📁 database
│   ├── 📁 factories
│   │   └── 🐘 UserFactory.php
│   ├── 📁 migrations
│   │   ├── 🐘 0001_01_01_000001_create_cache_table.php
│   │   ├── 🐘 0001_01_01_000002_create_jobs_table.php
│   │   ├── 🐘 2025_10_14_080046_create_taikhoan_table.php
│   │   ├── 🐘 2025_10_14_103119_create_personal_access_tokens_table.php
│   │   ├── 🐘 2025_10_23_133319_create_hangs_table.php
│   │   ├── 🐘 2025_10_23_133512_create_danh_mucs_table.php
│   │   ├── 🐘 2025_10_23_140122_add_hang_danhmuc_to_sanpham_table.php
│   │   ├── 🐘 2025_10_23_143543_add_foreign_keys_to_danhmuc_table.php
│   │   ├── 🐘 2025_10_24_061543_dropunique.php
│   │   ├── 🐘 2025_10_28_102300_chuyenmuc.php
│   │   ├── 🐘 2025_11_06_192033_create_binhluan_table.php
│   │   ├── 🐘 2025_11_08_230836_create_pending_orders_table.php
│   │   └── 🐘 2025_11_12_190857_create_messages_table.php
│   ├── 📁 seeders
│   │   ├── 🐘 DatabaseSeeder.php
│   │   ├── 🐘 HangDanhMucSeeder.php
│   │   ├── 🐘 SanPhamSeeder.php
│   │   ├── 🐘 SlideShowSeeder.php
│   │   └── 🐘 TaiKhoanSeeder.php
│   ├── ⚙️ .gitignore
│   └── 📄 database.sqlite
├── 📁 public
│   ├── ⚙️ .htaccess
│   ├── 📄 favicon.ico
│   ├── 🐘 index.php
│   └── 📄 robots.txt
├── 📁 resources
│   ├── 📁 css
│   │   └── 🎨 app.css
│   ├── 📁 js
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   └── 📁 views
│       ├── 📁 emails
│       │   ├── 🌐 index.html
│       │   └── 🐘 login.blade.php
│       ├── 📁 scribe
│       │   └── 🐘 index.blade.php
│       └── 🐘 welcome.blade.php
├── 📁 routes
│   ├── 🐘 api.php
│   ├── 🐘 channels.php
│   ├── 🐘 console.php
│   └── 🐘 web.php
├── 📁 storage
│   ├── 📁 app
│   │   ├── 📁 private
│   │   │   ├── 📁 public
│   │   │   │   └── 📁 img
│   │   │   │       ├── 🖼️ 1762462987_img_avatar2.png
│   │   │   │       ├── 🖼️ 1762581803_logo-acer-inkythuatso-2-01-27-15-50-00.jpg
│   │   │   │       ├── 🖼️ 1762582259_account.png
│   │   │   │       ├── 🖼️ 1762582830_account.png
│   │   │   │       ├── 🖼️ 1762583027_account.png
│   │   │   │       ├── 🖼️ 1762583324_fb.jpg
│   │   │   │       ├── 🖼️ 1762583643_account.png
│   │   │   │       ├── 🖼️ 1762584193_account.png
│   │   │   │       ├── 🖼️ Acer-Predator-Triton.jpg
│   │   │   │       ├── 🖼️ Air-M2.jpg
│   │   │   │       ├── 🖼️ MSI.jpg
│   │   │   │       ├── 🖼️ TUF.png
│   │   │   │       ├── 🖼️ TUFGM2.jpg
│   │   │   │       ├── 🖼️ account.png
│   │   │   │       ├── 🖼️ dohoa.webp
│   │   │   │       ├── 🖼️ fb.jpg
│   │   │   │       ├── 🖼️ gaming.webp
│   │   │   │       ├── 🖼️ image_101.png
│   │   │   │       ├── 🖼️ image_102.png
│   │   │   │       ├── 🖼️ image_179.png
│   │   │   │       ├── 🖼️ image_198.png
│   │   │   │       ├── 🖼️ image_217.png
│   │   │   │       ├── 🖼️ image_22.png
│   │   │   │       ├── 🖼️ image_269.png
│   │   │   │       ├── 🖼️ image_27.png
│   │   │   │       ├── 🖼️ image_271.png
│   │   │   │       ├── 🖼️ image_282.png
│   │   │   │       ├── 🖼️ image_29.png
│   │   │   │       ├── 🖼️ image_290.png
│   │   │   │       ├── 🖼️ image_292.png
│   │   │   │       ├── 🖼️ image_297.png
│   │   │   │       ├── 🖼️ image_30.png
│   │   │   │       ├── 🖼️ image_347.png
│   │   │   │       ├── 🖼️ image_353.png
│   │   │   │       ├── 🖼️ image_354.png
│   │   │   │       ├── 🖼️ image_355.png
│   │   │   │       ├── 🖼️ image_357.png
│   │   │   │       ├── 🖼️ image_362.png
│   │   │   │       ├── 🖼️ image_423.png
│   │   │   │       ├── 🖼️ image_425.png
│   │   │   │       ├── 🖼️ image_460.png
│   │   │   │       ├── 🖼️ image_490.png
│   │   │   │       ├── 🖼️ image_517.png
│   │   │   │       ├── 🖼️ image_524.png
│   │   │   │       ├── 🖼️ image_526.png
│   │   │   │       ├── 🖼️ image_538.png
│   │   │   │       ├── 🖼️ image_539.png
│   │   │   │       ├── 🖼️ image_549.png
│   │   │   │       ├── 🖼️ image_556.png
│   │   │   │       ├── 🖼️ image_578.png
│   │   │   │       ├── 🖼️ image_585.png
│   │   │   │       ├── 🖼️ image_591.png
│   │   │   │       ├── 🖼️ image_596.png
│   │   │   │       ├── 🖼️ image_602.png
│   │   │   │       ├── 🖼️ image_604.png
│   │   │   │       ├── 🖼️ image_608.png
│   │   │   │       ├── 🖼️ image_637.png
│   │   │   │       ├── 🖼️ image_653.png
│   │   │   │       ├── 🖼️ image_670.png
│   │   │   │       ├── 🖼️ image_671.png
│   │   │   │       ├── 🖼️ image_85.png
│   │   │   │       ├── 🖼️ image_91.png
│   │   │   │       ├── 🖼️ img_avatar2.png
│   │   │   │       ├── 🖼️ sv.webp
│   │   │   │       ├── 🖼️ vanphong.webp
│   │   │   │       └── 🖼️ z7182124129154_88357ff28862be2790694964dd661a1d.jpg
│   │   │   ├── 📁 scribe
│   │   │   │   ├── ⚙️ collection.json
│   │   │   │   └── ⚙️ openapi.yaml
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 public
│   │   │   ├── 📁 image
│   │   │   │   ├── 🖼️ Acer-Predator-Triton.jpg
│   │   │   │   ├── 🖼️ Air-M2.jpg
│   │   │   │   ├── 🖼️ HP-VICTUS-16.jpg
│   │   │   │   ├── 🖼️ MSI-Stealth-17.jpg
│   │   │   │   ├── 🖼️ NDB.png
│   │   │   │   ├── 🖼️ TUFGM2.jpg
│   │   │   │   ├── 🖼️ bia_1.jpg
│   │   │   │   ├── 🖼️ bia_2.jpg
│   │   │   │   ├── 🖼️ bia_3.jpg
│   │   │   │   ├── 🖼️ dell-g15.jpg
│   │   │   │   ├── 🖼️ gigabyte-g5.jpg
│   │   │   │   ├── 🖼️ hp14s.jpg
│   │   │   │   ├── 🖼️ hp15s.jpg
│   │   │   │   ├── 🖼️ img_avatar2.png
│   │   │   │   ├── 🖼️ nitro-v.jpg
│   │   │   │   └── 🖼️ rog-scar.jpg
│   │   │   └── ⚙️ .gitignore
│   │   └── ⚙️ .gitignore
│   ├── 📁 framework
│   │   ├── 📁 sessions
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 testing
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 views
│   │   │   ├── ⚙️ .gitignore
│   │   │   ├── 🐘 062216ef405eea2cd974bf61417dfa7f.php
│   │   │   ├── 🐘 0893803fbcfa6a0275d0980ee84cf299.php
│   │   │   ├── 🐘 09a1ed79da2908a76a90235c9611afe4.php
│   │   │   ├── 🐘 14b3761b500f07e1236a0cd0ccb0d837.php
│   │   │   ├── 🐘 1862cd318a34c04aa0c1219877a04996.php
│   │   │   ├── 🐘 1e77b1ca202175d073956076057860f0.php
│   │   │   ├── 🐘 367f0bbc1c1ad55a805fbc4c1d1ba225.php
│   │   │   ├── 🐘 40671a54e42ded0ec120edb2084f497d.php
│   │   │   ├── 🐘 439d448ff288aed96c17e891b32660cf.php
│   │   │   ├── 🐘 4736168ff9515d70c62e1e27871ff670.php
│   │   │   ├── 🐘 4d848fa71a5b9438a41487cf7f2ac4e8.php
│   │   │   ├── 🐘 4f0edfc356fdcf29a8d04b7216160b01.php
│   │   │   ├── 🐘 51895d200d624ef3b4805e8e9676ebb1.php
│   │   │   ├── 🐘 57109c3936a869387a2003867a0001e6.php
│   │   │   ├── 🐘 62b8615df01049c6085549c86759b9ee.php
│   │   │   ├── 🐘 63f9752da5c11aa5bffd725a4710efec.php
│   │   │   ├── 🐘 70e54f625d73445e9146351b095fdc0a.php
│   │   │   ├── 🐘 76d4c192a1fc93340fc09b007b772eaa.php
│   │   │   ├── 🐘 7c1cb00558bbfe126d39fd97b584b80f.php
│   │   │   ├── 🐘 8767c46f7c8d821a688596efc7e13b58.php
│   │   │   ├── 🐘 8920c0a6f35b9d71b957e6590572a032.php
│   │   │   ├── 🐘 89fe02029c5879516cb039828c0fd8ce.php
│   │   │   ├── 🐘 8d6dfef12b6d5e0fc73c1b7c8f9fd44d.php
│   │   │   ├── 🐘 9049f3d940f8f0406ce3b9c0fed558b8.php
│   │   │   ├── 🐘 906a0d4eaa9b3b6a589d3611295c0fcd.php
│   │   │   ├── 🐘 93d04ec86f3db769a8821d6e4e166cde.php
│   │   │   ├── 🐘 96c21336f2ff51319d2030fcca071402.php
│   │   │   ├── 🐘 9843f198e2100703cde1e331f6dcb843.php
│   │   │   ├── 🐘 a05cffe48fb34615aace37d4786607ce.php
│   │   │   ├── 🐘 a5a6608a032f38ff425a29f4b52bbc84.php
│   │   │   ├── 🐘 a9feedac733b90398d49247a730aa97a.php
│   │   │   ├── 🐘 ac9b7ae2808121b421dd1a988c0510cd.php
│   │   │   ├── 🐘 b11ba4956630fbcd6051bad97aa17a23.php
│   │   │   ├── 🐘 ba2d9660078ab4b720da98dd182ece1f.php
│   │   │   ├── 🐘 c418cbfacec7a9365f5fa1d50c48ec5e.php
│   │   │   ├── 🐘 e076985e57f3f02ab1e04ce39eba158b.php
│   │   │   ├── 🐘 e53c54585b83d06236e364424dfc5a9f.php
│   │   │   ├── 🐘 ecfada59e82c88f3987124e421104839.php
│   │   │   ├── 🐘 edcfbc41c01b1aa37fd6da08653dbc0d.php
│   │   │   ├── 🐘 ee4f63aacd326570a4f3ec0718736b4d.php
│   │   │   ├── 🐘 f2ffc9b28f802c76cf7acb000062a649.php
│   │   │   ├── 🐘 fa7bb4abbbe916df83eca3138fe5b749.php
│   │   │   └── 🐘 fe4fbeee9fb84dc91da6530a0b58473c.php
│   │   └── ⚙️ .gitignore
│   └── 📁 logs
│       └── ⚙️ .gitignore
├── 📁 tests
│   ├── 📁 Feature
│   │   └── 🐘 ExampleTest.php
│   ├── 📁 Unit
│   │   └── 🐘 ExampleTest.php
│   └── 🐘 TestCase.php
├── ⚙️ .editorconfig
├── ⚙️ .env.example
├── ⚙️ .gitattributes
├── ⚙️ .gitignore
├── 📝 README.md
├── 📄 artisan
├── ⚙️ composer.json
├── ⚙️ package.json
├── ⚙️ phpunit.xml
├── 📄 vite.config.js
└── 📄 weblt.sql
```