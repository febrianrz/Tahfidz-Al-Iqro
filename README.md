- Santri
  - id
  - nama
  - gender
  - alamat
  - foto
  - biodata ...
  - status (Aktif, Lulus, Pendaftaran)
  - ...

- Halaqoh
  - id
  - nama
  - foto
  - status (Aktif / Tidak Aktif)

- Laporan 
  - id
  - id_santri
  - id_halaqoh
  - jenis_ujian (harian / tasmi / perjuz)
  - waktu_laporan
  - nilai (int) -> nullable
  - catatan

Laporan Tasmi
- ID    ID Santri     ID Halaqoh    Jenis       Juz           Nilai       Tanggal     Status
- 1     1               1           Harian      Juz 10        0 / NULL
- 2     1               1           Tasmi       Juz 10        80
- 3     1               1           Perjuz      Juz 8         0 / NULL




Berita:
- id
- judul       (String)
- thumbnail   (String)
- content     (Text)
- tags        (String)
- status      (String)

Profile:
- id      
- judul       (String)
- type        (String) (Profile Pesantren / Visi Pesantren / Misi Pesantren / Sejarah Pesantren)
- content     (Text)
- status      (String) (Active/Inactive)
Contoh Data:
id    Judul             Type        Content           Status
1     Profil Pesantren  Profile     Aliqro adalah....  Aktif
2     Visi              Visi        Aliqro adalah....  Aktif
3     Misi              Misi        Aliqro adalah....  Aktif
4     Struktur          Struktur    Aliqro adalah....  Aktif
5     Sejarah