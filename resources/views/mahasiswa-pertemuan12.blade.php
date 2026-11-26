<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Pertemuan 12</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --bg-canvas: #F6F5F0;
            --bg-card: #FFFFFF;
            --bg-subtle: #EFEDE6;
            --ink-main: #18181B;
            --ink-muted: #52525B;
            --border-soft: #E4E2D8;
            --accent-forest: #1E4620;
            --accent-forest-hover: #143216;
            --accent-terracotta: #C2410C;
            --accent-sand: #D6D3C9;
            --shadow-card: 0 10px 30px -10px rgba(24, 24, 27, 0.06);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--ink-main);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        #ambientCanvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            max-width: 1040px;
            margin: 0 auto;
            padding: 2.75rem 1.5rem 4rem;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1.25rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .title-group h1 {
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--ink-main);
            margin-bottom: 0.25rem;
        }

        .title-group p {
            color: var(--ink-muted);
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .api-status {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            background: var(--bg-subtle);
            color: var(--ink-muted);
            border: 1px solid var(--border-soft);
            margin-top: 0.65rem;
        }

        .api-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #D97706;
        }

        .api-status.online .api-dot {
            background: #16A34A;
        }

        .api-status.offline .api-dot {
            background: #DC2626;
        }

        .btn-primary-custom {
            background-color: var(--accent-forest);
            color: #FFFFFF;
            border: none;
            padding: 0.75rem 1.35rem;
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.15s ease, background-color 0.15s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--accent-forest-hover);
            transform: translateY(-1px);
            color: #FFFFFF;
        }

        .btn-primary-custom:disabled,
        .btn-action:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .toolbar {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-soft);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
            box-shadow: var(--shadow-card);
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 240px;
        }

        .search-box input {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1px solid var(--border-soft);
            border-radius: 8px;
            background: var(--bg-canvas);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--ink-main);
            outline: none;
            transition: border-color 0.15s ease;
        }

        .search-box input:focus {
            border-color: var(--accent-forest);
            background: #FFFFFF;
            box-shadow: none;
        }

        .counter-badge {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink-muted);
            background: var(--bg-subtle);
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
        }

        .data-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            margin-bottom: 0;
        }

        th {
            padding: 1rem 1.35rem;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--ink-muted);
            background: var(--bg-subtle);
            border-bottom: 1px solid var(--border-soft);
        }

        td {
            padding: 1.05rem 1.35rem;
            font-size: 0.92rem;
            border-bottom: 1px solid var(--border-soft);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background-color 0.15s ease;
        }

        tbody tr:hover {
            background-color: #FAF9F5;
        }

        .nim-pill {
            font-weight: 600;
            font-variant-numeric: tabular-nums;
            color: var(--ink-main);
            background: var(--bg-subtle);
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            display: inline-block;
            font-size: 0.85rem;
        }

        .student-name {
            font-weight: 600;
            color: var(--ink-main);
        }

        .jurusan-text {
            color: var(--ink-muted);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.45rem 0.85rem;
            border-radius: 7px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border-soft);
            background: #FFFFFF;
            color: var(--ink-main);
            transition: all 0.15s ease;
        }

        .btn-action:hover {
            background: var(--bg-subtle);
            border-color: var(--accent-sand);
        }

        .btn-action.delete {
            color: var(--accent-terracotta);
        }

        .btn-action.delete:hover {
            background: #FEF2F2;
            border-color: #FECACA;
        }

        .empty-box {
            text-align: center;
            padding: 3.5rem 1rem;
            color: var(--ink-muted);
            font-size: 0.95rem;
        }

        .modal-content {
            background: #FFFFFF;
            border: 1px solid var(--border-soft);
            border-radius: 16px;
            box-shadow: 0 24px 48px -12px rgba(24, 24, 27, 0.18);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-soft);
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-size: 1.15rem;
            font-weight: 700;
        }

        .modal-body {
            padding: 1.35rem 1.5rem;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink-main);
        }

        .form-control {
            padding: 0.7rem 0.9rem;
            border: 1px solid var(--border-soft);
            border-radius: 9px;
            font-family: inherit;
            font-size: 0.92rem;
            background: var(--bg-canvas);
        }

        .form-control:focus {
            border-color: var(--accent-forest);
            background: #FFFFFF;
            box-shadow: none;
        }

        .modal-footer {
            border-top: 1px solid var(--border-soft);
            padding: 1rem 1.5rem;
        }

        .btn-secondary-custom {
            background: var(--bg-subtle);
            color: var(--ink-main);
            border: none;
            padding: 0.7rem 1.15rem;
            border-radius: 9px;
            font-family: inherit;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>

<canvas id="ambientCanvas"></canvas>

<div class="wrapper">
    <div class="top-bar">
        <div class="title-group">
            <h1>Data Mahasiswa</h1>
            <p>Kelola informasi akademik, nomor induk, dan program studi mahasiswa.</p>
            <div class="api-status" id="apiStatusBadge">
                <span class="api-dot"></span>
                <span id="apiStatusText">Sedang memeriksa endpoint API...</span>
            </div>
        </div>
        <button class="btn-primary-custom" id="addStudentBtn" onclick="bukaModalTambah()" disabled>+ Tambah Mahasiswa</button>
    </div>

    <div class="toolbar">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari berdasarkan NIM, nama, atau jurusan..." oninput="saringTabel()">
        </div>
        <div class="counter-badge" id="totalCount">0 Mahasiswa</div>
    </div>

    <div class="data-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 160px;">NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Jurusan</th>
                        <th style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr>
                        <td colspan="5" class="empty-box">Sedang memuat data mahasiswa...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Formulir Tambah / Ubah Data -->
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="mahasiswaForm" onsubmit="simpanData(event)" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="nimInput" class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                        <input type="text" class="form-control" id="nimInput" placeholder="Contoh: 241011800977">
                        <div class="invalid-feedback" id="errNim">NIM wajib diisi dan minimal 5 karakter.</div>
                    </div>
                    <div class="mb-3">
                        <label for="namaInput" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaInput" placeholder="Masukkan nama lengkap">
                        <div class="invalid-feedback" id="errNama">Nama lengkap wajib diisi.</div>
                    </div>
                    <div class="mb-2">
                        <label for="jurusanInput" class="form-label">Jurusan / Program Studi</label>
                        <input type="text" class="form-control" id="jurusanInput" placeholder="Contoh: Teknik Informatika">
                        <div class="invalid-feedback" id="errJurusan">Jurusan wajib diisi.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom" id="submitBtn">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const canvas = document.getElementById('ambientCanvas');
    const ctx = canvas.getContext('2d');
    let shapes = [];

    function aturKanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const warna = [
            'rgba(30, 70, 32, 0.06)',
            'rgba(194, 65, 12, 0.05)',
            'rgba(161, 158, 145, 0.12)'
        ];

        shapes = Array.from({ length: 14 }, (_, i) => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: 28 + Math.random() * 65,
            vx: (Math.random() - 0.5) * 0.45,
            vy: (Math.random() - 0.5) * 0.45,
            angle: Math.random() * Math.PI * 2,
            vAngle: (Math.random() - 0.5) * 0.004,
            type: i % 3,
            color: warna[i % warna.length]
        }));
    }

    function ancamBentuk() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        shapes.forEach(s => {
            s.x += s.vx;
            s.y += s.vy;
            s.angle += s.vAngle;

            if (s.x < -100) s.x = canvas.width + 100;
            if (s.x > canvas.width + 100) s.x = -100;
            if (s.y < -100) s.y = canvas.height + 100;
            if (s.y > canvas.height + 100) s.y = -100;

            ctx.save();
            ctx.translate(s.x, s.y);
            ctx.rotate(s.angle);

            if (s.type === 0) {
                ctx.fillStyle = s.color;
                ctx.beginPath();
                ctx.arc(0, 0, s.size, 0, Math.PI * 2);
                ctx.fill();
            } else if (s.type === 1) {
                ctx.strokeStyle = s.color;
                ctx.lineWidth = 2.5;
                ctx.beginPath();
                ctx.arc(0, 0, s.size, 0, Math.PI * 2);
                ctx.stroke();
            } else {
                ctx.strokeStyle = s.color;
                ctx.lineWidth = 2;
                ctx.strokeRect(-s.size / 2, -s.size / 2, s.size, s.size);
            }

            ctx.restore();
        });

        requestAnimationFrame(ancamBentuk);
    }

    window.addEventListener('resize', aturKanvas);
    aturKanvas();
    ancamBentuk();

    const URL_API = '/api/mahasiswa';
    let daftarMahasiswa = [];
    let apiSiap = false;
    let instansiModal;

    document.addEventListener('DOMContentLoaded', () => {
        instansiModal = new bootstrap.Modal(document.getElementById('formModal'));
        mulaiAplikasi();
    });

    function aturStatusApi(status, teks) {
        const badge = document.getElementById('apiStatusBadge');
        const label = document.getElementById('apiStatusText');
        const btnTambah = document.getElementById('addStudentBtn');

        badge.classList.remove('online', 'offline');
        if (status) badge.classList.add(status);
        label.textContent = teks;

        apiSiap = (status === 'online');
        btnTambah.disabled = !apiSiap;
    }

    function bersihkanValidasi() {
        ['nimInput', 'namaInput', 'jurusanInput'].forEach(id => {
            document.getElementById(id).classList.remove('is-invalid');
        });
    }

    function setPesanKolom(idInput, idError, pesan) {
        document.getElementById(idInput).classList.add('is-invalid');
        if (idError && pesan) {
            document.getElementById(idError).textContent = pesan;
        }
    }

    function validasiFormulir(nim, nama, jurusan) {
        bersihkanValidasi();
        let valid = true;

        if (!nim) {
            setPesanKolom('nimInput', 'errNim', 'NIM wajib diisi.');
            valid = false;
        } else if (nim.length < 5) {
            setPesanKolom('nimInput', 'errNim', 'NIM minimal 5 karakter.');
            valid = false;
        }

        if (!nama) {
            setPesanKolom('namaInput', 'errNama', 'Nama lengkap wajib diisi.');
            valid = false;
        }

        if (!jurusan) {
            setPesanKolom('jurusanInput', 'errJurusan', 'Jurusan wajib diisi.');
            valid = false;
        }

        if (!valid) {
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                text: 'Silakan periksa kembali kolom input yang ditandai merah.'
            });
        }
        return valid;
    }

    async function periksaApiTerlebihDahulu() {
        aturStatusApi('', 'Sedang memeriksa endpoint API...');
        try {
            const controller = new AbortController();
            const batasWaktu = setTimeout(() => controller.abort(), 4000);

            const respon = await fetch(URL_API, {
                method: 'GET',
                headers: { 'Accept': 'application/json' },
                signal: controller.signal
            });
            clearTimeout(batasWaktu);

            if (!respon.ok) {
                throw new Error(`HTTP ${respon.status}`);
            }

            aturStatusApi('online', 'API Terhubung');
            return true;
        } catch (err) {
            aturStatusApi('offline', 'API Tidak Tersedia · Koneksi Gagal');
            document.getElementById('tableBody').innerHTML = `
                <tr><td colspan="5" class="empty-box">
                    Layanan RESTful API belum dapat diakses. Pastikan MySQL aktif dan server Laravel berjalan normal.
                </td></tr>
            `;
            Swal.fire({
                icon: 'error',
                title: 'Koneksi API Gagal',
                text: 'Endpoint /api/mahasiswa tidak merespons.'
            });
            return false;
        }
    }

    async function mulaiAplikasi() {
        const apiOk = await periksaApiTerlebihDahulu();
        if (apiOk) {
            await ambilDataMahasiswa();
        }
    }

    async function ambilDataMahasiswa() {
        if (!apiSiap) {
            const ok = await periksaApiTerlebihDahulu();
            if (!ok) return;
        }

        try {
            const respon = await fetch(URL_API, {
                headers: { 'Accept': 'application/json' }
            });
            if (!respon.ok) throw new Error('Gagal mengambil data');
            const json = await respon.json();
            daftarMahasiswa = Array.isArray(json) ? json : (json.data || []);
            tampilkanTabel(daftarMahasiswa);
        } catch (err) {
            aturStatusApi('offline', 'API Bermasalah · Gagal Memuat');
            document.getElementById('tableBody').innerHTML = `
                <tr><td colspan="5" class="empty-box">Gagal memuat data dari RESTful API.</td></tr>
            `;
        }
    }

    function tampilkanTabel(daftar) {
        const tbody = document.getElementById('tableBody');
        document.getElementById('totalCount').textContent = `${daftar.length} Mahasiswa`;

        if (daftar.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="5" class="empty-box">Belum ada data mahasiswa. Klik "+ Tambah Mahasiswa" untuk menambahkan data.</td></tr>
            `;
            return;
        }

        tbody.innerHTML = daftar.map((m, indeks) => `
            <tr>
                <td>${indeks + 1}</td>
                <td><span class="nim-pill">${bersihkanHtml(String(m.nim))}</span></td>
                <td class="student-name">${bersihkanHtml(String(m.nama))}</td>
                <td class="jurusan-text">${bersihkanHtml(String(m.jurusan))}</td>
                <td>
                    <div class="actions">
                        <button class="btn-action" ${!apiSiap ? 'disabled' : ''} onclick="bukaModalUbah(${m.id})">Ubah</button>
                        <button class="btn-action delete" ${!apiSiap ? 'disabled' : ''} onclick="hapusMahasiswa(${m.id}, '${bersihkanJs(String(m.nama))}')">Hapus</button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function saringTabel() {
        const kataKunci = document.getElementById('searchInput').value.toLowerCase();
        const hasil = daftarMahasiswa.filter(m =>
            String(m.nim).toLowerCase().includes(kataKunci) ||
            String(m.nama).toLowerCase().includes(kataKunci) ||
            String(m.jurusan).toLowerCase().includes(kataKunci)
        );
        tampilkanTabel(hasil);
    }

    async function bukaModalTambah() {
        if (!await periksaApiTerlebihDahulu()) return;
        bersihkanValidasi();
        document.getElementById('modalTitle').textContent = 'Tambah Mahasiswa';
        document.getElementById('submitBtn').textContent = 'Simpan Data';
        document.getElementById('editId').value = '';
        document.getElementById('nimInput').value = '';
        document.getElementById('namaInput').value = '';
        document.getElementById('jurusanInput').value = '';
        instansiModal.show();
    }

    async function bukaModalUbah(id) {
        if (!await periksaApiTerlebihDahulu()) return;
        const mahasiswa = daftarMahasiswa.find(m => m.id === id);
        if (!mahasiswa) return;

        bersihkanValidasi();
        document.getElementById('modalTitle').textContent = 'Ubah Data Mahasiswa';
        document.getElementById('submitBtn').textContent = 'Simpan Perubahan';
        document.getElementById('editId').value = mahasiswa.id;
        document.getElementById('nimInput').value = mahasiswa.nim;
        document.getElementById('namaInput').value = mahasiswa.nama;
        document.getElementById('jurusanInput').value = mahasiswa.jurusan;
        instansiModal.show();
    }

    async function simpanData(event) {
        event.preventDefault();
        if (!await periksaApiTerlebihDahulu()) return;

        const id = document.getElementById('editId').value;
        const nim = document.getElementById('nimInput').value.trim();
        const nama = document.getElementById('namaInput').value.trim();
        const jurusan = document.getElementById('jurusanInput').value.trim();

        if (!validasiFormulir(nim, nama, jurusan)) return;

        const payload = { nim, nama, jurusan };
        const url = id ? `${URL_API}/${id}` : URL_API;
        const metode = id ? 'PUT' : 'POST';
        const btnSimpan = document.getElementById('submitBtn');
        btnSimpan.disabled = true;

        try {
            const respon = await fetch(url, {
                method: metode,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await respon.json();

            if (!respon.ok) {
                if (data.errors) {
                    if (data.errors.nim) setPesanKolom('nimInput', 'errNim', data.errors.nim[0]);
                    if (data.errors.nama) setPesanKolom('namaInput', 'errNama', data.errors.nama[0]);
                    if (data.errors.jurusan) setPesanKolom('jurusanInput', 'errJurusan', data.errors.jurusan[0]);
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: data.message || 'Silakan periksa kembali data yang dimasukkan.'
                });
                return;
            }

            instansiModal.hide();
            await ambilDataMahasiswa();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: id ? 'Data mahasiswa berhasil diperbarui.' : 'Data mahasiswa baru berhasil ditambahkan.',
                timer: 1800,
                showConfirmButton: false
            });
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Koneksi',
                text: 'Terjadi kesalahan saat menghubungi server API.'
            });
        } finally {
            btnSimpan.disabled = false;
        }
    }

    async function hapusMahasiswa(id, nama) {
        if (!await periksaApiTerlebihDahulu()) return;

        const konfirmasi = await Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus data mahasiswa "${nama}"?`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#C2410C'
        });

        if (!konfirmasi.isConfirmed) return;

        try {
            const respon = await fetch(`${URL_API}/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            });

            if (respon.ok) {
                await ambilDataMahasiswa();
                Swal.fire({
                    icon: 'success',
                    title: 'Terhapus',
                    text: `Data mahasiswa "${nama}" berhasil dihapus.`,
                    timer: 1600,
                    showConfirmButton: false
                });
            } else {
                const dataError = await respon.json().catch(() => ({}));
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menghapus',
                    text: dataError.message || 'Data mahasiswa gagal dihapus.'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Koneksi',
                text: 'Gagal menghapus data dari server API.'
            });
        }
    }

    function bersihkanHtml(teks) {
        const div = document.createElement('div');
        div.textContent = teks;
        return div.innerHTML;
    }

    function bersihkanJs(teks) {
        return teks.replace(/\\/g, '\\\\').replace(/'/g, "\\'");
    }
</script>
</body>
</html>