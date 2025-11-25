# Automated Content Aggregator & Dashboard (Microservices dengan Docker)

Proyek ini mendemonstrasikan arsitektur Microservices menggunakan Docker Compose (simulasi via skrip terpisah) untuk membuat pipeline otomatis: mengambil data (jokes Chuck Norris) dari API, memprosesnya, menyimpannya ke MySQL, dan menampilkannya di dashboard PHP.

## ⚙️ Komponen Arsitektur

| Nama Container | Tugas Utama | Teknologi |
| mysql1 | Penyimpanan data terstruktur (Jokes Database). | mysql:8.0-debian |
| myprocess1 | Collector (Scraping/API Fetch). Mengambil data dari API eksternal. | alpine:3.18, getjokes.sh |
| processor1 | Processor (ETL/Impor). Membaca file teks, memproses, dan memasukkannya ke MySQL. | python:3.9-slim, importer.py |
| webserver1 | Frontend/Dashboard. Mengambil data langsung dari MySQL dan menampilkannya. | php:7.4-apache, index.php |

## 🚀 Panduan Menjalankan (Otomatisasi)
Asumsikan semua file (.sh, .py, .php, init.sql) sudah berada di struktur folder yang benar.

### Prasyarat
1. Docker sudah terinstal di sistem Ubuntu.
2. User Anda telah ditambahkan ke grup docker (atau gunakan sudo untuk semua perintah).

### Langkah 1: Bersihkan Lingkungan (Reset Factory)
Untuk memastikan semua container lama dan data MySQL di-reset, jalankan perintah ini:
```
# 1. Matikan dan hapus semua container
sudo docker rm -f $(sudo docker ps -aq)

# 2. Hapus Network lama
sudo docker network rm mynet

# 3. Hapus data database lokal (PENTING: untuk menjalankan init.sql)
sudo rm -rf dbdata
```


### Langkah 2: Buat & Jalankan Services
Jalankan skrip-skrip berikut secara berurutan. Semua layanan akan dimasukkan ke network yang sama (mynet) agar bisa saling berkomunikasi menggunakan nama host.

#### A. Inisialisasi Network
```
docker network create mynet
```

#### B. Jalankan MySQL (Database)
Database akan membuat skema tabel secara otomatis dari init.sql.
```
sudo ./run_mysql.sh
```

#### C. Jalankan Processor (Python ETL)
Jembatan yang akan memindahkan data dari file ke database.
```
sudo ./run_processor.sh
```

#### D. Jalankan Webserver (Dashboard Frontend)
Webserver PHP siap menampilkan data di port 8080.
```
sudo ./run_simple_web.sh
```

#### E. Jalankan Collector (Data Feeder)
Ini adalah "kran data" yang mulai mendownload jokes ke folder files/.
```
sudo ./run_process.sh
```


Langkah 3: Akses Aplikasi
Buka browser Anda dan akses alamat berikut:
👉 Dashboard Aplikasi: http://localhost:8080
Anda akan melihat data jokes bertambah secara otomatis setiap 8 detik (setelah diambil oleh myprocess1 dan diproses oleh processor1).
🛑 Cara Menghentikan Semua Services
Untuk menghentikan semua service yang berjalan di latar belakang:
sudo docker stop $(sudo docker ps -q)

