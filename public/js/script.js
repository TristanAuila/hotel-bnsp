/*
 * script.js
 *
 * Author      : Tim Pengembang Hotel Pesona Nusantara
 * Date        : 03/11/2026
 * Description : Validasi formulir pemesanan dan perhitungan total bayar di
 *               sisi klien. Server tetap menghitung ulang untuk keamanan.
 *
 * Halaman pesan mengisi window.HOTEL = { prices, breakfastFee, discountRate,
 * discountMinNights } sebelum file ini dimuat.
 */

(function () {
    'use strict';

    var form = document.getElementById('formPemesanan');
    if (!form) {
        return; // Bukan halaman pemesanan.
    }

    var cfg = window.HOTEL || {};
    var PRICES = cfg.prices || {};
    var BREAKFAST_FEE = Number(cfg.breakfastFee) || 0;
    var DISCOUNT_RATE = Number(cfg.discountRate) || 0;
    var DISCOUNT_RATE2 = Number(cfg.discountRate2) || 0;
    var DISCOUNT_MIN_NIGHTS = Number(cfg.discountMinNights) || 3;
    var DISCOUNT_PERCENT = Math.round(DISCOUNT_RATE * 100);
    var DISCOUNT_PERCENT2 = Math.round(DISCOUNT_RATE2 * 100);
    var DISCOUNT_LABEL = DISCOUNT_PERCENT2 > 0 ? DISCOUNT_PERCENT + '% + ' + DISCOUNT_PERCENT2 : String(DISCOUNT_PERCENT);

    // Nama hanya boleh huruf, spasi, titik, apostrof, dan tanda hubung.
    var POLA_NAMA = /^[\p{L}\s.'-]+$/u;
    var KARAKTER_BUKAN_NAMA = /[^\p{L}\s.'-]/gu;

    var el = {
        nama: document.getElementById('namaPemesan'),
        nik: document.getElementById('nomorIdentitas'),
        tanggal: document.getElementById('tanggalPesan'),
        tipe: document.getElementById('tipeKamar'),
        harga: document.getElementById('hargaKamar'),
        durasi: document.getElementById('durasiMenginap'),
        breakfast: document.getElementById('termasukBreakfast'),
        gender: document.getElementById('grupJenisKelamin'),
        btnHitung: document.getElementById('btnHitung'),
        btnKirim: document.getElementById('btnKirim'),
        info: document.getElementById('infoHitung'),
        infoDiskon: document.getElementById('infoDiskon')
    };

    var out = {
        harga: document.getElementById('ringkasHarga'),
        durasi: document.getElementById('ringkasDurasi'),
        subtotalKamar: document.getElementById('ringkasSubtotalKamar'),
        breakfast: document.getElementById('ringkasBreakfast'),
        diskon: document.getElementById('ringkasDiskon'),
        diskon2: document.getElementById('ringkasDiskon2'),
        total: document.getElementById('ringkasTotal')
    };

    /** Format angka ke Rupiah, contoh: 450000 -> "Rp 450.000". */
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(Number(angka) || 0));
    }

    /** Harga per malam dari tipe kamar yang dipilih. */
    function hargaTerpilih() {
        return Number(PRICES[el.tipe.value]) || 0;
    }

    /** Durasi sebagai angka bulat, atau NaN bila bukan angka. */
    function durasiAngka() {
        var raw = el.durasi.value.trim();
        return /^\d+$/.test(raw) ? parseInt(raw, 10) : NaN;
    }

    /**
     * Menghitung rincian biaya:
     * subtotal = (harga x durasi) + (breakfast x durasi); diskon dari subtotal kamar
     * bila durasi > batas malam. Mengembalikan null bila durasi tidak valid.
     */
    function hitungRincian() {
        var harga = hargaTerpilih();
        var durasi = durasiAngka();
        if (isNaN(durasi) || durasi < 1) {
            return null;
        }

        var subtotalKamar = harga * durasi;
        var biayaBreakfast = el.breakfast.checked ? BREAKFAST_FEE * durasi : 0;
        var subtotal = subtotalKamar + biayaBreakfast;
        var dapatDiskon = durasi > DISCOUNT_MIN_NIGHTS;
        // Diskon 10% dari subtotal kamar, lalu 5% dari total setelah diskon 10%.
        var diskon1 = dapatDiskon ? Math.round(subtotalKamar * DISCOUNT_RATE) : 0;
        var diskon2 = dapatDiskon ? Math.round((subtotal - diskon1) * DISCOUNT_RATE2) : 0;

        return {
            harga: harga,
            durasi: durasi,
            subtotalKamar: subtotalKamar,
            biayaBreakfast: biayaBreakfast,
            diskon1: diskon1,
            diskon2: diskon2,
            diskon: diskon1 + diskon2,
            total: subtotal - diskon1 - diskon2
        };
    }

    /** Memperbarui harga dan panel ringkasan secara langsung. */
    function perbaruiRingkasan() {
        var r = hitungRincian();
        var harga = hargaTerpilih();

        el.harga.value = formatRupiah(harga);
        out.harga.textContent = formatRupiah(harga);
        out.durasi.textContent = r ? r.durasi : '-';
        out.subtotalKamar.textContent = r ? formatRupiah(r.subtotalKamar) : '-';
        out.breakfast.textContent = r ? formatRupiah(r.biayaBreakfast) : '-';
        out.diskon.textContent = r ? '- ' + formatRupiah(r.diskon1) : '-';
        if (out.diskon2) {
            out.diskon2.textContent = r ? '- ' + formatRupiah(r.diskon2) : '-';
        }
        out.total.textContent = r ? formatRupiah(r.total) : '-';
        perbaruiInfoDiskon(r);

        return r;
    }

    /** Petunjuk diskon di bawah isian durasi; berubah hijau bila diskon berlaku. */
    function perbaruiInfoDiskon(r) {
        if (!el.infoDiskon) {
            return;
        }
        if (r && r.diskon > 0) {
            el.infoDiskon.className = 'info-diskon aktif';
            el.infoDiskon.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>Diskon ' + DISCOUNT_LABEL +
                '% aktif! Anda hemat ' + formatRupiah(r.diskon) + '.';
        } else {
            var kurang = r ? DISCOUNT_MIN_NIGHTS + 1 - r.durasi : DISCOUNT_MIN_NIGHTS + 1;
            el.infoDiskon.className = 'info-diskon';
            el.infoDiskon.innerHTML = '<i class="bi bi-tag me-1"></i>Tambah ' + kurang +
                ' malam lagi untuk hemat ' + DISCOUNT_LABEL + '%.';
        }
    }

    function setInfo(tipe, html) {
        el.info.className = 'alert alert-' + tipe + ' border small mt-3 mb-0';
        el.info.innerHTML = html;
    }

    /** Menandai satu grup field sebagai tidak valid. */
    function tandaiError(grup, pesan) {
        grup.querySelectorAll('.form-control, .form-select, .form-check-input').forEach(function (input) {
            input.classList.add('is-invalid');
        });
        var feedback = grup.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.textContent = pesan;
            feedback.classList.add('d-block');
        }
    }

    function hapusError(grup) {
        grup.querySelectorAll('.is-invalid').forEach(function (input) {
            input.classList.remove('is-invalid');
        });
        var feedback = grup.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.classList.remove('d-block');
        }
    }

    function grupDari(input) {
        return input.closest('[data-field]');
    }

    /**
     * Memvalidasi formulir. Pesan "isian salah..data harus 16 digit" dan
     * "harus isi angka" juga ditampilkan lewat alert sesuai ketentuan.
     */
    function validasiForm() {
        var errors = [];

        form.querySelectorAll('[data-field]').forEach(hapusError);

        var nama = el.nama.value.trim();
        if (nama.length < 3) {
            errors.push([el.nama, 'Nama pemesan wajib diisi minimal 3 karakter.']);
        } else if (!POLA_NAMA.test(nama)) {
            errors.push([el.nama, 'Nama pemesan hanya boleh berisi huruf.']);
        }

        if (!form.querySelector('input[name="jenis_kelamin"]:checked')) {
            errors.push([el.gender.querySelector('input'), 'Silakan pilih jenis kelamin.']);
        }

        if (!/^\d{16}$/.test(el.nik.value.trim())) {
            errors.push([el.nik, 'isian salah..data harus 16 digit', true]);
        }

        if (!el.tanggal.value) {
            errors.push([el.tanggal, 'Tanggal pesan wajib diisi.']);
        } else if (el.tanggal.min && el.tanggal.value < el.tanggal.min) {
            errors.push([el.tanggal, 'Tanggal pesan tidak boleh sebelum hari ini.']);
        }

        if (!PRICES[el.tipe.value]) {
            errors.push([el.tipe, 'Silakan pilih tipe kamar.']);
        }

        var durasi = durasiAngka();
        if (isNaN(durasi)) {
            errors.push([el.durasi, 'harus isi angka', true]);
        } else if (durasi < 1 || durasi > 365) {
            errors.push([el.durasi, 'Durasi menginap antara 1 sampai 365 malam.']);
        }

        errors.forEach(function (item) {
            tandaiError(grupDari(item[0]), item[1]);
        });

        // Alert khusus untuk NIK dan durasi (sesuai soal), digabung agar tidak muncul berkali-kali.
        var pesanAlert = errors.filter(function (item) { return item[2]; }).map(function (item) { return item[1]; });
        if (pesanAlert.length) {
            alert(pesanAlert.join('\n'));
        }

        if (errors.length) {
            errors[0][0].focus();
            return false;
        }
        return true;
    }

    /**
     * Membuang karakter yang tidak diizinkan saat mengetik atau menempel,
     * sambil menjaga posisi kursor.
     */
    function saringInput(input, polaTerlarang) {
        input.addEventListener('input', function () {
            var bersih = input.value.replace(polaTerlarang, '');
            if (bersih !== input.value) {
                var posisi = Math.max(0, input.selectionStart - (input.value.length - bersih.length));
                input.value = bersih;
                input.setSelectionRange(posisi, posisi);
            }
        });
    }

    saringInput(el.nama, KARAKTER_BUKAN_NAMA); // Nama: tanpa angka/simbol.
    saringInput(el.nik, /\D/g);                // NIK: hanya angka.

    // Penghitung digit NIK, contoh "12/16 digit"; hijau bila sudah 16.
    var infoNik = document.getElementById('infoNik');
    function perbaruiInfoNik() {
        if (!infoNik) {
            return;
        }
        var jumlah = el.nik.value.length;
        infoNik.className = 'info-diskon' + (jumlah === 16 ? ' aktif' : '');
        infoNik.textContent = jumlah === 16
            ? '16/16 digit ✓'
            : jumlah + '/16 digit (kurang ' + (16 - jumlah) + ' digit)';
    }
    el.nik.addEventListener('input', perbaruiInfoNik);
    perbaruiInfoNik();

    // Perbarui ringkasan setiap kali isian yang memengaruhi harga berubah.
    el.tipe.addEventListener('change', perbaruiRingkasan);
    el.durasi.addEventListener('input', perbaruiRingkasan);
    el.breakfast.addEventListener('change', perbaruiRingkasan);

    // Hapus tanda error ketika pengguna memperbaiki isian.
    form.addEventListener('input', function (event) {
        var grup = event.target.closest('[data-field]');
        if (grup) {
            hapusError(grup);
        }
    });

    // Tombol "Hitung Total Bayar".
    el.btnHitung.addEventListener('click', function () {
        if (!validasiForm()) {
            return;
        }

        var r = perbaruiRingkasan();
        var pesan = 'Total bayar: <strong>' + formatRupiah(r.total) + '</strong>.';
        pesan += r.diskon > 0
            ? ' Diskon ' + DISCOUNT_LABEL + '% diterapkan.'
            : ' Menginap lebih dari ' + DISCOUNT_MIN_NIGHTS + ' malam untuk diskon ' + DISCOUNT_LABEL + '%.';
        setInfo('success', pesan);
    });

    // Kirim formulir hanya bila valid; cegah klik ganda.
    form.addEventListener('submit', function (event) {
        if (!validasiForm()) {
            event.preventDefault();
            return;
        }

        perbaruiRingkasan();
        el.btnKirim.disabled = true;
        el.btnKirim.innerHTML = '<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Memproses...';
    });

    perbaruiRingkasan();
})();
