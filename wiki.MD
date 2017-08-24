# CAPI-STIS : Modul Monitoring Survei #
>Berikut ini adalah **user guide** aplikasi dari sisi **end-user**.
Setiap data pencacahan yang ditampilkan tiap halaman diperbarui otomatis secara real-time.

## Login ##
Terdapat tiga kategori pengguna yang ditangani sistem ini dari segi level wilayahnya. Proses pembuatan pengguna dilakukan pada modul manajemen survei (di luar modul ini).
Kategori pengguna :
- Nasional (pusat)
- Provinsi
- Kabupaten

Login dilakukan dengan mengisikan `Email` dan `Password`
![login](https://git.stis.ac.id/hakimirza/monitor//uploads/c5afa463723c69b9d5ced4819e2768b5/login.PNG)

## Home ##
Halaman **Home** adalah halaman yang pertama ditampilkan setelah login berhasil. Konten utama halaman ini berisi tabel survei yang tersedia bagi pengguna untuk dimonitoring lengkap dengan fitur *sorting*, *pagination*, dan *search*.
Pada tabel, di samping kolom `Nama Survei`, setiap baris berisi:
- `Status` : Berisi label *Aktif* atau *Selesai* sebagai tanda apakah pengumpulan data masih berlangsung
- `Progres Nasional` : Progres input data secara keseluruhan (Nasional)
- `Progres Daerah` : Progres input data pada cakupan monitoring pengguna

Informasi lain pada halaman **Home** adalah berupa nama pengguna yang sedang login serta daerah monitoringnya. Pada bagian kanan atas terdapat jam dan avatar pengguna yang bisa diklik untuk menampilkan tombol Log out.
![home](https://git.stis.ac.id/hakimirza/monitor/uploads/e11736ba490e1247a1fd5aab42de2882/home.PNG)
Untuk melakukan navigasi ke halaman berikutnya, diawali dengan melakukan klik pada tombol di kolom terakhir salah satu baris pada tabel. Terdapat tiga halaman yang bisa dipilih, yakni : **Dasbor**, **Detail Progres**, dan **Tabulasi**
![homeNav](https://git.stis.ac.id/hakimirza/monitor/uploads/13297e3deaf1a030b6898524f31bdb89/homeNav.PNG)

## Dasbor ##
Halaman **Dasbor** berfungsi untuk menampilkan informasi umum mengenai survei yang berlangsung di daerah monitoring pengguna, di antara lain :
- Input dan target pencacahan
- Presentase progres input
- Presentase alokasi waktu yang terpakai hingga saat itu
- *Countdown* hingga deadline pencacahan
- Pie chart Ketersediaan Responden (Berhasil dicacah, tidak dapat ditemui, menolak)
- Peta progres input dan *checkbox* untuk menampilkan posisi responden di peta
![dasborup](https://git.stis.ac.id/hakimirza/monitor/uploads/4374a82570c91ea33f55d8cd516f9b20/dasborup.png)

Di bagian bawah dasbor terdapat dua *line chart* :
- Line chart kuesioner masuk per hari
- Line chart rata-rata durasi wawancara antar responden per hari (menit)

![dasbordown](https://git.stis.ac.id/hakimirza/monitor/uploads/e39d44931947d9ab606117095c0f870e/dasbordown.png)

## Detail Progres ##
Halaman **Detail Progres** atau Progres berfungsi untuk mengakses informasi progres pencacahan di daerah monitoring pengguna dan daerah-daerah di bawahnya. Terdapat dua bagian utama yakni **Tabel Progres** dan **Peta Progres Input**.
![progres1](https://git.stis.ac.id/hakimirza/monitor/uploads/0f9b87a74ccb9844d43f7fcba2a7dc92/progres1.png)

Pada tabel, pengguna dapat melakukan klik pada baris yang dikehendaki untuk melihat informasi daerah di dalamnya. Pada contoh di atas pengguna melakukan klik pada baris `KOTA JAKARTA TIMUR` , kemudian halaman menampilkan data lokus di bawah Jakarta Timur sebagai berikut :
![progres2](https://git.stis.ac.id/hakimirza/monitor/uploads/7f5870fc20d28f5c611f754dc5a74de2/progres2.png)

Untuk navigasi, dapat memanfaatkan *breadcrumb* di kanan atas tabel, dengan contoh sebagai berikut:
![breadcrumbs](https://git.stis.ac.id/hakimirza/monitor/uploads/cbaa6bc4fb1f3e4572558670dfc39f3a/breadcrumbs.PNG)
*Breadcrumb* di atas menginformasikan bahwa pengguna sedang mengakses informasi untuk wilayah Jatinegara, di bawah Kota Jakarta Timur, di bawah DKI Jakarta. Pengguna dapat melakukan klik pada salah satu wilayah tersebut untuk melakukan navigasi halaman ke sana.

Berikut ini adalah *alert* yang muncul jika data peta tidak tersedia atau gagal didownload:
![progresErr](https://git.stis.ac.id/hakimirza/monitor/uploads/4c35814ccececa18cf53cf8d6a8001ad/progresErr.png)

## Tabulasi ##
Halaman **Tabulasi** berfungsi untuk melakukan tabulasi data pencacahan secara real-time. Tujuan utama adalah untuk mendeteksi kewajaran data yang masuk melalui variabel-variabel tertentu pada kuesioner, sesuai dengan preferensi pengguna. Tabulasi dilakukan dengan *drag and drop* variabel ke field baris atau kolom yang disediakan.
Berikut ini contoh tabulasi variabel `P101` dan `izin` pada baris dan `P109` pada kolom:
![tabulasi](https://git.stis.ac.id/hakimirza/monitor/uploads/93d35d7d7efefda75c6fd272c35ddb1f/tabulasi.png)

Terdapat tombol-tombol di bagian atas lembar kerja tabulasi. Di antaranya pada bagian kiri terdapat tombol `Bersihkan Tabel` untuk mereset lembar kerja tabulasi dan `Undo-Redo` :
![tabulasileftmenu](https://git.stis.ac.id/hakimirza/monitor/uploads/b91501e19abbb98c2fee496f0914a873/tabulasileftmenu.PNG)
Tombol `Bersihkan tabel` akan memberikan dialog konfirmasi terlebih dahulu ketika diklik :
![cleartabel](https://git.stis.ac.id/hakimirza/monitor/uploads/c604b595e49b4e422b5c9cae4fefcd3a/cleartabel.PNG)

Kemudian pada bagian kanan terdapat 4 tombol :
- `Muat ulang data`, untuk melakukan *refresh* jika dirasa data belum diperbarui otomatis
- `Simpan tabulasi`, untuk menyimpan lembar kerja tabulasi
- `Buka Tabulasi`, untuk memuat ulang lembar kerja yang pernah disimpan sebelumnya
- `Ekspor ke TSV`, untuk mengubah hasil tabulasi ke bentuk *Tab Separated Value (TSV)* sehingga dapat di-*copy-paste* ke spreadshet dengan mudah.

Tampilan dialog saat dilakukan klik pada tombol `Simpan tabulasi`:
![savetabel](https://git.stis.ac.id/hakimirza/monitor/uploads/5724ebcf58a70198e532e32901bd5b1b/savetabel.PNG)

Tampilan dialog saat dilakukan klik pada tombol `Buka tabulasi`:
![opentabel](https://git.stis.ac.id/hakimirza/monitor/uploads/0d7447e9e4505ed7ef64f926d723135b/opentabel.PNG)

Fitur ekspor TSV dapat diakses juga melalui dropdown di sebelah kiri lembar kerja tabulasi dengan memilih `TSV Export`:
![tabulasiekspor](https://git.stis.ac.id/hakimirza/monitor/uploads/bb6111c7eb987d5af39d9ba93301e3eb/tabulasiekspor.png)
Saat `Ekspor ke TSV` diaktifkan, *output* tabulasi akan berubah menjadi *textfield* berisi data TSV dari *output* tabulasi yang padanya bisa dilakukan operasi teks seperti biasa (write, delete, copy-paste).
![tabulasiekspor2](https://git.stis.ac.id/hakimirza/monitor/uploads/ca3362fec242a22fa1abbe28213b0385/tabulasiekspor2.png)

Berikutnya adalah dropdown `Tipe Dataset` adalah untuk menentukan variabel yang diakses untuk tabulasi berdasar dua jenis dataset dari kuesioner yang digunakan pada survei itu. Dataset `Grup` adalah dataset untuk variabel-variabel grup / non-roster, misalnya variabel *rumah tangga*. Kemudian dataset `Individu` adalah dataset yang sudah disesuaikan memuat variabel per individu, misalnya variabel *anggota rumah tangga*.
![tabulasirightmenu](https://git.stis.ac.id/hakimirza/monitor/uploads/d90f1a3b80fd02e5a4752dd599784867/tabulasirightmenu.PNG)
