<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>APB Warteg — Admin Workspace</title>
    <style>
        :root {
            --cream-bg: #f4eee1;
            --cream-card: #fffdf9;
            --cream-soft: #ede3cf;
            --cream-hover: #f8f2e5;
            --green-dark: #153b2c;
            --green-deep: #0c261b;
            --green-mid: #235641;
            --orange: #e86a17;
            --orange-hover: #c9550a;
            --orange-soft: #fff2e8;
            --text-main: #18221d;
            --text-muted: #5b6761;
            --border: #ddd0b8;
            --ok-bg: #e2f5ea;
            --ok-text: #145c36;
            --err-bg: #fde8e4;
            --err-text: #9b2c1d;
            --shadow: 0 6px 20px rgba(21, 59, 44, 0.06);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; }
        body { background: var(--cream-bg); color: var(--text-main); min-height: 100vh; }

        .app-shell {
            display: grid;
            grid-template-columns: 248px minmax(0, 1fr);
            min-height: 100vh;
        }

        .sidebar {
            background: var(--green-dark);
            color: #fffdf9;
            padding: 20px 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 18px;
            border-right: 2px solid #21523e;
        }

        .side-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 6px 16px;
            border-bottom: 1px solid rgba(255, 253, 249, 0.14);
        }

        .brand-box {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--orange);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 15px;
            flex-shrink: 0;
        }

        .side-title { font-size: 15px; font-weight: 800; letter-spacing: 0.3px; }
        .side-sub { font-size: 11px; color: #c7d9d0; }

        .side-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #9cb8ab;
            font-weight: 700;
            padding: 0 10px 6px;
        }

        .side-nav { display: flex; flex-direction: column; gap: 6px; }

        .side-btn {
            width: 100%;
            text-align: left;
            background: transparent;
            color: #e6efe9;
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .side-btn:hover { background: rgba(255, 253, 249, 0.08); }

        .side-btn.active {
            background: var(--orange);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(232, 106, 23, 0.3);
        }

        .side-footer {
            border-top: 1px solid rgba(255, 253, 249, 0.14);
            padding-top: 14px;
            display: grid;
            gap: 10px;
        }

        .admin-mini {
            background: rgba(255, 253, 249, 0.07);
            border: 1px solid rgba(255, 253, 249, 0.12);
            border-radius: 10px;
            padding: 10px;
            font-size: 12px;
        }

        .admin-mini .role-tag {
            display: inline-block;
            margin-top: 5px;
            background: rgba(232, 106, 23, 0.22);
            color: #ffb07a;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .main-area {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .word-ribbon {
            background: var(--cream-card);
            border-bottom: 1px solid var(--border);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .ribbon-groups {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ribbon-group {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-right: 12px;
            border-right: 1px solid var(--border);
        }

        .ribbon-group:last-child {
            border-right: none;
            padding-right: 0;
        }

        .ribbon-group-title {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            margin-right: 2px;
        }

        .content-wrap {
            padding: 20px;
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
            display: grid;
            gap: 18px;
        }

        .card {
            background: var(--cream-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .sec-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding-bottom: 14px;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .sec-title { font-size: 18px; font-weight: 800; color: var(--green-dark); }
        .sub { font-size: 13px; color: var(--text-muted); }

        .badge-orange {
            background: var(--orange-soft);
            color: var(--orange);
            border: 1px solid #f2b487;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 11px;
            border-radius: 999px;
        }

        .grid-2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 18px; }
        .grid-2-kpi { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px; }
        .grid-stok { display: grid; grid-template-columns: minmax(310px, 390px) minmax(0, 1fr); gap: 18px; align-items: start; }
        .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .form-panel { background: #fffdf9; border: 1px solid var(--border); border-radius: 12px; padding: 14px; }
        .menus { display: grid; grid-template-columns: repeat(auto-fill, minmax(195px, 1fr)); gap: 12px; margin-top: 12px; }

        .menu-item {
            background: var(--cream-card);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }
        .menu-item:hover { transform: translateY(-2px); border-color: var(--orange); }
        .menu-item.active { border-color: var(--orange); background: #fff9f2; box-shadow: 0 0 0 3px rgba(232, 106, 23, 0.14); }
        .menu-thumb { width: 100%; height: 118px; object-fit: cover; background: var(--cream-soft); display: block; }
        .menu-body { padding: 11px; display: flex; flex-direction: column; gap: 6px; flex: 1; justify-content: space-between; }
        .price { color: var(--orange); font-weight: 800; font-size: 14px; }
        .stock { font-size: 12px; color: var(--text-muted); }
        .menu-tag {
            align-self: flex-start;
            font-size: 11px;
            font-weight: 700;
            color: var(--green-dark);
            background: #eaf3ee;
            padding: 2px 8px;
            border-radius: 999px;
        }

        label { display: block; font-size: 12px; font-weight: 700; color: var(--green-dark); margin-bottom: 5px; margin-top: 10px; }
        input, select {
            width: 100%;
            padding: 9px 12px;
            border-radius: 9px;
            border: 1px solid #c9bba1;
            background: #fff;
            color: var(--text-main);
            font-size: 13px;
        }
        input:focus, select:focus { outline: none; border-color: var(--green-dark); box-shadow: 0 0 0 3px rgba(21, 59, 44, 0.12); }

        button {
            cursor: pointer;
            border: none;
            border-radius: 9px;
            padding: 8px 13px;
            font-weight: 700;
            font-size: 12.5px;
            transition: background 0.15s ease, transform 0.1s ease;
        }
        button:active { transform: scale(0.98); }

        .btn-green { background: var(--green-dark); color: #fffdf9; }
        .btn-green:hover { background: var(--green-deep); }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-hover); }
        .btn-soft { background: var(--cream-soft); color: var(--green-dark); border: 1px solid #d4c5aa; }
        .btn-soft:hover { background: #e5dac3; }
        .btn-logout { width: 100%; background: rgba(255, 253, 249, 0.12); color: #fffdf9; border: 1px solid rgba(255, 253, 249, 0.2); }
        .btn-logout:hover { background: var(--orange); border-color: var(--orange); }
        .btn-sm { padding: 5px 8px; font-size: 11.5px; border-radius: 7px; }

        .row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-top: 13px; }
        .toolbar { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .toolbar input, .toolbar select { width: auto; min-width: 150px; margin-top: 0; padding: 7px 10px; font-size: 12.5px; }

        .alert { padding: 10px 12px; border-radius: 9px; font-size: 13px; margin-top: 12px; display: none; }
        .alert.ok { display: block; background: var(--ok-bg); border: 1px solid #9fd4b5; color: var(--ok-text); }
        .alert.err { display: block; background: var(--err-bg); border: 1px solid #f3b5a8; color: var(--err-text); }

        .kpi-box {
            background: #fff;
            border: 1px solid var(--border);
            border-left: 4px solid var(--green-dark);
            border-radius: 11px;
            padding: 13px 14px;
        }
        .kpi-box.accent-orange { border-left-color: var(--orange); }
        .kpi-label { font-size: 11.5px; color: var(--text-muted); font-weight: 600; }
        .kpi-val { font-size: 20px; font-weight: 800; color: var(--green-dark); margin-top: 3px; }
        .kpi-sub { font-size: 11px; color: var(--orange); font-weight: 700; margin-top: 2px; }

        .section-box { display: none; }
        .section-box.active { display: block; }

        .table-wrap { overflow-x: auto; margin-top: 12px; border: 1px solid var(--border); border-radius: 11px; background: #fff; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #efe7d6; vertical-align: middle; }
        th { background: var(--green-dark); color: #fffdf9; font-size: 12px; white-space: nowrap; }
        tbody tr:hover { background: var(--cream-hover); }
        tr:last-child td { border-bottom: none; }

        .badge-safe { background: var(--ok-bg); color: var(--ok-text); border: 1px solid #9fd4b5; padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; }
        .badge-low { background: var(--orange-soft); color: var(--orange); border: 1px solid #f2b487; padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; }
        .menu-pill {
            display: inline-block; background: #eaf3ee; color: var(--green-dark);
            border: 1px solid #b7d2c3; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 999px;
        }
        .cat-pill {
            display: inline-block; background: var(--cream-soft); color: var(--green-dark);
            border: 1px solid #d4c5aa; font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 999px;
        }

        .idea-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; margin-top: 12px; }
        .idea-card {
            background: #fff;
            border: 1px solid var(--border);
            border-top: 4px solid var(--green-dark);
            border-radius: 12px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .idea-card.drink { border-top-color: var(--orange); }
        .idea-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; }
        .idea-bahan { font-size: 15px; font-weight: 800; color: var(--green-dark); }
        .idea-chips { display: flex; flex-wrap: wrap; gap: 6px; }
        .dish-chip {
            background: var(--orange-soft);
            color: var(--orange-hover);
            border: 1px solid #f0be99;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
        }
        .dish-chip.drink-chip {
            background: #eaf3ee;
            color: var(--green-dark);
            border-color: #b7d2c3;
        }

        .struk { background: #fff; border: 1.5px dashed var(--green-dark); border-radius: 11px; padding: 16px; margin-top: 12px; }
        .struk-line { display: flex; justify-content: space-between; font-size: 13px; padding: 7px 0; border-bottom: 1px solid #eee5d4; }
        .struk-total { display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; color: var(--orange); padding-top: 11px; }

        .dropzone {
            border: 1.5px dashed var(--green-mid); background: #fff; border-radius: 11px;
            padding: 16px; text-align: center; cursor: pointer;
        }
        .dropzone:hover, .dropzone.dragover { border-color: var(--orange); background: #fff8f0; }
        .dropzone input[type="file"] { display: none; }
        .dropzone-title { font-size: 13px; font-weight: 700; color: var(--green-dark); }
        .dropzone-sub { font-size: 11px; color: var(--text-muted); margin-top: 4px; }
        .file-meta { font-size: 12px; color: var(--orange); margin-top: 8px; font-weight: 700; word-break: break-all; }
        .preview-box {
            background: #fff; border: 1px solid var(--border); border-radius: 11px;
            padding: 12px; display: flex; gap: 12px; align-items: center; margin-top: 12px;
        }
        .preview-img {
            width: 96px; height: 68px; object-fit: cover; border-radius: 8px;
            border: 1px solid var(--border); background: var(--cream-soft); flex-shrink: 0;
        }

        @media (max-width: 900px) {
            .grid-stok { grid-template-columns: 1fr; }
        }

        @media (max-width: 820px) {
            .app-shell { grid-template-columns: 1fr; }
            .sidebar { border-right: none; border-bottom: 2px solid #21523e; }
        }

        @media print {
            body { background: #fff; color: #000; }
            .no-print, .sidebar, .word-ribbon { display: none !important; }
            .app-shell { display: block; }
            .card, .struk { border: 1px solid #000; background: #fff; color: #000; box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="app-shell" id="mainShell" style="display:none;">
    <aside class="sidebar no-print">
        <div>
            <div class="side-brand">
                <div class="brand-box">AW</div>
                <div>
                    <div class="side-title">APB WARTEG</div>
                    <div class="side-sub">Panel Admin</div>
                </div>
            </div>

            <div style="margin-top:16px;">
                <div class="side-label">Menu Navigasi</div>
                <nav class="side-nav">
                    <button type="button" class="side-btn active" id="sideBtn-bahan" onclick="switchSection('bahan')">
                        <span>Stok Bahan Permenu</span>
                        <span>›</span>
                    </button>
                    <button type="button" class="side-btn" id="sideBtn-olahan" onclick="switchSection('olahan')">
                        <span>Ide Olahan Otomatis</span>
                        <span>›</span>
                    </button>
                    <button type="button" class="side-btn" id="sideBtn-transaksi" onclick="switchSection('transaksi')">
                        <span>Transaksi Pelanggan</span>
                        <span>›</span>
                    </button>
                    <button type="button" class="side-btn" id="sideBtn-gambar" onclick="switchSection('gambar')">
                        <span>Gambar Menu</span>
                        <span>›</span>
                    </button>
                </nav>
            </div>
        </div>

        <div class="side-footer">
            <div class="admin-mini">
                <div id="userStatus" style="font-weight:700;">Memeriksa sesi...</div>
                <span class="role-tag">ADMIN</span>
            </div>
            <button type="button" class="btn-logout" onclick="logoutUser()">Logout</button>
        </div>
    </aside>

    <div class="main-area">
        <header class="word-ribbon no-print">
            <div class="ribbon-groups">
                <div class="ribbon-group">
                    <span class="ribbon-group-title">Halaman Aktif:</span>
                    <span class="badge-orange" id="ribbonActiveTitle">Stok Bahan Permenu</span>
                </div>
                <div class="ribbon-group">
                    <span class="ribbon-group-title">Aksi Cepat:</span>
                    <button type="button" class="btn-soft btn-sm" onclick="loadMenus()">Refresh Menu</button>
                    <button type="button" class="btn-soft btn-sm" onclick="switchSection('olahan')">Cek Ide Olahan</button>
                    <button type="button" class="btn-soft btn-sm" onclick="refreshTransactionsView()">Refresh Transaksi</button>
                </div>
            </div>
            <div class="sub" id="ribbonHint">Kelola stok makanan & minuman per menu</div>
        </header>

        <main class="content-wrap">
            <!-- 1. STOK BAHAN PERMENU -->
            <section class="card section-box active no-print" id="sec-bahan">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Stok Bahan Masakan & Minuman Permenu</h2>
                        <div class="sub">Pilih kategori (Makanan / Minuman) dan menu lalu atur stok bahannya.</div>
                    </div>
                    <span class="badge-orange">STOK BAHAN</span>
                </div>

                <div class="grid-2-kpi" style="margin-bottom:16px;">
                    <div class="kpi-box">
                        <div class="kpi-label">Item Bahan Tercatat</div>
                        <div class="kpi-val" id="kpiBahanTotal">0</div>
                        <div class="kpi-sub">Makanan & minuman</div>
                    </div>
                    <div class="kpi-box accent-orange">
                        <div class="kpi-label">Bahan Menipis</div>
                        <div class="kpi-val" id="kpiBahanLow">0</div>
                        <div class="kpi-sub">Perlu restock</div>
                    </div>
                </div>

                <div class="grid-stok">
                    <div class="form-panel">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <h3 style="font-size:15px; color:var(--green-dark);" id="bahanFormTitle">Tambah / Edit Bahan</h3>
                            <span id="editingBadge" style="display:none; font-size:11px; font-weight:700; color:var(--orange);">MODE EDIT</span>
                        </div>

                        <div class="form-row-2">
                            <div>
                                <label>Kategori</label>
                                <select id="bahanKategori" onchange="renderIngredients()">
                                    <option value="Makanan">Makanan</option>
                                    <option value="Minuman">Minuman</option>
                                </select>
                            </div>
                            <div>
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; margin-bottom:5px;">
                                    <label style="margin:0;">Target Menu</label>
                                    <button type="button" class="btn-soft btn-sm" style="padding:2px 6px; font-size:10px;" onclick="loadMenus()">Ambil</button>
                                </div>
                                <select id="bahanMenuSelect" onchange="renderIngredients()" style="margin-top:0;">
                                    <option value="umum">Umum / Semua Menu</option>
                                </select>
                            </div>
                        </div>

                        <label>Nama Bahan</label>
                        <input type="text" id="bahanNama" placeholder="Contoh: Telur, Tempe, Ayam, Teh, Es Batu">

                        <div class="form-row-2">
                            <div>
                                <label>Jumlah Stok</label>
                                <input type="number" id="bahanJumlah" min="0" step="0.5" value="5" oninput="updateEstimatedPortions()">
                            </div>
                            <div>
                                <label>Satuan</label>
                                <select id="bahanSatuan">
                                    <option value="butir">butir</option>
                                    <option value="papan">papan</option>
                                    <option value="kg">kg</option>
                                    <option value="liter">liter</option>
                                    <option value="ikat">ikat</option>
                                    <option value="porsi">porsi</option>
                                    <option value="pack">pack</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div>
                                <label>Takaran / Porsi</label>
                                <input type="number" id="bahanTakaran" min="0" step="0.05" value="1" oninput="updateEstimatedPortions()">
                            </div>
                            <div>
                                <label>Batas Menipis</label>
                                <input type="number" id="bahanMinStok" min="0" step="0.5" value="2">
                            </div>
                        </div>

                        <div class="sub" id="estimasiPorsiText" style="margin-top:8px; font-weight:600; color:var(--green-dark);">
                            Estimasi hasil: ±5 porsi
                        </div>

                        <label>Catatan Masak / Takaran</label>
                        <input type="text" id="bahanCatatan" placeholder="Contoh: Bisa didadar, diceplok, atau dibalado">

                        <div class="row">
                            <button type="button" class="btn-green" id="saveBahanBtn" onclick="saveIngredientStock()">Simpan Bahan</button>
                            <button type="button" class="btn-soft" onclick="resetIngredientForm()">Bersihkan</button>
                            <button type="button" class="btn-orange" onclick="seedSampleIngredients()">Isi Contoh</button>
                        </div>
                        <div id="bahanMsg" class="alert"></div>
                    </div>

                    <div style="min-width:0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap;">
                            <h3 style="font-size:15px; color:var(--green-dark);">Daftar Stok Bahan</h3>
                            <div class="toolbar">
                                <input type="text" id="searchBahanInput" oninput="renderIngredients()" placeholder="Cari bahan...">
                                <select id="filterKategoriBahan" onchange="renderIngredients()">
                                    <option value="ALL">Semua Kategori</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Minuman">Minuman</option>
                                </select>
                                <select id="filterMenuBahan" onchange="renderIngredients()">
                                    <option value="ALL">Semua Menu</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Kategori & Menu</th>
                                        <th>Bahan</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="ingredientTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 2. IDE OLAHAN OTOMATIS DARI STOK BAHAN -->
            <section class="card section-box no-print" id="sec-olahan">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Ide Olahan Otomatis dari Stok Bahan</h2>
                        <div class="sub">Otomatis mendeteksi bahan yang tersedia di stok (misalnya Telur, Tempe, Ayam, Teh) lalu menampilkan kemungkinan olahannya.</div>
                    </div>
                    <span class="badge-orange">AUTO OLAHAN</span>
                </div>

                <div class="grid-2" style="margin-bottom:16px;">
                    <div class="form-panel">
                        <h3 style="font-size:14px; color:var(--green-dark);">Tambah / Sesuaikan Aturan Olahan Bahan</h3>
                        <div class="sub">Misalnya: kata kunci <b>tempe</b> → <i>Tempe Orek, Tempe Bacem, Tempe Mendoan</i>.</div>

                        <label>Kata Kunci Bahan (di nama stok)</label>
                        <input type="text" id="ruleKeyword" placeholder="Contoh: telur / tempe / tahu / ayam / teh">

                        <label>Jenis</label>
                        <select id="ruleCategory">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>

                        <label>Daftar Olahan / Masakan (pisahkan dengan koma)</label>
                        <input type="text" id="ruleDishes" placeholder="Contoh: Tempe Orek, Tempe Bacem, Tempe Mendoan">

                        <div class="row">
                            <button type="button" class="btn-green" onclick="saveRecipeRule()">Simpan Aturan Olahan</button>
                            <button type="button" class="btn-soft" onclick="resetRecipeRulesToDefault()">Reset Default</button>
                        </div>
                        <div id="ruleMsg" class="alert"></div>
                    </div>

                    <div class="form-panel">
                        <h3 style="font-size:14px; color:var(--green-dark);">Cara Kerja Deteksi Otomatis</h3>
                        <div class="sub" style="margin-top:6px;">
                            Setiap kali kamu menambah atau mengubah stok bahan di menu <b>Stok Bahan Permenu</b>, halaman ini langsung mencocokkan nama bahannya dengan kamus olahan warteg.
                        </div>
                        <div class="row" style="margin-top:12px;">
                            <button type="button" class="btn-orange" onclick="seedSampleIngredients(); renderRecipeSuggestions();">Isi Contoh Stok (Telur, Tempe, Teh)</button>
                            <button type="button" class="btn-soft" onclick="switchSection('bahan')">Ke Stok Bahan</button>
                        </div>
                    </div>
                </div>

                <h3 style="font-size:15px; color:var(--green-dark);">Hasil Deteksi Olahan dari Stok Saat Ini</h3>
                <div id="recipeSuggestionsGrid" class="idea-grid"></div>
            </section>

            <!-- 3. TRANSAKSI PELANGGAN -->
            <section class="card section-box no-print" id="sec-transaksi">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Transaksi Pelanggan</h2>
                        <div class="sub">Pantau transaksi masuk dan buka bukti transaksi untuk dicetak.</div>
                    </div>
                    <span class="badge-orange">TRANSAKSI</span>
                </div>

                <div class="grid-4" style="margin-bottom:16px;">
                    <div class="kpi-box">
                        <div class="kpi-label">Jumlah Transaksi</div>
                        <div class="kpi-val" id="kpiTrxCount">0</div>
                        <div class="kpi-sub">Pesanan tercatat</div>
                    </div>
                    <div class="kpi-box accent-orange">
                        <div class="kpi-label">Total Pendapatan</div>
                        <div class="kpi-val" id="kpiOmzet">Rp0</div>
                        <div class="kpi-sub">Akumulasi transaksi</div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h3 style="font-size:15px; color:var(--green-dark);">Riwayat Transaksi</h3>
                    <div class="toolbar">
                        <input type="text" id="searchTrxInput" oninput="renderTransactionsHistory()" placeholder="Cari pelanggan / menu / #ID...">
                        <button type="button" class="btn-green" onclick="refreshTransactionsView()">Muat Ulang</button>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Waktu</th>
                                <th>Menu</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="trxHistoryBody">
                            <tr><td colspan="7" class="sub">Belum ada transaksi pelanggan.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 4. GAMBAR MENU -->
            <section class="card section-box no-print" id="sec-gambar">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Kelola Gambar Menu</h2>
                        <div class="sub">Klik kartu menu atau pilih dari dropdown untuk mengganti foto menu.</div>
                    </div>
                    <span class="badge-orange">GAMBAR MENU</span>
                </div>

                <div class="grid-2">
                    <div>
                        <label>Target Menu</label>
                        <select id="adminMenuSelect" onchange="syncAdminPreview()"></select>

                        <div class="preview-box">
                            <img id="adminPreviewImg" class="preview-img" src="" alt="Preview">
                            <div>
                                <div id="adminPreviewLabel" style="font-size:12px; font-weight:700; color:var(--green-dark);">Preview Gambar</div>
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
                            <button type="button" class="btn-orange" onclick="uploadMenuImage()">Simpan & Upload Gambar</button>
                            <button type="button" class="btn-soft" onclick="clearAdminFile()">Reset File</button>
                        </div>
                    </div>
                </div>
                <div id="adminMsg" class="alert"></div>

                <div style="margin-top:20px; padding-top:14px; border-top:1px solid var(--border);">
                    <h3 style="font-size:14px; color:var(--green-dark);">Daftar Menu (Klik untuk Pilih)</h3>
                    <div id="menuList" class="menus">
                        <div class="sub">Memuat menu...</div>
                    </div>
                </div>
            </section>

            <!-- Bukti Transaksi -->
            <section class="card" id="receiptCard" style="display:none;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <h3 style="font-size:15px; color:var(--green-dark);">Bukti Transaksi Pelanggan</h3>
                    <div class="row" style="margin-top:0;">
                        <button class="btn-green no-print" onclick="window.print()">Cetak / Print</button>
                        <button class="btn-soft no-print" onclick="document.getElementById('receiptCard').style.display='none'">Tutup</button>
                    </div>
                </div>
                <div id="receiptBox" class="struk"></div>
            </section>
        </main>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const STORAGE_INGREDIENTS_KEY = 'apb_warteg_ingredients_per_menu_v2';
const STORAGE_RULES_KEY = 'apb_warteg_recipe_rules_v1';
const STORAGE_TRX_KEY = 'apb_warteg_transactions_v1';

const DEFAULT_RECIPE_RULES = [
    { keyword: 'telur', category: 'Makanan', dishes: ['Telur Dadar', 'Telur Ceplok / Mata Sapi', 'Telur Balado', 'Semur Telur'] },
    { keyword: 'tempe', category: 'Makanan', dishes: ['Tempe Orek', 'Tempe Bacem', 'Tempe Mendoan', 'Tempe Goreng Tepung'] },
    { keyword: 'tahu', category: 'Makanan', dishes: ['Tahu Goreng', 'Tahu Bacem', 'Tahu Balado', 'Perkedel Tahu'] },
    { keyword: 'ayam', category: 'Makanan', dishes: ['Ayam Goreng', 'Ayam Geprek', 'Ayam Kecap', 'Semur Ayam'] },
    { keyword: 'ikan', category: 'Makanan', dishes: ['Ikan Goreng', 'Ikan Balado', 'Pindang Ikan'] },
    { keyword: 'sayur', category: 'Makanan', dishes: ['Sayur Lodeh', 'Tumis Sayur', 'Capcay Warteg'] },
    { keyword: 'teh', category: 'Minuman', dishes: ['Es Teh Manis', 'Teh Hangat Tawar', 'Teh Lemon'] },
    { keyword: 'kopi', category: 'Minuman', dishes: ['Kopi Hitam Panas', 'Es Kopi Susu', 'Kopi Tubruk'] },
    { keyword: 'jeruk', category: 'Minuman', dishes: ['Es Jeruk Peras', 'Jeruk Hangat'] }
];

const SECTION_META = {
    bahan: { title: 'Stok Bahan Permenu', hint: 'Kelola stok makanan & minuman per menu' },
    olahan: { title: 'Ide Olahan Otomatis', hint: 'Deteksi kemungkinan masakan/minuman dari stok' },
    transaksi: { title: 'Transaksi Pelanggan', hint: 'Cek riwayat & cetak bukti transaksi' },
    gambar: { title: 'Gambar Menu', hint: 'Unggah & perbarui foto menu' }
};

let menusCache = [];
let ingredientsCache = [];
let recipeRulesCache = [];
let transactionsCache = [];
let tempPreviewUrl = null;
let editingIngredientId = null;
let alertTimers = {};

const fmtRp = (num) => 'Rp' + Number(num || 0).toLocaleString('id-ID');

function escapeHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function getMenuDisplayName(menu) {
    return menu?.name ?? menu?.nama_menu ?? (`Menu #${menu?.id ?? ''}`);
}

function hideAllAlerts() {
    Object.keys(alertTimers).forEach((key) => {
        clearTimeout(alertTimers[key]);
        delete alertTimers[key];
    });
    document.querySelectorAll('.alert').forEach((el) => {
        el.className = 'alert';
        el.textContent = '';
    });
}

function showAlert(elId, type, text, duration = 3500) {
    const el = document.getElementById(elId);
    if (!el) return;

    if (alertTimers[elId]) {
        clearTimeout(alertTimers[elId]);
    }

    el.className = 'alert ' + (type === 'ok' ? 'ok' : 'err');
    el.textContent = text;

    if (duration > 0) {
        alertTimers[elId] = setTimeout(() => {
            el.className = 'alert';
            el.textContent = '';
            delete alertTimers[elId];
        }, duration);
    }
}

function switchSection(sectionName) {
    hideAllAlerts();
    ['bahan', 'olahan', 'transaksi', 'gambar'].forEach(name => {
        document.getElementById(`sideBtn-${name}`)?.classList.toggle('active', name === sectionName);
        document.getElementById(`sec-${name}`)?.classList.toggle('active', name === sectionName);
    });
    const meta = SECTION_META[sectionName] || SECTION_META.bahan;
    document.getElementById('ribbonActiveTitle').textContent = meta.title;
    document.getElementById('ribbonHint').textContent = meta.hint;
    if (sectionName === 'olahan') renderRecipeSuggestions();
    if (sectionName === 'transaksi') refreshTransactionsView();
}

async function checkMe() {
    try {
        const res = await fetch('/me', { headers: { 'Accept': 'application/json' } });
        if (res.status === 401) {
            window.location.replace('/admin/login');
            return false;
        }
        const data = await res.json();
        const user = data?.data?.user ?? data?.user;
        if (!res.ok || !user || user.role !== 'admin') {
            window.location.replace('/admin/login');
            return false;
        }
        document.getElementById('userStatus').textContent = user.name;
        document.getElementById('mainShell').style.display = 'grid';
        return true;
    } catch {
        window.location.replace('/admin/login');
        return false;
    }
}

async function logoutUser() {
    try {
        await fetch('/logout', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
        });
    } finally {
        window.location.replace('/admin/login');
    }
}

function updateEstimatedPortions() {
    const stock = Number(document.getElementById('bahanJumlah')?.value || 0);
    const perPortion = Number(document.getElementById('bahanTakaran')?.value || 0);
    const el = document.getElementById('estimasiPorsiText');
    if (!el) return;

    if (perPortion > 0) {
        const est = Math.floor(stock / perPortion);
        el.textContent = `Estimasi hasil: ±${est} porsi (dari ${stock} stok ÷ ${perPortion}/porsi)`;
    } else {
        el.textContent = `Estimasi hasil: isi takaran per porsi untuk hitung otomatis`;
    }
}

function loadLocalIngredients() {
    try {
        const raw = localStorage.getItem(STORAGE_INGREDIENTS_KEY);
        ingredientsCache = raw ? JSON.parse(raw) : [];
    } catch {
        ingredientsCache = [];
    }
    renderIngredients();
    renderRecipeSuggestions();
}

function saveLocalIngredients() {
    localStorage.setItem(STORAGE_INGREDIENTS_KEY, JSON.stringify(ingredientsCache));
    renderIngredients();
    renderRecipeSuggestions();
}

function loadRecipeRules() {
    try {
        const raw = localStorage.getItem(STORAGE_RULES_KEY);
        recipeRulesCache = raw ? JSON.parse(raw) : [...DEFAULT_RECIPE_RULES];
    } catch {
        recipeRulesCache = [...DEFAULT_RECIPE_RULES];
    }
    renderRecipeSuggestions();
}

function saveRecipeRule() {
    const keyword = (document.getElementById('ruleKeyword')?.value || '').trim().toLowerCase();
    const category = document.getElementById('ruleCategory')?.value || 'Makanan';
    const rawDishes = (document.getElementById('ruleDishes')?.value || '').trim();

    if (!keyword) return showAlert('ruleMsg', 'err', 'Kata kunci bahan wajib diisi.');
    const dishes = rawDishes.split(',').map(s => s.trim()).filter(Boolean);
    if (!dishes.length) return showAlert('ruleMsg', 'err', 'Masukkan minimal 1 nama olahan.');

    const idx = recipeRulesCache.findIndex(r => r.keyword.toLowerCase() === keyword);
    if (idx >= 0) {
        recipeRulesCache[idx] = { keyword, category, dishes };
        showAlert('ruleMsg', 'ok', `Aturan olahan untuk "${keyword}" diperbarui.`);
    } else {
        recipeRulesCache.push({ keyword, category, dishes });
        showAlert('ruleMsg', 'ok', `Aturan olahan untuk "${keyword}" ditambahkan.`);
    }

    localStorage.setItem(STORAGE_RULES_KEY, JSON.stringify(recipeRulesCache));
    document.getElementById('ruleKeyword').value = '';
    document.getElementById('ruleDishes').value = '';
    renderRecipeSuggestions();
}

function resetRecipeRulesToDefault() {
    recipeRulesCache = [...DEFAULT_RECIPE_RULES];
    localStorage.setItem(STORAGE_RULES_KEY, JSON.stringify(recipeRulesCache));
    showAlert('ruleMsg', 'ok', 'Aturan olahan dikembalikan ke bawaan warteg.');
    renderRecipeSuggestions();
}

function getSuggestedDishesForIngredient(item) {
    const nameLower = String(item.name || '').toLowerCase();
    const matched = [];
    recipeRulesCache.forEach(rule => {
        if (nameLower.includes(rule.keyword.toLowerCase())) {
            rule.dishes.forEach(d => {
                if (!matched.includes(d)) matched.push(d);
            });
        }
    });
    if (!matched.length) {
        return item.category === 'Minuman'
            ? [`${item.name} Dingin`, `${item.name} Hangat`]
            : [`Tumis ${item.name}`, `${item.name} Spesial Warteg`];
    }
    return matched;
}

function renderRecipeSuggestions() {
    const grid = document.getElementById('recipeSuggestionsGrid');
    if (!grid) return;

    if (!ingredientsCache.length) {
        grid.innerHTML = '<div class="sub">Belum ada stok bahan. Tambahkan bahan seperti <b>Telur</b>, <b>Tempe</b>, atau <b>Teh</b> di menu Stok Bahan Permenu agar rekomendasi olahan muncul otomatis.</div>';
        return;
    }

    grid.innerHTML = ingredientsCache.map(item => {
        const dishes = getSuggestedDishesForIngredient(item);
        const perPortion = Number(item.per_portion || 0);
        const estText = perPortion > 0 ? ` • ±${Math.floor(Number(item.stock) / perPortion)} porsi` : '';
        const isDrink = item.category === 'Minuman';

        return `
            <div class="idea-card ${isDrink ? 'drink' : ''}">
                <div class="idea-head">
                    <div>
                        <span class="cat-pill">${escapeHtml(item.category || 'Makanan')}</span>
                        <div class="idea-bahan" style="margin-top:6px;">${escapeHtml(item.name)}</div>
                        <div class="sub" style="font-size:12px;">Stok: <b>${item.stock}</b> ${escapeHtml(item.unit)}${estText}</div>
                    </div>
                    <span class="menu-pill">${escapeHtml(item.menu_label)}</span>
                </div>
                <div class="sub" style="font-size:11.5px; font-weight:700; color:var(--green-dark);">Bisa dibuat menjadi:</div>
                <div class="idea-chips">
                    ${dishes.map(d => `<span class="dish-chip ${isDrink ? 'drink-chip' : ''}">${escapeHtml(d)}</span>`).join('')}
                </div>
            </div>
        `;
    }).join('');
}

function loadLocalTransactions() {
    try {
        const raw = localStorage.getItem(STORAGE_TRX_KEY);
        transactionsCache = raw ? JSON.parse(raw) : [];
    } catch {
        transactionsCache = [];
    }
    renderTransactionsHistory();
}

function updateKpiStats() {
    const lowCount = ingredientsCache.filter(item => Number(item.stock) <= Number(item.min_stock ?? 2)).length;
    const totalOmzet = transactionsCache.reduce((sum, t) => sum + Number(t.total_price || 0), 0);

    document.getElementById('kpiBahanTotal').textContent = ingredientsCache.length;
    document.getElementById('kpiBahanLow').textContent = lowCount;
    document.getElementById('kpiTrxCount').textContent = transactionsCache.length;
    document.getElementById('kpiOmzet').textContent = fmtRp(totalOmzet);
}

function resetIngredientForm() {
    editingIngredientId = null;
    document.getElementById('bahanKategori').value = 'Makanan';
    document.getElementById('bahanNama').value = '';
    document.getElementById('bahanJumlah').value = '5';
    document.getElementById('bahanTakaran').value = '1';
    document.getElementById('bahanMinStok').value = '2';
    document.getElementById('bahanCatatan').value = '';
    document.getElementById('bahanFormTitle').textContent = 'Tambah / Edit Bahan';
    document.getElementById('saveBahanBtn').textContent = 'Simpan Bahan';
    document.getElementById('editingBadge').style.display = 'none';
    updateEstimatedPortions();
}

function editIngredient(id) {
    const item = ingredientsCache.find(row => String(row.id) === String(id));
    if (!item) return;

    editingIngredientId = item.id;
    document.getElementById('bahanKategori').value = item.category || 'Makanan';
    const menuSelect = document.getElementById('bahanMenuSelect');
    if (menuSelect && [...menuSelect.options].some(o => String(o.value) === String(item.menu_key))) {
        menuSelect.value = String(item.menu_key);
    }
    document.getElementById('bahanNama').value = item.name;
    document.getElementById('bahanJumlah').value = item.stock;
    document.getElementById('bahanSatuan').value = item.unit || 'butir';
    document.getElementById('bahanTakaran').value = item.per_portion ?? 1;
    document.getElementById('bahanMinStok').value = item.min_stock ?? 2;
    document.getElementById('bahanCatatan').value = item.note && item.note !== '-' ? item.note : '';

    document.getElementById('bahanFormTitle').textContent = `Edit Bahan: ${item.name}`;
    document.getElementById('saveBahanBtn').textContent = 'Perbarui Bahan';
    document.getElementById('editingBadge').style.display = 'inline';
    updateEstimatedPortions();
    switchSection('bahan');
}

function saveIngredientStock() {
    const category = document.getElementById('bahanKategori').value || 'Makanan';
    const menuSelect = document.getElementById('bahanMenuSelect');
    const nameInput = document.getElementById('bahanNama');
    const qtyInput = document.getElementById('bahanJumlah');
    const unitSelect = document.getElementById('bahanSatuan');
    const portionInput = document.getElementById('bahanTakaran');
    const minInput = document.getElementById('bahanMinStok');
    const noteInput = document.getElementById('bahanCatatan');

    const menuKey = menuSelect.value || 'umum';
    const menuLabel = menuSelect.options[menuSelect.selectedIndex]?.text || 'Umum / Semua Menu';
    const name = nameInput.value.trim();
    const stock = Number(qtyInput.value);
    const unit = unitSelect.value;
    const perPortion = Number(portionInput.value || 0);
    const minStock = Number(minInput.value || 2);
    const note = noteInput.value.trim() || '-';

    if (!name) return showAlert('bahanMsg', 'err', 'Nama bahan wajib diisi.');
    if (Number.isNaN(stock) || stock < 0) return showAlert('bahanMsg', 'err', 'Jumlah stok tidak boleh negatif.');

    const payload = {
        category,
        menu_key: menuKey,
        menu_label: menuLabel,
        name,
        stock,
        unit,
        per_portion: perPortion,
        min_stock: minStock,
        note
    };

    if (editingIngredientId !== null) {
        const idx = ingredientsCache.findIndex(item => String(item.id) === String(editingIngredientId));
        if (idx >= 0) {
            ingredientsCache[idx] = { ...ingredientsCache[idx], ...payload };
            showAlert('bahanMsg', 'ok', `Bahan "${name}" diperbarui.`);
        }
        resetIngredientForm();
        saveLocalIngredients();
        return;
    }

    const existingIdx = ingredientsCache.findIndex(
        item => String(item.menu_key) === String(menuKey) && item.name.toLowerCase() === name.toLowerCase()
    );

    if (existingIdx >= 0) {
        ingredientsCache[existingIdx] = { ...ingredientsCache[existingIdx], ...payload };
        showAlert('bahanMsg', 'ok', `Bahan "${name}" untuk ${menuLabel} diperbarui.`);
    } else {
        ingredientsCache.unshift({ id: Date.now(), ...payload });
        showAlert('bahanMsg', 'ok', `Bahan "${name}" (${category}) ditambahkan.`);
    }

    saveLocalIngredients();
    nameInput.value = '';
    noteInput.value = '';
    updateEstimatedPortions();
}

function seedSampleIngredients() {
    if (ingredientsCache.length) {
        showAlert('bahanMsg', 'err', 'Daftar bahan sudah terisi.');
        return;
    }
    const firstMenu = menusCache[0];
    const mKey = firstMenu ? String(firstMenu.id) : 'umum';
    const mLabel = firstMenu ? getMenuDisplayName(firstMenu) : 'Umum / Semua Menu';

    ingredientsCache = [
        { id: 1, category: 'Makanan', menu_key: mKey, menu_label: mLabel, name: 'Telur Ayam', stock: 24, unit: 'butir', per_portion: 1, min_stock: 8, note: 'Bisa dadar, ceplok, atau balado' },
        { id: 2, category: 'Makanan', menu_key: mKey, menu_label: mLabel, name: 'Tempe', stock: 8, unit: 'papan', per_portion: 0.5, min_stock: 3, note: 'Cocok untuk orek, bacem, atau mendoan' },
        { id: 3, category: 'Minuman', menu_key: 'umum', menu_label: 'Umum / Semua Menu', name: 'Teh Celup & Gula', stock: 30, unit: 'porsi', per_portion: 1, min_stock: 10, note: 'Es teh manis atau teh hangat' }
    ];
    saveLocalIngredients();
    showAlert('bahanMsg', 'ok', 'Contoh bahan (Telur, Tempe, Teh) dimuat. Cek tab Ide Olahan Otomatis!');
}

function adjustIngredientStock(id, delta) {
    const idx = ingredientsCache.findIndex(item => String(item.id) === String(id));
    if (idx < 0) return;
    ingredientsCache[idx].stock = Math.max(0, Number((Number(ingredientsCache[idx].stock) + delta).toFixed(2)));
    saveLocalIngredients();
}

function deleteIngredient(id) {
    if (String(editingIngredientId) === String(id)) resetIngredientForm();
    ingredientsCache = ingredientsCache.filter(item => String(item.id) !== String(id));
    saveLocalIngredients();
}

function renderIngredients() {
    const tbody = document.getElementById('ingredientTableBody');
    const catFilter = document.getElementById('filterKategoriBahan')?.value || 'ALL';
    const menuFilter = document.getElementById('filterMenuBahan')?.value || 'ALL';
    const keyword = (document.getElementById('searchBahanInput')?.value || '').trim().toLowerCase();
    if (!tbody) return;

    const filtered = ingredientsCache.filter(item => {
        const matchCat = catFilter === 'ALL' || (item.category || 'Makanan') === catFilter;
        const matchMenu = menuFilter === 'ALL' || String(item.menu_key) === String(menuFilter);
        const matchText = !keyword
            || String(item.name).toLowerCase().includes(keyword)
            || String(item.menu_label).toLowerCase().includes(keyword)
            || String(item.category || '').toLowerCase().includes(keyword)
            || String(item.note || '').toLowerCase().includes(keyword);
        return matchCat && matchMenu && matchText;
    });

    if (!filtered.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="sub">Belum ada bahan yang cocok.</td></tr>';
        updateKpiStats();
        return;
    }

    tbody.innerHTML = filtered.map(item => {
        const isLow = Number(item.stock) <= Number(item.min_stock ?? 2);
        const badge = isLow ? '<span class="badge-low">Menipis</span>' : '<span class="badge-safe">Aman</span>';
        const perPortion = Number(item.per_portion || 0);
        const estInfo = perPortion > 0 ? `±${Math.floor(Number(item.stock) / perPortion)} porsi` : '';

        return `
            <tr>
                <td>
                    <span class="cat-pill">${escapeHtml(item.category || 'Makanan')}</span>
                    <div style="margin-top:4px;"><span class="menu-pill">${escapeHtml(item.menu_label)}</span></div>
                </td>
                <td>
                    <div><b>${escapeHtml(item.name)}</b></div>
                    <div class="sub" style="font-size:11px;">${escapeHtml(item.note || '-')}</div>
                </td>
                <td><b>${item.stock}</b> ${escapeHtml(item.unit)}<div class="sub" style="font-size:11px;">${estInfo}</div></td>
                <td>${badge}</td>
                <td>
                    <div style="display:flex; gap:4px; flex-wrap:wrap;">
                        <button type="button" class="btn-soft btn-sm" onclick="adjustIngredientStock(${item.id}, -1)">-1</button>
                        <button type="button" class="btn-green btn-sm" onclick="adjustIngredientStock(${item.id}, 1)">+1</button>
                        <button type="button" class="btn-soft btn-sm" onclick="editIngredient(${item.id})">Edit</button>
                        <button type="button" class="btn-soft btn-sm" onclick="deleteIngredient(${item.id})">Hapus</button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

    updateKpiStats();
}

async function refreshTransactionsView() {
    try {
        const res = await fetch('/transactions', { headers: { 'Accept': 'application/json' } });
        if (res.status === 401) {
            window.location.replace('/admin/login');
            return;
        }
        if (res.ok) {
            const json = await res.json();
            const list = Array.isArray(json.data) ? json.data : (Array.isArray(json) ? json : null);
            if (list) {
                transactionsCache = list;
                localStorage.setItem(STORAGE_TRX_KEY, JSON.stringify(transactionsCache.slice(0, 100)));
            }
        }
    } catch {}
    renderTransactionsHistory();
}

function renderTransactionsHistory() {
    const tbody = document.getElementById('trxHistoryBody');
    const keyword = (document.getElementById('searchTrxInput')?.value || '').trim().toLowerCase();
    if (!tbody) return;

    const filtered = transactionsCache.filter(trx => {
        if (!keyword) return true;
        const menu = trx.menu || {};
        const menuName = String(menu.name ?? menu.nama_menu ?? '').toLowerCase();
        const customerName = String(trx.user?.name ?? trx.customer_name ?? 'Pelanggan').toLowerCase();
        const idStr = String(trx.id ?? '').toLowerCase();
        return menuName.includes(keyword) || customerName.includes(keyword) || idStr.includes(keyword);
    });

    if (!filtered.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="sub">Belum ada transaksi pelanggan.</td></tr>';
        updateKpiStats();
        return;
    }

    tbody.innerHTML = filtered.map((trx, idx) => {
        const menu = trx.menu || {};
        const menuName = menu.name ?? menu.nama_menu ?? ('Menu #' + (trx.menu_id ?? '-'));
        const customerName = trx.user?.name ?? trx.customer_name ?? 'Pelanggan';
        const waktu = trx.created_at ? new Date(trx.created_at).toLocaleString('id-ID') : '-';

        return `
            <tr>
                <td>#${trx.id ?? (idx + 1)}</td>
                <td><b>${escapeHtml(customerName)}</b></td>
                <td>${waktu}</td>
                <td>${escapeHtml(menuName)}</td>
                <td>${trx.quantity ?? 1}x</td>
                <td><b>${fmtRp(trx.total_price)}</b></td>
                <td><button type="button" class="btn-orange btn-sm" onclick="viewReceiptFromHistory(${idx})">Lihat Struk</button></td>
            </tr>
        `;
    }).join('');

    updateKpiStats();
}

function viewReceiptFromHistory(index) {
    const trx = transactionsCache[index];
    if (!trx) return;
    const menu = trx.menu || {};
    const menuName = menu.name ?? menu.nama_menu ?? ('Menu #' + trx.menu_id);
    const unitPrice = menu.price ?? menu.harga ?? (trx.quantity ? Math.round(trx.total_price / trx.quantity) : 0);
    const waktu = trx.created_at ? new Date(trx.created_at).toLocaleString('id-ID') : new Date().toLocaleString('id-ID');
    const customerName = trx.user?.name ?? trx.customer_name ?? 'Pelanggan';

    document.getElementById('receiptBox').innerHTML = `
        <div style="text-align:center; margin-bottom:12px;">
            <div style="font-weight:800; font-size:16px; color:var(--green-dark);">BUKTI TRANSAKSI APB WARTEG</div>
            <div class="sub">ID Transaksi: #${trx.id ?? (index + 1)}</div>
        </div>
        <div class="struk-line"><span>Pelanggan</span><span><b>${escapeHtml(customerName)}</b></span></div>
        <div class="struk-line"><span>Waktu</span><span>${waktu}</span></div>
        <div class="struk-line"><span>Menu</span><span>${escapeHtml(menuName)}</span></div>
        <div class="struk-line"><span>Harga Satuan</span><span>${fmtRp(unitPrice)}</span></div>
        <div class="struk-line"><span>Jumlah</span><span>${trx.quantity ?? 1}x</span></div>
        <div class="struk-total"><span>TOTAL BAYAR</span><span>${fmtRp(trx.total_price)}</span></div>
    `;

    const card = document.getElementById('receiptCard');
    card.style.display = 'block';
    card.scrollIntoView({ behavior: 'smooth' });
}

function getMenuImage(menu) {
    if (menu.image_url) return menu.image_url;
    if (menu.image) {
        const base = menu.image.startsWith('http') ? menu.image : `/storage/${menu.image}`;
        return `${base}?v=${Date.now()}`;
    }

    const label = getMenuDisplayName(menu).slice(0, 18);
    const svg = `
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="220" viewBox="0 0 400 220">
            <defs>
                <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#153b2c"/>
                    <stop offset="100%" stop-color="#235641"/>
                </linearGradient>
            </defs>
            <rect width="400" height="220" fill="url(#bg)"/>
            <circle cx="340" cy="36" r="60" fill="#e86a17" fill-opacity="0.3"/>
            <rect x="24" y="156" width="84" height="24" rx="6" fill="#e86a17"/>
            <text x="66" y="172" text-anchor="middle" fill="#ffffff" font-family="Arial, sans-serif" font-size="11" font-weight="bold">WARTEG</text>
            <text x="24" y="112" fill="#fffdf9" font-family="Arial, sans-serif" font-size="22" font-weight="bold">${escapeHtml(label)}</text>
        </svg>
    `.trim();

    return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
}

function formatErrorMessage(res, data, fallback) {
    if (data?.errors) {
        const firstKey = Object.keys(data.errors)[0];
        if (firstKey && data.errors[firstKey]?.[0]) return data.errors[firstKey][0];
    }
    return data?.message || fallback;
}

async function loadMenus() {
    try {
        const res = await fetch('/menus', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        menusCache = json.data || [];
    } catch {
        menusCache = [];
    }

    const listEl = document.getElementById('menuList');
    const bahanMenuSelect = document.getElementById('bahanMenuSelect');
    const filterMenuBahan = document.getElementById('filterMenuBahan');
    const adminSelectEl = document.getElementById('adminMenuSelect');

    const prevBahanMenu = bahanMenuSelect?.value;
    const prevFilterMenu = filterMenuBahan?.value;
    const prevAdminVal = adminSelectEl?.value;

    if (bahanMenuSelect) bahanMenuSelect.innerHTML = '<option value="umum">Umum / Semua Menu</option>';
    if (filterMenuBahan) filterMenuBahan.innerHTML = '<option value="ALL">Semua Menu</option><option value="umum">Umum / Semua Menu</option>';
    if (adminSelectEl) adminSelectEl.innerHTML = '';

    if (!menusCache.length) {
        listEl.innerHTML = '<div class="sub">Data menu kosong.</div>';
        syncAdminPreview();
        return;
    }

    listEl.innerHTML = menusCache.map(m => {
        const nama = getMenuDisplayName(m);
        const harga = m.price ?? m.harga ?? 0;
        const ingCount = ingredientsCache.filter(i => String(i.menu_key) === String(m.id)).length;
        return `
            <div class="menu-item" id="card-${m.id}" onclick="selectMenu(${m.id})">
                <img class="menu-thumb" src="${getMenuImage(m)}" alt="${escapeHtml(nama)}">
                <div class="menu-body">
                    <div>
                        <span class="menu-tag">${ingCount} bahan</span>
                        <div style="font-weight:700; color:var(--green-dark); margin-top:6px;">${escapeHtml(nama)}</div>
                        <div class="stock">Stok porsi: ${m.stock ?? 0}</div>
                    </div>
                    <div class="price">${fmtRp(harga)}</div>
                </div>
            </div>
        `;
    }).join('');

    menusCache.forEach(m => {
        const nama = getMenuDisplayName(m);
        if (bahanMenuSelect) {
            const opt1 = document.createElement('option');
            opt1.value = m.id; opt1.textContent = nama;
            bahanMenuSelect.appendChild(opt1);
        }
        if (filterMenuBahan) {
            const opt2 = document.createElement('option');
            opt2.value = m.id; opt2.textContent = nama;
            filterMenuBahan.appendChild(opt2);
        }
        if (adminSelectEl) {
            const adminOpt = document.createElement('option');
            adminOpt.value = m.id; adminOpt.textContent = `#${m.id} - ${nama}`;
            adminSelectEl.appendChild(adminOpt);
        }
    });

    if (bahanMenuSelect && prevBahanMenu) bahanMenuSelect.value = prevBahanMenu;
    if (filterMenuBahan && prevFilterMenu) filterMenuBahan.value = prevFilterMenu;
    if (adminSelectEl && prevAdminVal) adminSelectEl.value = prevAdminVal;

    syncAdminPreview();
    renderIngredients();
}

function selectMenu(id) {
    const bahanMenuSelect = document.getElementById('bahanMenuSelect');
    if (bahanMenuSelect) bahanMenuSelect.value = id;
    const adminSelectEl = document.getElementById('adminMenuSelect');
    if (adminSelectEl) {
        adminSelectEl.value = id;
        syncAdminPreview();
    }
    document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'));
    document.getElementById('card-' + id)?.classList.add('active');
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

    metaEl.textContent = `${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
    tempPreviewUrl = URL.createObjectURL(file);
    syncAdminPreview(true);
}

function clearAdminFile() {
    document.getElementById('adminImageInput').value = '';
    handleAdminFileChange();
}

function syncAdminPreview(isNewFile = false) {
    const adminSelectEl = document.getElementById('adminMenuSelect');
    const previewImg = document.getElementById('adminPreviewImg');
    const previewLabel = document.getElementById('adminPreviewLabel');
    const previewSub = document.getElementById('adminPreviewSub');

    if (!adminSelectEl || !previewImg) return;
    const menu = menusCache.find(item => String(item.id) === String(adminSelectEl.value));
    const menuName = menu ? getMenuDisplayName(menu) : 'Menu';

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
        dropzone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropzone.classList.add('dragover'); });
    });
    ['dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); dropzone.classList.remove('dragover'); });
    });
    dropzone.addEventListener('drop', (e) => {
        const files = e.dataTransfer?.files;
        if (files && files.length) {
            document.getElementById('adminImageInput').files = files;
            handleAdminFileChange();
        }
    });
}

async function uploadMenuImage() {
    const menuId = document.getElementById('adminMenuSelect').value;
    const fileInput = document.getElementById('adminImageInput');
    if (!fileInput.files.length) return showAlert('adminMsg', 'err', 'Pilih atau drop file gambar dulu.');

    const formData = new FormData();
    formData.append('image', fileInput.files[0]);

    const res = await fetch(`/menus/${menuId}`, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
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

loadRecipeRules();
loadLocalIngredients();
loadLocalTransactions();
updateEstimatedPortions();
checkMe().then((ok) => {
    if (!ok) return;
    loadMenus();
    refreshTransactionsView();
});
</script>
</body>
</html>