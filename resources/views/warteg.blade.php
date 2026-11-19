<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>APB Warteg — Kasir & Bukti Transaksi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; }
        body { background: #0b0b0e; color: #f4f4f6; padding: 24px; }
        .wrap { max-width: 1080px; margin: 0 auto; display: grid; gap: 20px; }
        .card { background: #14141a; border: 1px solid #2a1418; border-radius: 12px; padding: 18px; }
        .hdr { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #2a1418; padding-bottom: 14px; margin-bottom: 16px; }
        .title { font-size: 20px; font-weight: 700; color: #ff3b5c; letter-spacing: 0.5px; }
        .sub { font-size: 13px; color: #a1a1aa; }
        .grid-2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 18px; }
        .menus { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; margin-top: 12px; }
        .menu-item { background: #1b1b24; border: 1px solid #2e2e3a; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; cursor: pointer; transition: transform 0.15s ease, border-color 0.15s ease; }
        .menu-item:hover { transform: translateY(-2px); border-color: #523039; }
        .menu-item.active { border-color: #ff3b5c; background: #231419; }
        .menu-thumb { width: 100%; height: 130px; object-fit: cover; background: #26161b; display: block; }
        .menu-body { padding: 12px; display: flex; flex-direction: column; gap: 6px; flex: 1; justify-content: space-between; }
        .price { color: #ff5c77; font-weight: 700; font-size: 15px; }
        .stock { font-size: 12px; color: #b4b4c2; }
        label { display: block; font-size: 12px; color: #b4b4c2; margin-bottom: 6px; margin-top: 10px; }
        input, select { width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #2e2e3a; background: #0e0e13; color: #fff; }
        input:focus, select:focus { outline: none; border-color: #ff3b5c; }
        button { cursor: pointer; border: none; border-radius: 8px; padding: 9px 14px; font-weight: 600; font-size: 13px; transition: background 0.15s ease, transform 0.1s ease; }
        button:active { transform: scale(0.98); }
        .btn-red { background: #e11d48; color: #fff; }
        .btn-red:hover { background: #be123c; }
        .btn-dark { background: #262632; color: #e4e4ec; }
        .btn-dark:hover { background: #343444; }
        .row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-top: 12px; }
        .alert { padding: 10px 12px; border-radius: 8px; font-size: 13px; margin-top: 10px; display: none; }
        .alert.ok { display: block; background: #12291c; border: 1px solid #1f5c37; color: #6ee7b7; }
        .alert.err { display: block; background: #2c1218; border: 1px solid #7f1d32; color: #fda4af; }
        .struk { background: #0e0e12; border: 1px dashed #ff3b5c; border-radius: 10px; padding: 16px; margin-top: 12px; }
        .struk-line { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; border-bottom: 1px solid #1f1f29; }
        .struk-total { display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; color: #ff5c77; padding-top: 10px; }

        /* Admin Upload Styling */
        .admin-card { background: linear-gradient(145deg, #191217 0%, #121218 100%); border: 1px solid #4c1d28; }
        .admin-badge { background: rgba(225, 29, 72, 0.18); color: #ff6b86; border: 1px solid rgba(255, 59, 92, 0.45); font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 999px; letter-spacing: 0.6px; }
        .dropzone { position: relative; border: 1.5px dashed #4a2630; background: #0e0d12; border-radius: 10px; padding: 16px; text-align: center; cursor: pointer; transition: border-color 0.15s ease, background 0.15s ease; }
        .dropzone:hover, .dropzone.dragover { border-color: #ff3b5c; background: #1a1015; }
        .dropzone input[type="file"] { display: none; }
        .dropzone-title { font-size: 13px; font-weight: 700; color: #f4f4f6; }
        .dropzone-sub { font-size: 11px; color: #a1a1aa; margin-top: 4px; }
        .file-meta { font-size: 12px; color: #ff859b; margin-top: 8px; font-weight: 600; word-break: break-all; }
        .preview-box { background: #0e0e13; border: 1px solid #2a242c; border-radius: 10px; padding: 12px; display: flex; gap: 12px; align-items: center; margin-top: 12px; }
        .preview-img { width: 96px; height: 68px; object-fit: cover; border-radius: 8px; border: 1px solid #38222a; background: #1b1418; flex-shrink: 0; }

        @media print {
            body { background: #fff; color: #000; padding: 0; }
            .no-print { display: none !important; }
            .card, .struk { border: 1px solid #000; background: #fff; color: #000; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="hdr">
            <div>
                <div class="title">APB WARTEG — ORDER & BUKTI TRANSAKSI</div>
                <div class="sub" id="userStatus">Memeriksa status login...</div>
            </div>
            <div class="row no-print" style="margin-top:0;">
                <button class="btn-dark" onclick="loadMenus()">Refresh Menu</button>
                <button class="btn-dark" onclick="logoutUser()">Logout</button>
            </div>
        </div>

        <div class="grid-2 no-print">
            <!-- Auth Panel -->
            <div>
                <h3 style="font-size:15px; margin-bottom:4px;">Akun (Login / Register)</h3>
                <div class="sub">Login dulu buat bikin transaksi atau upload gambar admin.</div>
                <label>Email</label>
                <input type="email" id="authEmail" placeholder="budi@warteg.com">
                <label>Password</label>
                <div style="display:flex; gap:8px; align-items:center;">
                    <input type="password" id="authPassword" placeholder="password123" style="flex:1;">
                    <button type="button" class="btn-dark" id="togglePwBtn" onclick="togglePasswordVisibility()">Lihat</button>
                </div>
                <label>Nama (hanya untuk Register)</label>
                <input type="text" id="authName" placeholder="Budi Pembeli">
                <label>Role (hanya untuk Register)</label>
                <select id="authRole">
                    <option value="customer">customer</option>
                    <option value="admin">admin</option>
                </select>
                <div class="row">
                    <button class="btn-red" onclick="loginUser()">Login</button>
                    <button class="btn-dark" onclick="registerUser()">Register</button>
                </div>
                <div id="authMsg" class="alert"></div>
            </div>

            <!-- Form Transaksi -->
            <div>
                <h3 style="font-size:15px; margin-bottom:4px;">Buat Pesanan</h3>
                <div class="sub">Klik kartu menu di bawah atau pilih langsung dari dropdown.</div>
                <label>Menu Terpilih</label>
                <select id="menuSelect"></select>
                <label>Jumlah (Quantity)</label>
                <input type="number" id="qtyInput" min="1" value="1">
                <div class="row">
                    <button class="btn-red" onclick="submitTransaction()">Beli & Cetak Bukti</button>
                </div>
                <div id="trxMsg" class="alert"></div>
            </div>
        </div>
    </div>

    <!-- Admin Panel: Upload Gambar Menu -->
    <div class="card admin-card no-print" id="adminUploadCard" style="display:none;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px;">
            <h3 style="font-size:15px; color:#ff5c77;">Admin Panel — Kelola Gambar Menu</h3>
            <span class="admin-badge">ROLE: ADMIN</span>
        </div>
        <div class="sub">Pilih menu lalu drop atau pilih foto makanan/minuman untuk langsung mengganti thumbnail menu.</div>

        <div class="grid-2" style="margin-top:8px;">
            <div>
                <label>Target Menu</label>
                <select id="adminMenuSelect" onchange="syncAdminPreview()"></select>

                <div class="preview-box">
                    <img id="adminPreviewImg" class="preview-img" src="" alt="Preview">
                    <div>
                        <div id="adminPreviewLabel" style="font-size:12px; font-weight:700; color:#f4f4f6;">Preview Gambar</div>
                        <div id="adminPreviewSub" class="sub" style="font-size:11px; margin-top:2px;">Menampilkan gambar saat ini atau file baru.</div>
                    </div>
                </div>
            </div>

            <div>
                <label>File Gambar</label>
                <div class="dropzone" id="adminDropzone" onclick="document.getElementById('adminImageInput').click()">
                    <input type="file" id="adminImageInput" accept="image/jpeg,image/png,image/webp" onchange="handleAdminFileChange()">
                    <div class="dropzone-title">Klik untuk pilih foto atau drag & drop ke sini</div>
                    <div class="dropzone-sub">Format: JPG, JPEG, PNG, WEBP • Maksimal 2MB</div>
                    <div class="file-meta" id="adminFileMeta">Belum ada file dipilih</div>
                </div>

                <div class="row">
                    <button type="button" class="btn-red" onclick="uploadMenuImage()">Simpan & Upload Gambar</button>
                    <button type="button" class="btn-dark" onclick="clearAdminFile()">Reset File</button>
                </div>
            </div>
        </div>
        <div id="adminMsg" class="alert"></div>
    </div>

    <!-- Daftar Menu -->
    <div class="card no-print">
        <h3 style="font-size:15px;">Daftar Menu Tersedia</h3>
        <div id="menuList" class="menus">
            <div class="sub">Memuat menu...</div>
        </div>
    </div>

    <!-- Bukti Transaksi -->
    <div class="card" id="receiptCard">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3 style="font-size:15px;">Bukti Transaksi</h3>
            <button class="btn-dark no-print" onclick="window.print()">Cetak / Print</button>
        </div>
        <div id="receiptBox" class="struk">
            <div class="sub">Belum ada transaksi baru di sesi ini. Lakukan pembelian untuk menampilkan bukti transaksi.</div>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let menusCache = [];
let tempPreviewUrl = null;

const fmtRp = (num) => 'Rp' + Number(num || 0).toLocaleString('id-ID');

function getMenuImage(menu) {
    if (menu.image_url) return menu.image_url;
    if (menu.image) {
        const base = menu.image.startsWith('http') ? menu.image : `/storage/${menu.image}`;
        return `${base}?v=${Date.now()}`;
    }

    const label = String(menu.name ?? menu.nama_menu ?? 'Menu Warteg').slice(0, 18);
    const svg = `
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="220" viewBox="0 0 400 220">
            <defs>
                <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#2a1117"/>
                    <stop offset="100%" stop-color="#14141c"/>
                </linearGradient>
            </defs>
            <rect width="400" height="220" fill="url(#bg)"/>
            <circle cx="330" cy="40" r="65" fill="#e11d48" fill-opacity="0.14"/>
            <rect x="24" y="156" width="84" height="24" rx="6" fill="#e11d48" fill-opacity="0.25"/>
            <text x="66" y="172" text-anchor="middle" fill="#ff758f" font-family="Arial, sans-serif" font-size="11" font-weight="bold">WARTEG</text>
            <text x="24" y="112" fill="#ffffff" font-family="Arial, sans-serif" font-size="22" font-weight="bold">${label.replace(/&/g, '&amp;').replace(/</g, '&lt;')}</text>
        </svg>
    `.trim();

    return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
}

function showAlert(elId, type, text) {
    const el = document.getElementById(elId);
    el.className = 'alert ' + (type === 'ok' ? 'ok' : 'err');
    el.textContent = text;
}

function togglePasswordVisibility() {
    const input = document.getElementById('authPassword');
    const btn = document.getElementById('togglePwBtn');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.textContent = isHidden ? 'Sembunyi' : 'Lihat';
}

function formatErrorMessage(res, data, fallback) {
    if (data?.errors) {
        const firstKey = Object.keys(data.errors)[0];
        if (firstKey && data.errors[firstKey]?.[0]) {
            return data.errors[firstKey][0];
        }
    }
    if (res.status === 401) {
        return data?.message || 'Password salah atau email belum terdaftar.';
    }
    return data?.message || fallback;
}

async function checkMe() {
    const res = await fetch('/me', { headers: { 'Accept': 'application/json' } });
    const data = await res.json();
    const statusEl = document.getElementById('userStatus');
    const adminCard = document.getElementById('adminUploadCard');

    if (res.ok && data.success && data.data?.user) {
        const u = data.data.user;
        statusEl.textContent = `Login sebagai: ${u.name} (${u.email}) — Role: ${u.role}`;
        adminCard.style.display = u.role === 'admin' ? 'block' : 'none';
        if (u.role === 'admin') syncAdminPreview();
    } else {
        statusEl.textContent = 'Belum login (Tamu)';
        adminCard.style.display = 'none';
    }
}

async function loginUser() {
    const res = await fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            email: document.getElementById('authEmail').value,
            password: document.getElementById('authPassword').value
        })
    });
    const data = await res.json();
    if (res.ok && data.success) {
        showAlert('authMsg', 'ok', data.message || 'Login berhasil');
        checkMe();
    } else {
        showAlert('authMsg', 'err', formatErrorMessage(res, data, 'Password salah atau gagal login'));
    }
}

async function registerUser() {
    const res = await fetch('/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            name: document.getElementById('authName').value,
            email: document.getElementById('authEmail').value,
            password: document.getElementById('authPassword').value,
            role: document.getElementById('authRole').value
        })
    });
    const data = await res.json();
    if (res.ok && data.success) {
        showAlert('authMsg', 'ok', data.message || 'Registrasi berhasil');
        checkMe();
    } else {
        showAlert('authMsg', 'err', formatErrorMessage(res, data, 'Gagal registrasi'));
    }
}

async function logoutUser() {
    const res = await fetch('/logout', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    });
    const data = await res.json();
    showAlert('authMsg', res.ok ? 'ok' : 'err', data.message || 'Logout');
    checkMe();
}

async function loadMenus() {
    const res = await fetch('/menus', { headers: { 'Accept': 'application/json' } });
    const json = await res.json();
    menusCache = json.data || [];

    const listEl = document.getElementById('menuList');
    const selectEl = document.getElementById('menuSelect');
    const adminSelectEl = document.getElementById('adminMenuSelect');
    const prevAdminVal = adminSelectEl?.value;

    selectEl.innerHTML = '';
    if (adminSelectEl) adminSelectEl.innerHTML = '';

    if (!menusCache.length) {
        listEl.innerHTML = '<div class="sub">Data menu kosong.</div>';
        return;
    }

    listEl.innerHTML = menusCache.map(m => {
        const nama = m.name ?? m.nama_menu ?? ('Menu #' + m.id);
        const harga = m.price ?? m.harga ?? 0;
        return `
            <div class="menu-item" id="card-${m.id}" onclick="selectMenu(${m.id})">
                <img class="menu-thumb" src="${getMenuImage(m)}" alt="${nama}">
                <div class="menu-body">
                    <div>
                        <div style="font-weight:700;">${nama}</div>
                        <div class="stock">Stok: ${m.stock ?? 0}</div>
                    </div>
                    <div class="price">${fmtRp(harga)}</div>
                </div>
            </div>
        `;
    }).join('');

    menusCache.forEach(m => {
        const nama = m.name ?? m.nama_menu ?? ('Menu #' + m.id);
        const harga = m.price ?? m.harga ?? 0;

        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = `#${m.id} - ${nama} (${fmtRp(harga)} | Stok: ${m.stock})`;
        selectEl.appendChild(opt);

        if (adminSelectEl) {
            const adminOpt = document.createElement('option');
            adminOpt.value = m.id;
            adminOpt.textContent = `#${m.id} - ${nama}`;
            adminSelectEl.appendChild(adminOpt);
        }
    });

    if (adminSelectEl && prevAdminVal) {
        adminSelectEl.value = prevAdminVal;
    }
    syncAdminPreview();
}

function selectMenu(id) {
    document.getElementById('menuSelect').value = id;
    const adminSelectEl = document.getElementById('adminMenuSelect');
    if (adminSelectEl) {
        adminSelectEl.value = id;
        syncAdminPreview();
    }
    document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'));
    const activeCard = document.getElementById('card-' + id);
    if (activeCard) activeCard.classList.add('active');
}

function handleAdminFileChange() {
    const fileInput = document.getElementById('adminImageInput');
    const metaEl = document.getElementById('adminFileMeta');
    const file = fileInput.files?.[0];

    if (tempPreviewUrl) {
        URL.revokeObjectURL(tempPreviewUrl);
        tempPreviewUrl = null;
    }

    if (!file) {
        metaEl.textContent = 'Belum ada file dipilih';
        syncAdminPreview();
        return;
    }

    const sizeKb = (file.size / 1024).toFixed(1);
    metaEl.textContent = `${file.name} (${sizeKb} KB)`;
    tempPreviewUrl = URL.createObjectURL(file);
    syncAdminPreview(true);
}

function clearAdminFile() {
    const fileInput = document.getElementById('adminImageInput');
    fileInput.value = '';
    handleAdminFileChange();
}

function syncAdminPreview(isNewFile = false) {
    const adminSelectEl = document.getElementById('adminMenuSelect');
    const previewImg = document.getElementById('adminPreviewImg');
    const previewLabel = document.getElementById('adminPreviewLabel');
    const previewSub = document.getElementById('adminPreviewSub');

    if (!adminSelectEl || !previewImg) return;
    const menu = menusCache.find(item => String(item.id) === String(adminSelectEl.value));
    const menuName = menu ? (menu.name ?? menu.nama_menu ?? `Menu #${menu.id}`) : 'Menu';

    if (isNewFile && tempPreviewUrl) {
        previewImg.src = tempPreviewUrl;
        previewLabel.textContent = `Preview Baru — ${menuName}`;
        previewSub.textContent = 'Siap diunggah ke server.';
        return;
    }

    previewImg.src = menu ? getMenuImage(menu) : '';
    previewLabel.textContent = `Gambar Saat Ini — ${menuName}`;
    previewSub.textContent = menu?.image ? `Path: /storage/${menu.image}` : 'Belum ada foto tersimpan (pakai placeholder).';
}

const dropzone = document.getElementById('adminDropzone');
if (dropzone) {
    ['dragenter', 'dragover'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        });
    });
    ['dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        });
    });
    dropzone.addEventListener('drop', (e) => {
        const files = e.dataTransfer?.files;
        if (files && files.length) {
            const fileInput = document.getElementById('adminImageInput');
            fileInput.files = files;
            handleAdminFileChange();
        }
    });
}

async function uploadMenuImage() {
    const menuId = document.getElementById('adminMenuSelect').value;
    const fileInput = document.getElementById('adminImageInput');
    if (!fileInput.files.length) {
        showAlert('adminMsg', 'err', 'Pilih atau drop file gambar dulu.');
        return;
    }

    const formData = new FormData();
    formData.append('image', fileInput.files[0]);

    const res = await fetch(`/menus/${menuId}`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    });

    const data = await res.json();
    if (res.ok && data.success) {
        showAlert('adminMsg', 'ok', data.message || 'Gambar menu berhasil diunggah');
        clearAdminFile();
        await loadMenus();
    } else {
        showAlert('adminMsg', 'err', formatErrorMessage(res, data, 'Gagal upload gambar'));
    }
}

function renderReceipt(trx) {
    const menu = trx.menu || {};
    const menuName = menu.name ?? menu.nama_menu ?? ('Menu #' + trx.menu_id);
    const unitPrice = menu.price ?? menu.harga ?? (trx.quantity ? Math.round(trx.total_price / trx.quantity) : 0);
    const waktu = trx.created_at ? new Date(trx.created_at).toLocaleString('id-ID') : new Date().toLocaleString('id-ID');

    document.getElementById('receiptBox').innerHTML = `
        <div style="text-align:center; margin-bottom:10px;">
            <div style="font-weight:700; font-size:15px;">BUKTI TRANSAKSI APB WARTEG</div>
            <div class="sub">ID Transaksi: #${trx.id}</div>
        </div>
        <div class="struk-line"><span>Waktu</span><span>${waktu}</span></div>
        <div class="struk-line"><span>Menu</span><span>${menuName}</span></div>
        <div class="struk-line"><span>Harga Satuan</span><span>${fmtRp(unitPrice)}</span></div>
        <div class="struk-line"><span>Jumlah</span><span>${trx.quantity}x</span></div>
        <div class="struk-total"><span>TOTAL BAYAR</span><span>${fmtRp(trx.total_price)}</span></div>
    `;
}

async function submitTransaction() {
    const menuId = document.getElementById('menuSelect').value;
    const qty = Number(document.getElementById('qtyInput').value);

    const res = await fetch('/transactions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ menu_id: Number(menuId), quantity: qty })
    });

    const data = await res.json();
    if (res.status === 201 && data.success) {
        showAlert('trxMsg', 'ok', data.message);
        renderReceipt(data.data);
        loadMenus();
    } else {
        showAlert('trxMsg', 'err', formatErrorMessage(res, data, 'Transaksi gagal (pastikan sudah login & stok cukup)'));
    }
}

checkMe();
loadMenus();
</script>
</body>
</html>