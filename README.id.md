
## Instalasi

Untuk menyiapkan kode untuk pengembangan lokal dari sumber GitHub, ikuti langkah-langkah berikut:

1. **Klon Repositori**: Jalankan `git clone https://github.com/turahe/backend-test.git` di terminal Anda.

2. **Navigasikan ke Direktori**: Ubah ke direktori proyek menggunakan perintah `cd backend-test`.

3. **Instal Dependensi**: Jalankan `composer install` untuk menginstal dependensi PHP.

4. **Siapkan File Lingkungan**: Salin `.env.example` ke `.env` dengan `cp .env.example .env`.

5. **Buat Kunci Aplikasi**: Gunakan `php artisan key:generate`.

6. **Siapkan Basis Data**: Konfigurasikan pengaturan basis data Anda di file `.env`.

7. **Jalankan Migrasi dan seed data dummy**: Jalankan `php artisan migrate:seed` untuk menyiapkan skema basis data Anda.
8. **Buat dokumen api**: Gunakan `php artisan scribe:generate`. Dapat diakses melalui <http://localhost:8000/docs>
9. **Layani Aplikasi**: jalankan `php artisan serve` untuk memulai server pengembangan lokal <http://localhost:8000>.
10. **Lihat hasil unit test**: Jalankan perintah `php artisan test` atau `./vendor/bin/phpunit --testdox` untuk mengecek hasil unit test

## pilihan desain yang saya buat dan teknik penyetelan performa yang saya terapkan

Menggunakan cache untuk mengoptimalkan query di Backed Test sangat penting untuk meningkatkan performa dan mengurangi beban pada database. Berikut alasan mengapa caching bisa sangat bermanfaat dalam konteks ini:

### 1. **Mengurangi Beban pada Database**:
- Menjalankan query yang sama secara berulang-ulang dapat menghabiskan banyak sumber daya, terutama jika database Anda besar atau jika ada banyak pengguna yang mengakses sistem secara bersamaan.
- Dengan menyimpan hasil query ke dalam cache, Anda dapat mengurangi jumlah query yang dikirim ke database, sehingga mengurangi beban pada database dan meningkatkan performanya secara keseluruhan.

### 2. **Waktu Respons Lebih Cepat**:
- Mengambil data dari cache jauh lebih cepat daripada menjalankan query ke database, karena data yang disimpan di cache berada di memori (misalnya, Redis atau Memcached) yang dapat diakses lebih cepat daripada melakukan query ke database.
- Ini akan menghasilkan waktu muat halaman yang lebih cepat dan pengalaman pengguna yang lebih baik.

### 3. **Meningkatkan Skalabilitas**:
- Ketika aplikasi Anda berkembang dan semakin banyak pengguna yang berinteraksi dengannya, database bisa menjadi bottleneck.
- Dengan menggunakan caching, Anda memungkinkan sistem untuk menangani lebih banyak permintaan tanpa harus selalu melakukan query ke database, membuat aplikasi Anda lebih mudah diskalakan.

### 4. **Mengurangi Query yang Berat**:
- Beberapa query (misalnya, query yang melibatkan join yang kompleks, agregasi, atau perhitungan) bisa sangat berat dan memakan banyak waktu serta sumber daya.
- Dengan menyimpan hasil dari query-query yang berat ini ke dalam cache, Anda bisa menghindari beban kinerja yang ditimbulkan oleh eksekusi berulang.

### 5. **Mengurangi Panggilan API Eksternal**:
- Jika query Anda melibatkan pengambilan data dari API eksternal, caching dapat mencegah Anda melakukan panggilan API yang berulang, mengurangi latensi dan risiko melebihi batas panggilan API.

### 6. **Pengaturan Expiration pada Cache**:
- Backed Test menyediakan mekanisme untuk mengatur waktu kedaluwarsa (expiration time) dari data cache, sehingga data yang disimpan tetap segar dan konsisten dengan database tanpa perlu dihapus secara manual.
- Anda bisa mengatur durasi cache sesuai dengan seberapa sering data tersebut berubah.

### Contoh: Menggunakan Cache di Backed Test untuk Query
Dengan menggunakan `Cache` facade di Backed Test, Anda bisa dengan mudah menyimpan hasil query ke dalam cache:

```php
use Illuminate\Support\Facades\Cache;

$authors = Cache::remember('authors', 60, function () {
            return Author::paginate(12);
        });
```

Pada contoh di atas:
- Metode `remember` akan memeriksa apakah data dengan kunci `authors` sudah ada di cache. Jika belum ada, maka query akan dijalankan dan hasilnya disimpan ke dalam cache selama 60 menit.

Dengan cara ini, permintaan berikutnya akan mengambil data dari cache, bukan dari database, sehingga performa akan meningkat secara signifikan.

### Jenis-jenis Cache yang Umum Digunakan di Backed Test:
- **File**: Menyimpan data cache di sistem file.
- **Database**: Menyimpan data cache di tabel database.
- **Redis**: Penyimpanan kunci-nilai di memori, sangat cepat dan ideal untuk performa tinggi.
- **Memcached**: Sistem cache lain yang cepat di memori.

### Kesimpulan:
Menggunakan cache untuk mengoptimalkan query di Backed Test adalah cara efektif untuk meningkatkan performa, mengurangi beban pada database, dan meningkatkan skalabilitas, terutama untuk query yang berat atau sering diulang.
