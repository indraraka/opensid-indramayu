# Deploy & CI/CD

Repo ini menjadi sumber kebenaran untuk **tema Garuda** (garuda + 9 varian
ternama) yang dipakai 7 situs desa Indramayu, dan men-deploy-nya otomatis ke
server lewat GitHub Actions (rsync via SSH, **tanpa Docker**).

## Server & desa

Satu server (Hostinger) menampung 7 instalasi OpenSID terpisah:

| Desa | Domain | Path di server |
|------|--------|----------------|
| Pabean Udik | pabeanudik.desa.id | `domains/pabeanudik.desa.id/public_html` |
| Singaraja | singaraja-indramayu.desa.id | `domains/singaraja-indramayu.desa.id/public_html` |
| Karangsong | karangsong-indramayu.desa.id | `domains/karangsong-indramayu.desa.id/public_html` |
| Tambak | tambak-indramayu.desa.id | `domains/tambak-indramayu.desa.id/public_html` |
| Dukuh | dukuh-indramayu.desa.id | `domains/dukuh-indramayu.desa.id/public_html` |
| Pekandangan | pekandangan-indramayu.desa.id | `domains/pekandangan-indramayu.desa.id/public_html` |
| Plumbon | plumbon-indramayu.desa.id | `domains/plumbon-indramayu.desa.id/public_html` |

## Cakupan CI: hanya tema (disengaja)

Ketujuh desa menjalankan **edisi OpenSID yang berbeda-beda** (mis. Karangsong/
Pekandangan/Plumbon punya modul bansos/stunting/DPT; Dukuh punya modul analisis —
±129 berkas berbeda antar-edisi). Karena itu **men-sinkronkan seluruh kode
aplikasi dari satu sumur akan menurunkan/merusak** edisi yang berbeda.

Tema bersifat mandiri dan netral-versi, jadi CI **hanya** men-deploy
`desa/themes/garuda*`. Perbaikan kode (mis. dukungan PHP 8.4, bugfix) dilakukan
terpisah lewat tambalan bedah (lihat bagian "Perbaikan kode" di bawah).

## Yang sudah disiapkan

- Workflow: `.github/workflows/deploy.yml` — matrix 7 desa, rsync per-folder tema
  (`--delete` ber-skop ke tiap folder tema), perbaiki izin, bersihkan cache,
  verifikasi situs `HTTP 200`.
- Secret repo yang **sudah diisi**: `SSH_HOST`, `SSH_PORT`, `SSH_USER`.
- Kunci deploy khusus sudah dipasang di `~/.ssh/authorized_keys` server
  (ed25519, komentar `gha-deploy-opensid-indramayu`).

## Satu langkah yang HARUS Anda lakukan: tambah secret kunci privat

Kunci privat tidak boleh disisipkan otomatis ke GitHub — tambahkan sendiri
(sekali saja) memakai berkas kunci privat deploy yang dihasilkan saat setup
(ed25519; public key-nya sudah terpasang di server). Jalankan:

```bash
gh secret set SSH_PRIVATE_KEY -R indraraka/opensid-indramayu < /path/ke/deploy_key
```

Setelah itu picu deploy manual untuk uji coba:

```bash
gh workflow run "Deploy tema Garuda ke 7 desa" -R indraraka/opensid-indramayu
gh run watch -R indraraka/opensid-indramayu
```

> Catatan: jika kunci deploy hilang/diganti, buat baru lalu pasang public key-nya
> ke `~/.ssh/authorized_keys` server dan perbarui secret `SSH_PRIVATE_KEY`.

## Alur kerja harian

1. Ubah tema di `desa/themes/garuda*`.
2. `git commit` + `git push` ke `main`.
3. Workflow jalan otomatis → tema ter-deploy ke 7 desa, cache dibersihkan, tiap
   situs dicek `HTTP 200`.

## Menambah tema baru (mis. garuda-ternama-10)

File akan ikut ter-rsync otomatis, **tetapi** tema baru perlu didaftarkan sekali
ke tabel `theme` tiap desa:

```bash
# di server, untuk tiap path desa:
php scripts/register_themes.php <path_public_html> activate=none
```

`scripts/register_themes.php` membaca kredensial DB tiap desa (termasuk yang
terenkripsi via app_key), mendaftarkan semua folder `garuda*`, dan opsional
mengaktifkan satu tema (`activate=desa-garuda` atau `none`).

## Perbaikan kode (di luar tema)

Karena edisi berbeda-beda, perbaikan kode diterapkan sebagai tambalan bedah yang
idempoten per-berkas, bukan menimpa seluruh pohon. Perbaikan yang sudah terpasang
di ketujuh desa:

- **PHP 8.4**: `index.php` (redam `E_DEPRECATED`), `donjo-app/config/installer.php`
  & `constants.php` (gerbang versi + polyfill `MYSQLI_TYPE_INTERVAL`).
- **Bugfix**: `donjo-app/config/config.php` (`sess_save_path` writable),
  `donjo-app/controllers/fweb/Statistik.php` (penjagaan `/data-statistik`).
- **Bugfix (2026-07-16)**: `donjo-app/controllers/fmandiri/Surat.php:279` —
  `'syarat' => $data_permohonan['syarat'] ?? []`. Kolom `permohonan_surat.syarat`
  bertipe `text` **NOT NULL**, sedangkan key `syarat` hanya ada di POST bila surat
  punya syarat dokumen. Mengajukan surat **tanpa syarat** (mis.
  `sistem-surat-biodata-penduduk`) lewat Layanan Mandiri menyisipkan NULL →
  `SQLSTATE[23000] 1048 Column 'syarat' cannot be null`. Model meng-cast
  `syarat => 'json'`, jadi `[]` tersimpan sebagai `[]`. Terpasang di **8 desa 2606**.

Backup berkas asli tersimpan di server: `~/opensid-fix-backup/<domain>/`.

## Catatan lapangan

- **Server menampung 10 situs desa, bukan 7.** Selain ketujuh di atas ada
  `telukagung-indramayu.desa.id` (edisi 2606, ikut ditambal) serta
  `pekandanganjaya-indramayu.desa.id` dan `singajaya-imy.desa.id` yang masih
  **edisi 2504** dengan kode berbeda (`json_encode($data_permohonan['syarat'], ...)`)
  — keduanya **tidak** kena bug `syarat` dan **tidak** ikut ditambal. Keduanya juga
  belum ada di matrix `deploy.yml`.
- **`karangsong-indramayu.desa.id` memakai tantangan anti-bot Hostinger CDN**
  (`Server: hcdn`, halaman "Just a moment..."). `curl` polos menerima **403**
  padahal origin sehat (`curl --resolve <domain>:443:<SSH_HOST>` → 200). Langkah
  "Verifikasi situs merespons" di `deploy.yml` (`test "$code" = "200"`) akan
  **gagal palsu** untuk desa ini — verifikasi lewat origin, bukan lewat CDN.
