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
- ID    ID Santri     ID Halaqoh    Jenis       Juz           Nilai
- 1     1               1           Harian      Juz 10        0 / NULL
- 2     1               1           Tasmi       Juz 10        80
- 3     1               1           Perjuz      Juz 8         0 / NULL