# Data Warehouse Retail Online

Project ini merupakan website sederhana Data Warehouse untuk studi kasus toko retail online. Sistem memiliki fitur CRUD dimensi, CRUD tabel fakta, dan dashboard laporan penjualan.

## Fitur

- CRUD Dimensi Produk
- CRUD Dimensi Pelanggan
- Create Data Dimensi Waktu
- CRUD Tabel Fakta Penjualan
- Dashboard Data Warehouse
- Query laporan:
  - Total penjualan per produk
  - Tren penjualan per bulan
  - Pelanggan dengan belanja tertinggi

## Teknologi

- PHP Native
- MySQL
- XAMPP
- HTML
- CSS

## Cara Menjalankan Project

1. Clone repository ini ke folder `htdocs` XAMPP:

```bash
git clone https://github.com/Argantapramata/data-warehouse-retail-online.git
```

2. Jalankan XAMPP:

- Apache = Start
- MySQL = Start

3. Buka MySQL Workbench atau phpMyAdmin.

4. Buat database dengan nama:

```sql
CREATE DATABASE dw_retail_online;
```

5. Import file `database.sql` ke database `dw_retail_online`.

6. Pastikan konfigurasi database di file `config.php` seperti berikut:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "dw_retail_online";
```

7. Buka project di browser:

```text
http://localhost/data-warehouse-retail-online/
```

Jika folder project diubah namanya menjadi `dw_retail_online`, maka buka:

```text
http://localhost/dw_retail_online/
```

## Struktur Database

Database menggunakan Star Schema dengan tabel:

- `dim_produk`
- `dim_pelanggan`
- `dim_waktu`
- `fact_penjualan`

