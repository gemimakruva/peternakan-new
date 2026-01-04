# Smart Poultry Management System (SPMS)

## Tech Stack
- Laravel 12
- AdminLTE 4, with jeroennoten/laravel-adminlte
- Laravel Module, with nwidart/laravel-modules
- Implement RBAC, with spatie/laravel-permission

## Available User
- Superadmin
    - email : superadmin@peternakan.com
    - password : password
- Admin User
    - email : admin-user@peternakan.com 
    - password : password
- Petugas Kandang
    - email : petugas-kandang@peternakan.com
    - password : password

## Penggunaan Blade Laravel Template
- gunakan resources/views/components/form-alert.blade.php untuk menampilkan alert hasil aksi mutasi data
- gunakan resources/views/components/pagination.blade.php untuk menampilkan link paginasi pada tiap table
- gunakan resources/views/layouts/dashboard.blade.php untuk @extends base layout page aplikasi