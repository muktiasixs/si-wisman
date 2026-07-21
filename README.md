# 🌍 SI-WISMAN (Sistem Informasi Wisatawan Mancanegara)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Groq](https://img.shields.io/badge/Groq_AI-F59E0B?style=for-the-badge&logo=openai&logoColor=white)
![Leaflet](https://img.shields.io/badge/Leaflet-199900?style=for-the-badge&logo=leaflet&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

**SI-WISMAN** adalah aplikasi purwarupa (dashboard) berbasis web yang dikembangkan untuk memonitor, menganalisis, dan merekapitulasi data kunjungan wisatawan mancanegara ke Indonesia. Aplikasi ini dilengkapi dengan visualisasi pemetaan interaktif, grafik statistik, dan asisten AI yang cerdas.

## ✨ Fitur Utama

- 🗺️ **Peta Interaktif (GeoMap):** Memvisualisasikan asal negara wisatawan menggunakan **Leaflet.js** dengan batas wilayah yang telah dikalibrasi (anti-repetisi).
- 📊 **Visualisasi Data:** Menampilkan tren data menggunakan **Highcharts** (Bar Chart untuk Top 5 Negara & Pie Chart untuk Proporsi Bulanan).
- 🤖 **Asisten AI Cerdas:** Terintegrasi langsung dengan API **Groq (LLaMA 3.3 70B)** untuk memberikan analisis data secara instan dalam format chat interaktif. Mampu menangani _High Demand_ secara otomatis.
- 📋 **Tabel Dinamis:** Manajemen data rekapitulasi secara *real-time* menggunakan **DataTables** yang sangat cepat dan responsif.
- 🎨 **Desain Modern:** Menggunakan perpaduan **Bootstrap 5** dan CSS khusus untuk menciptakan antarmuka korporat yang elegan (Warna Kemenlu).

## 🚀 Teknologi yang Digunakan

- **Backend:** Laravel 11, PHP 8+
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Library Tambahan:** 
  - Leaflet.js (Peta GeoJSON)
  - Highcharts.js (Grafik)
  - DataTables (Tabel Data)
  - SweetAlert2 (Notifikasi)
  - FontAwesome (Ikon)
- **AI Engine:** Groq API (LLaMA 3) / Gemini API (Fallback)

## 🛠️ Instalasi & Setup Lokal

1. **Clone Repositori**
   ```bash
   git clone https://github.com/muktiasixs/si-wisman.git
   cd si-wisman
   ```

2. **Install Dependensi PHP & NPM**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Konfigurasi Environment**
   - Salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   - Generate *Application Key*.
   ```bash
   php artisan key:generate
   ```
   - Atur konfigurasi database di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=wisatawan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Konfigurasi API Key (AI)**
   - Dapatkan API Key gratis di [console.groq.com](https://console.groq.com).
   - Masukkan ke dalam file `.env`:
   ```env
   GROQ_API_KEY=gsk_koderahasiakamu
   ```

5. **Migrasi dan Seeder (Database)**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di: `http://localhost:8000`

## 📦 Deployment (Railway / Vercel)

Aplikasi ini sudah dioptimalkan untuk di-deploy ke layanan cloud seperti **Railway.app**. 
- Pastikan menambah variabel `.env` di menu *Variables* Railway.
- Karena aplikasi ini menggunakan MySQL, *deployment* sangat disarankan menggunakan Railway atau platform yang menyediakan database (bukan layanan *Serverless* murni tanpa DB).

---
*Dibuat untuk mempermudah analisis data pariwisata secara modern dan cerdas.*
