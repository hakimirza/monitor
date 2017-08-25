# CAPI-STIS : Modul Monitoring Survei #
>Merupakan salah satu modul aplikasi berbasis web di dalam sistem manajemen survei bernama CAPI-STIS. Aplikasi ini berfungsi untuk melakukan monitoring pada saat pengumpulan data berlangsung. Monitoring di sini dilaksanakan berdasar data yang masuk di setiap level wilayah.

## Persyaratan ##
Aplikasi ini dikembangkan menggunakan backend _**PHP**_ dengan _**Codeigniter**_ sebagai framework. Petunjuk penggunaan Codeigniter dapat di lihat pada [User Guide CI](https://www.codeigniter.com/user_guide/).
Kemudian berikut ini adalah beberapa software yang dibutuhkan. Instruksi instalasi software berikut dapat ditemukan di situs masing-masing (klik pada link):

- Java versi 8 : [Java](https://java.com/en/download/)
- Server aplikasi : [XAMPP](https://www.apachefriends.org/download.html) , kemudian pilih `MySQL` sebagai DBMS saat instalasi
- Server ODK : [Open Data Kit (ODK) Aggregate](https://opendatakit.org/use/aggregate)
- Transfer data ODK : [ODK Briefcase](https://opendatakit.org/downloads/download-category/briefcase/)

Pastikan semua aplikasi di atas sudah terinstal sebelum melanjutkan ke tahap berikutnya

## Instalasi ##
Instalasi di sini adalah untuk keperluan pengembangan modul monitoring ini saja. Perihal instalasi sistem CAPI-STIS secara keseluruhan, akan datang menyusul.

### 1. Download/Clone ###
- Download atau lakukan clone dari GIT STIS. Pada [link ini](https://git.stis.ac.id/hakimirza/monitor).
- Buat sebuah folder untuk tempat source code project di dalam *../xampp/htdocs/* , lalu ekstrak hasil download/clone ke dalam folder tersebut

### 2. Inisiasi Database ###
- Ekstrak file `monitor.rar` ke dalam folder *../xampp/mysql/data/*
- Pada folder project, buka file `database.php` di dalam folder *application/config/*
- Pada array `$db['default']`, ubah nilai pada key `hostname`, `username`, `password`, dan `database` masing-masing dengan _localhost_ atau _localhost:[angka port]_ (jika server MySQL anda menggunakan port), _username MySQL_, _password MySQL_, dan _nama database_ (pada kasus ini `monitor.rar` secara default memiliki nama database : _monitor_). Gunakan tanda petik (```''```) untuk penulisan setiap nilai. 
- Biarkan baris lain pada file `database.php` dalam keadaan default, **simpan**.

    ```php
    $db['default'] = array(
    	'dsn'	=> '',
    	'hostname' => 'localhost',
    	'username' => 'root',
    	'password' => 'root',
    	'database' => 'monitor',
	...
    ```
    
### 3. Persiapan Data Uji Coba ###
#### Upload Form Kuesioner ####
- Jalankan server **Tomcat** (hasil rangkaian instalasi ODK Aggregate), dan buka ```localhost:8080/ODKAggregate/``` pada browser
- Upload form `SUSENAS-geo2.xml` dari dalam folder `form` ke ODK Aggregate, dengan mengakses tab _Form Management_ -> _Form List_ -> _Add New Form_
![aggregate](https://git.stis.ac.id/hakimirza/monitor/uploads/54f4f091d1f9c5c624def14a47e9513d/aggregate.PNG)

- File form hasil upload akan memiliki nama **SUSENAS 16**

#### Transfer Data Uji Coba ####
- Buka file dengan ekstensi `.jar` dari hasil download `Briefcase`
- Tekan tombol `Connect`, lalu isikan `url` pada dialog yang muncul dengan `https://capi55-007.appspot.com`, tekan tombol `Connect` pada dialog. Seperti pada gambar berikut :
![briefcase](https://git.stis.ac.id/hakimirza/monitor/uploads/113dd1ed7ed812b1d7750d268f1ba0df/briefcase.PNG)

- Pilih **SUSENAS 16** dengan mencentang pada _checkbox_ , lalu tekan tombol `Pull` dan tunggu proses hingga *SUCCESS*
![briefcase2](https://git.stis.ac.id/hakimirza/monitor/uploads/2e4634152d6161f3ceed5a86e2edc840/briefcase2.PNG)

- Setelah data berhasil di-pull, lakukan push ke server ODK Aggregate lokal. 
Pilih  tab `Push` -> `Connect` -> pada dialog yang muncul isi `URL` dengan url ODK Aggregate lokal, kemudian `Username` dan `Password` (jika ada) ODK Aggregate lokal -> `Connect`.
Kemudian pilih form **SUSENAS 16** yang sudah diupload sebelumnya -> tekan `Push`
![briefcase3](https://git.stis.ac.id/hakimirza/monitor/uploads/d25d65fc91b4c267a2b61a1f07f0eebd/briefcase3.PNG)

## Menjalankan Aplikasi ##
- Aktifkan Server **Tomcat** (hasil rangkaian instalasi ODK Aggregate), pastikan halaman ```localhost:8080/ODKAggregate/``` pada browser menampilkan halaman utama ODK Aggregate.
- Buka url project monitoring anda, misal `localhost/monitor` pada browser.
- Aplikasi memiliki tiga fitur utama yakni : 
-- Dasbor
-- Detail Progres
-- Tabulasi
- Untuk panduan _end user_ dan informasi lebih lanjut, silakan lihat pada [wiki](https://git.stis.ac.id/hakimirza/monitor/wikis)

## Dibangun dengan ##
- [PHP 5.6.15](http://php.net/manual/en/intro-whatis.php)
- [CodeIgniter Version 3.1.4](https://www.codeigniter.com/user_guide/)
- [Bootstrap](https://getbootstrap.com/)
- [Leaflet](http://leafletjs.com/)
- [PivotTable.js](https://pivottable.js.org/examples/)
