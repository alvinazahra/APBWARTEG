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

        .nasi-bar {
            background: var(--cream-hover);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .idea-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(275px, 1fr)); gap: 14px; margin-top: 12px; }
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

        .dish-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            background: var(--cream-hover);
            border: 1px solid #e6dac3;
            border-radius: 9px;
            padding: 6px 8px;
        }
        .dish-chip {
            background: var(--orange-soft);
            color: var(--orange-hover);
            border: 1px solid #f0be99;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            text-align: left;
            flex: 1;
        }
        .dish-chip.drink-chip {
            background: #eaf3ee;
            color: var(--green-dark);
            border-color: #b7d2c3;
        }
        .nasi-mini-btn {
            background: var(--green-dark);
            color: #fffdf9;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 7px;
            white-space: nowrap;
        }
        .nasi-mini-btn:hover { background: var(--green-deep); }

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
                        <span>Stok Bahan</span>
                        <span>›</span>
                    </button>
                    <button type="button" class="side-btn" id="sideBtn-olahan" onclick="switchSection('olahan')">
                        <span>Ide Olahan</span>
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
                    <span class="ribbon-group-title">Halaman:</span>
                    <span class="badge-orange" id="ribbonActiveTitle">Stok Bahan</span>
                </div>
                <div class="ribbon-group">
                    <span class="ribbon-group-title">Aksi:</span>
                    <button type="button" class="btn-soft btn-sm" onclick="loadMenus()">Refresh Menu</button>
                    <button type="button" class="btn-soft btn-sm" onclick="switchSection('olahan')">Ide Olahan</button>
                    <button type="button" class="btn-soft btn-sm" onclick="refreshTransactionsView()">Refresh Transaksi</button>
                </div>
            </div>
            <div class="sub" id="ribbonHint">Stok bahan</div>
        </header>

        <main class="content-wrap">
            <!-- 1. STOK BAHAN PERMENU -->
            <section class="card section-box active no-print" id="sec-bahan">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Stok Bahan</h2>
                        <div class="sub">Makanan & minuman per menu.</div>
                    </div>
                    <span class="badge-orange">STOK BAHAN</span>
                </div>

                <div class="grid-2-kpi" style="margin-bottom:16px;">
                    <div class="kpi-box">
                        <div class="kpi-label">Item Bahan</div>
                        <div class="kpi-val" id="kpiBahanTotal">0</div>
                        <div class="kpi-sub">Tercatat</div>
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
                            <span id="editingBadge" style="display:none; font-size:11px; font-weight:700; color:var(--orange);">EDIT</span>
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
                                    <label style="margin:0;">Menu</label>
                                    <button type="button" class="btn-soft btn-sm" style="padding:2px 6px; font-size:10px;" onclick="loadMenus()">Ambil</button>
                                </div>
                                <select id="bahanMenuSelect" onchange="renderIngredients()" style="margin-top:0;">
                                    <option value="umum">Umum / Semua Menu</option>
                                </select>
                            </div>
                        </div>

                        <label>Nama Bahan</label>
                        <input type="text" id="bahanNama" placeholder="Telur, Tempe, Ayam, Teh">

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
                            ±5 porsi
                        </div>

                        <label>Catatan</label>
                        <input type="text" id="bahanCatatan" placeholder="Opsional">

                        <div class="row">
                            <button type="button" class="btn-green" id="saveBahanBtn" onclick="saveIngredientStock()">Simpan</button>
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
                                    <option value="ALL">Semua Jenis</option>
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
                                        <th>Jenis & Menu</th>
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

            <!-- 2. IDE OLAHAN OTOMATIS -->
            <section class="card section-box no-print" id="sec-olahan">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Ide Olahan</h2>
                        <div class="sub">Lauk bebas tentukan harga; Nasi terpisah (+Rp5.000) dan bisa dipakai untuk olahan apa saja.</div>
                    </div>
                    <span class="badge-orange">AUTO OLAHAN</span>
                </div>

                <div class="nasi-bar">
                    <div>
                        <strong style="color:var(--green-dark); font-size:13.5px;">Item Terpisah: Nasi Putih (Rp5.000)</strong>
                        <div class="sub" style="font-size:12px;">Bisa dijadikan menu terpisah atau dipasangkan (+Rp5.000) ke lauk mana pun.</div>
                    </div>
                    <button type="button" class="btn-green btn-sm" onclick="addStandaloneRiceMenu()">+ Masukkan Nasi Putih (Rp5.000)</button>
                </div>

                <div class="form-panel" style="margin-bottom:16px;">
                    <h3 style="font-size:14px; color:var(--green-dark);">Aturan Olahan</h3>

                    <div class="form-row-2">
                        <div>
                            <label>Kata Kunci Bahan</label>
                            <input type="text" id="ruleKeyword" placeholder="telur / tempe / ayam / teh">
                        </div>
                        <div>
                            <label>Jenis</label>
                            <select id="ruleCategory">
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                            </select>
                        </div>
                    </div>

                    <label>Daftar Olahan (pisahkan dengan koma)</label>
                    <input type="text" id="ruleDishes" placeholder="Semur Telur, Telur Dadar, Telur Balado">

                    <div class="row">
                        <button type="button" class="btn-green" onclick="saveRecipeRule()">Simpan</button>
                        <button type="button" class="btn-soft" onclick="resetRecipeRulesToDefault()">Reset</button>
                        <button type="button" class="btn-orange" onclick="seedSampleIngredients(); renderRecipeSuggestions();">Isi Contoh Stok</button>
                        <button type="button" class="btn-soft" onclick="switchSection('bahan')">Ke Stok Bahan</button>
                    </div>
                    <div id="ruleMsg" class="alert"></div>
                </div>

                <h3 style="font-size:15px; color:var(--green-dark);">Hasil Olahan</h3>
                <div class="sub" style="font-size:12px; margin-top:2px;">Klik nama olahan untuk buat menu lauk saja (harga bebas), atau klik <strong>+ Nasi</strong> untuk lauk + nasi (+Rp5.000).</div>
                <div id="recipeSuggestionsGrid" class="idea-grid"></div>
            </section>

            <!-- 3. TRANSAKSI PELANGGAN -->
            <section class="card section-box no-print" id="sec-transaksi">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Transaksi Pelanggan</h2>
                        <div class="sub">Riwayat & struk.</div>
                    </div>
                    <span class="badge-orange">TRANSAKSI</span>
                </div>

                <div class="grid-4" style="margin-bottom:16px;">
                    <div class="kpi-box">
                        <div class="kpi-label">Transaksi</div>
                        <div class="kpi-val" id="kpiTrxCount">0</div>
                        <div class="kpi-sub">Tercatat</div>
                    </div>
                    <div class="kpi-box accent-orange">
                        <div class="kpi-label">Pendapatan</div>
                        <div class="kpi-val" id="kpiOmzet">Rp0</div>
                        <div class="kpi-sub">Total</div>
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
                            <tr><td colspan="7" class="sub">Belum ada transaksi.</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 4. GAMBAR MENU -->
            <section class="card section-box no-print" id="sec-gambar">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Gambar Menu</h2>
                        <div class="sub">Foto menu & kelola daftar menu.</div>
                    </div>
                    <span class="badge-orange">GAMBAR MENU</span>
                </div>

                <div class="grid-2">
                    <div>
                        <label>Menu</label>
                        <select id="adminMenuSelect" onchange="syncAdminPreview(); renderAdminMenusGrid();"></select>

                        <div class="preview-box">
                            <img id="adminPreviewImg" class="preview-img" src="" alt="Preview" onerror="this.src='https://placehold.co/300x180/ede3cf/153b2c?text=No+Image'">
                            <div>
                                <div id="adminPreviewLabel" style="font-size:12px; font-weight:700; color:var(--green-dark);">Preview</div>
                                <div id="adminPreviewSub" class="sub" style="font-size:11px; margin-top:2px;">-</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label>File Gambar</label>
                        <div class="dropzone" id="adminDropzone" onclick="document.getElementById('adminImageInput').click()">
                            <input type="file" id="adminImageInput" accept="image/png,image/jpeg,image/webp" onchange="handleAdminImageChange(event)">
                            <div class="dropzone-title">Klik atau seret gambar ke sini</div>
                            <div class="dropzone-sub">JPG, JPEG, PNG, WEBP (maks. 2MB)</div>
                            <div class="file-meta" id="adminFileMeta">Belum ada file dipilih</div>
                        </div>

                        <div class="row">
                            <button type="button" class="btn-orange" onclick="uploadMenuImage()">Simpan Gambar</button>
                            <button type="button" class="btn-soft" onclick="resetAdminImageForm()">Reset</button>
                            <button type="button" class="btn-soft" onclick="deleteMenu()">Hapus Menu</button>
                        </div>
                        <div id="gambarMsg" class="alert"></div>
                    </div>
                </div>

                <div style="margin-top:18px;">
                    <h3 style="font-size:15px; color:var(--green-dark);">Daftar Menu</h3>
                    <div class="menus" id="adminMenusGrid"></div>
                </div>
            </section>

            <!-- STRUK CETAK -->
            <section class="card" id="sec-struk" style="display:none;">
                <div class="sec-head">
                    <div>
                        <h2 class="sec-title">Struk Transaksi</h2>
                        <div class="sub">Bukti pembayaran pelanggan</div>
                    </div>
                    <button type="button" class="btn-green no-print" onclick="window.print()">Cetak</button>
                </div>
                <div class="struk" id="strukContent"></div>
            </section>
        </main>
    </div>
</div>

<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const STORAGE_BAHAN_KEY = 'apb_warteg_bahan_v1';
    const STORAGE_RULE_KEY = 'apb_warteg_rules_v1';
    const HARGA_NASI = 5000;

    const DEFAULT_RULES = [
        { keyword: 'telur', category: 'Makanan', dishes: ['Semur Telur', 'Telur Dadar', 'Telur Balado'] },
        { keyword: 'tempe', category: 'Makanan', dishes: ['Tempe Orek', 'Tempe Bacem', 'Tempe Mendoan'] },
        { keyword: 'ayam', category: 'Makanan', dishes: ['Ayam Goreng', 'Ayam Kecap', 'Opor Ayam'] },
        { keyword: 'teh', category: 'Minuman', dishes: ['Es Teh Manis', 'Teh Hangat Tawar'] }
    ];

    let menusCache = [];
    let categoriesCache = [];
    let transactionsCache = [];
    let selectedAdminFile = null;
    let editingIngredientId = null;

    const SECTION_META = {
        bahan: { title: 'Stok Bahan', hint: 'Stok bahan' },
        olahan: { title: 'Ide Olahan Otomatis', hint: 'Lauk bebas harga • Nasi terpisah +Rp5.000' },
        transaksi: { title: 'Transaksi Pelanggan', hint: 'Riwayat & struk' },
        gambar: { title: 'Gambar Menu', hint: 'Foto menu & hapus menu' }
    };

    document.addEventListener('DOMContentLoaded', async () => {
        initDropzone();
        updateEstimatedPortions();
        await checkAuthAndInit();
    });

    async function checkAuthAndInit() {
        try {
            const res = await fetch('/me', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) {
                window.location.href = '/admin/login';
                return;
            }
            const data = await res.json();
            const user = data.user || data.data || data;
            if (user?.role && user.role !== 'admin') {
                window.location.href = '/warteg';
                return;
            }
            document.getElementById('userStatus').textContent = user?.name || 'Admin Warteg';
            document.getElementById('mainShell').style.display = 'grid';

            await loadCategories();
            await loadMenus();
            renderIngredients();
            renderRecipeSuggestions();
            await refreshTransactionsView();
        } catch (e) {
            document.getElementById('mainShell').style.display = 'grid';
            renderIngredients();
            renderRecipeSuggestions();
        }
    }

    function switchSection(sec) {
        document.querySelectorAll('.section-box').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.side-btn').forEach(btn => btn.classList.remove('active'));

        const target = document.getElementById(`sec-${sec}`);
        const btn = document.getElementById(`sideBtn-${sec}`);
        if (target) target.classList.add('active');
        if (btn) btn.classList.add('active');

        const meta = SECTION_META[sec] || { title: 'Admin', hint: '' };
        document.getElementById('ribbonActiveTitle').textContent = meta.title;
        document.getElementById('ribbonHint').textContent = meta.hint;

        if (sec === 'olahan') renderRecipeSuggestions();
        if (sec === 'gambar') {
            renderAdminMenusGrid();
            syncAdminPreview();
        }
        if (sec === 'transaksi') refreshTransactionsView();
    }

    async function loadCategories() {
        try {
            const res = await fetch('/categories', { headers: { 'Accept': 'application/json' } });
            if (res.ok) {
                const json = await res.json();
                categoriesCache = Array.isArray(json) ? json : (json.data || []);
            }
        } catch (_) {
            categoriesCache = [];
        }
    }

    function resolveCategoryId(categoryName) {
        if (!categoriesCache.length) return 1;
        const found = categoriesCache.find(c =>
            String(c.name || '').toLowerCase().includes(String(categoryName || '').toLowerCase())
        );
        return found ? found.id : categoriesCache[0].id;
    }

    async function loadMenus() {
        try {
            const res = await fetch('/menus', { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            menusCache = Array.isArray(json) ? json : (json.data || json.menus || []);
            populateMenuSelects();
            renderAdminMenusGrid();
            syncAdminPreview();
        } catch (err) {
            showAlert('gambarMsg', 'Gagal memuat daftar menu.', 'err');
        }
    }

    function populateMenuSelects() {
        const adminSelect = document.getElementById('adminMenuSelect');
        const bahanSelect = document.getElementById('bahanMenuSelect');
        const filterSelect = document.getElementById('filterMenuBahan');

        const prevAdmin = adminSelect?.value;
        const prevBahan = bahanSelect?.value;
        const prevFilter = filterSelect?.value;

        if (adminSelect) {
            adminSelect.innerHTML = menusCache.length
                ? menusCache.map(m => `<option value="${m.id}">${m.name} (Stok: ${m.stock ?? 0})</option>`).join('')
                : `<option value="">Belum ada menu</option>`;
            if (prevAdmin && menusCache.some(m => String(m.id) === String(prevAdmin))) {
                adminSelect.value = prevAdmin;
            }
        }

        if (bahanSelect) {
            bahanSelect.innerHTML = `<option value="umum">Umum / Semua Menu</option>` +
                menusCache.map(m => `<option value="${m.name}">${m.name}</option>`).join('');
            if (prevBahan) bahanSelect.value = prevBahan;
        }

        if (filterSelect) {
            filterSelect.innerHTML = `<option value="ALL">Semua Menu</option><option value="umum">Umum</option>` +
                menusCache.map(m => `<option value="${m.name}">${m.name}</option>`).join('');
            if (prevFilter) filterSelect.value = prevFilter;
        }
    }

    function getIngredients() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_BAHAN_KEY) || '[]');
        } catch (_) {
            return [];
        }
    }

    function setIngredients(list) {
        localStorage.setItem(STORAGE_BAHAN_KEY, JSON.stringify(list));
    }

    function updateEstimatedPortions() {
        const qty = parseFloat(document.getElementById('bahanJumlah').value) || 0;
        const perPortion = parseFloat(document.getElementById('bahanTakaran').value) || 0;
        const est = perPortion > 0 ? Math.floor(qty / perPortion) : 0;
        document.getElementById('estimasiPorsiText').textContent = `±${est} porsi`;
    }

    function saveIngredientStock() {
        const name = document.getElementById('bahanNama').value.trim();
        const category = document.getElementById('bahanKategori').value;
        const menuName = document.getElementById('bahanMenuSelect').value;
        const qty = parseFloat(document.getElementById('bahanJumlah').value);
        const unit = document.getElementById('bahanSatuan').value;
        const perPortion = parseFloat(document.getElementById('bahanTakaran').value) || 1;
        const minStock = parseFloat(document.getElementById('bahanMinStok').value) || 0;
        const note = document.getElementById('bahanCatatan').value.trim();

        if (!name || isNaN(qty) || qty < 0) {
            return showAlert('bahanMsg', 'Nama bahan dan jumlah stok wajib diisi.', 'err');
        }

        const list = getIngredients();
        if (editingIngredientId) {
            const idx = list.findIndex(item => item.id === editingIngredientId);
            if (idx !== -1) {
                list[idx] = { ...list[idx], name, category, menuName, qty, unit, perPortion, minStock, note };
            }
        } else {
            list.unshift({
                id: 'bhn_' + Date.now(),
                name, category, menuName, qty, unit, perPortion, minStock, note
            });
        }

        setIngredients(list);
        resetIngredientForm();
        renderIngredients();
        renderRecipeSuggestions();
        showAlert('bahanMsg', 'Stok bahan tersimpan.', 'ok');
    }

    function editIngredient(id) {
        const item = getIngredients().find(i => i.id === id);
        if (!item) return;
        editingIngredientId = item.id;
        document.getElementById('bahanFormTitle').textContent = 'Edit Bahan';
        document.getElementById('editingBadge').style.display = 'inline';
        document.getElementById('bahanKategori').value = item.category || 'Makanan';
        document.getElementById('bahanMenuSelect').value = item.menuName || 'umum';
        document.getElementById('bahanNama').value = item.name;
        document.getElementById('bahanJumlah').value = item.qty;
        document.getElementById('bahanSatuan').value = item.unit || 'porsi';
        document.getElementById('bahanTakaran').value = item.perPortion || 1;
        document.getElementById('bahanMinStok').value = item.minStock ?? 2;
        document.getElementById('bahanCatatan').value = item.note || '';
        updateEstimatedPortions();
    }

    function adjustIngredientQty(id, delta) {
        const list = getIngredients();
        const item = list.find(i => i.id === id);
        if (!item) return;
        item.qty = Math.max(0, Number(((parseFloat(item.qty) || 0) + delta).toFixed(2)));
        setIngredients(list);
        renderIngredients();
        renderRecipeSuggestions();
    }

    function deleteIngredient(id) {
        const list = getIngredients().filter(i => i.id !== id);
        setIngredients(list);
        if (editingIngredientId === id) resetIngredientForm();
        renderIngredients();
        renderRecipeSuggestions();
    }

    function resetIngredientForm() {
        editingIngredientId = null;
        document.getElementById('bahanFormTitle').textContent = 'Tambah / Edit Bahan';
        document.getElementById('editingBadge').style.display = 'none';
        document.getElementById('bahanNama').value = '';
        document.getElementById('bahanJumlah').value = 5;
        document.getElementById('bahanTakaran').value = 1;
        document.getElementById('bahanMinStok').value = 2;
        document.getElementById('bahanCatatan').value = '';
        updateEstimatedPortions();
    }

    function seedSampleIngredients() {
        const samples = [
            { id: 'bhn_telur', name: 'Telur Ayam', category: 'Makanan', menuName: 'umum', qty: 24, unit: 'butir', perPortion: 1, minStock: 6, note: 'Segar' },
            { id: 'bhn_tempe', name: 'Tempe Papan', category: 'Makanan', menuName: 'umum', qty: 8, unit: 'papan', perPortion: 0.5, minStock: 3, note: '' },
            { id: 'bhn_ayam', name: 'Ayam Potong', category: 'Makanan', menuName: 'umum', qty: 10, unit: 'porsi', perPortion: 1, minStock: 3, note: '' },
            { id: 'bhn_teh', name: 'Teh Celup & Gula', category: 'Minuman', menuName: 'umum', qty: 30, unit: 'porsi', perPortion: 1, minStock: 8, note: '' }
        ];
        setIngredients(samples);
        renderIngredients();
        renderRecipeSuggestions();
        showAlert('bahanMsg', 'Contoh stok bahan dimuat.', 'ok');
    }

    function renderIngredients() {
        const all = getIngredients();
        const q = (document.getElementById('searchBahanInput')?.value || '').toLowerCase().trim();
        const kat = document.getElementById('filterKategoriBahan')?.value || 'ALL';
        const menuFilter = document.getElementById('filterMenuBahan')?.value || 'ALL';

        const lowCount = all.filter(i => Number(i.qty) <= Number(i.minStock ?? 0)).length;
        document.getElementById('kpiBahanTotal').textContent = all.length;
        document.getElementById('kpiBahanLow').textContent = lowCount;

        const filtered = all.filter(item => {
            const matchQ = !q || String(item.name).toLowerCase().includes(q) || String(item.note || '').toLowerCase().includes(q);
            const matchKat = kat === 'ALL' || item.category === kat;
            const matchMenu = menuFilter === 'ALL' || item.menuName === menuFilter;
            return matchQ && matchKat && matchMenu;
        });

        const tbody = document.getElementById('ingredientTableBody');
        if (!filtered.length) {
            tbody.innerHTML = `<tr><td colspan="5" class="sub">Belum ada data bahan.</td></tr>`;
            return;
        }

        tbody.innerHTML = filtered.map(item => {
            const isLow = Number(item.qty) <= Number(item.minStock ?? 0);
            const est = item.perPortion > 0 ? Math.floor(Number(item.qty) / Number(item.perPortion)) : 0;
            return `
                <tr>
                    <td>
                        <span class="cat-pill">${item.category}</span><br>
                        <span class="menu-pill" style="margin-top:4px;">${item.menuName === 'umum' ? 'Umum' : item.menuName}</span>
                    </td>
                    <td>
                        <strong>${item.name}</strong>
                        ${item.note ? `<div class="sub" style="font-size:11px;">${item.note}</div>` : ''}
                    </td>
                    <td>
                        <strong>${item.qty} ${item.unit}</strong>
                        <div class="sub" style="font-size:11px;">±${est} porsi</div>
                    </td>
                    <td>
                        <span class="${isLow ? 'badge-low' : 'badge-safe'}">${isLow ? 'Menipis' : 'Aman'}</span>
                    </td>
                    <td>
                        <div style="display:flex; gap:4px; flex-wrap:wrap;">
                            <button type="button" class="btn-soft btn-sm" onclick="adjustIngredientQty('${item.id}', 1)">+1</button>
                            <button type="button" class="btn-soft btn-sm" onclick="adjustIngredientQty('${item.id}', -1)">-1</button>
                            <button type="button" class="btn-soft btn-sm" onclick="editIngredient('${item.id}')">Edit</button>
                            <button type="button" class="btn-soft btn-sm" onclick="deleteIngredient('${item.id}')">Hapus</button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function getRecipeRules() {
        try {
            const saved = JSON.parse(localStorage.getItem(STORAGE_RULE_KEY) || 'null');
            return Array.isArray(saved) && saved.length ? saved : DEFAULT_RULES;
        } catch (_) {
            return DEFAULT_RULES;
        }
    }

    function setRecipeRules(rules) {
        localStorage.setItem(STORAGE_RULE_KEY, JSON.stringify(rules));
    }

    function saveRecipeRule() {
        const keyword = document.getElementById('ruleKeyword').value.trim().toLowerCase();
        const category = document.getElementById('ruleCategory').value;
        const dishesRaw = document.getElementById('ruleDishes').value.trim();

        if (!keyword || !dishesRaw) {
            return showAlert('ruleMsg', 'Kata kunci bahan dan daftar olahan wajib diisi.', 'err');
        }

        const dishes = dishesRaw.split(',').map(s => s.trim()).filter(Boolean);
        if (!dishes.length) {
            return showAlert('ruleMsg', 'Minimal satu nama olahan.', 'err');
        }

        const rules = getRecipeRules();
        const existingIdx = rules.findIndex(r => r.keyword.toLowerCase() === keyword);
        if (existingIdx !== -1) {
            rules[existingIdx] = { keyword, category, dishes };
        } else {
            rules.push({ keyword, category, dishes });
        }

        setRecipeRules(rules);
        document.getElementById('ruleKeyword').value = '';
        document.getElementById('ruleDishes').value = '';
        renderRecipeSuggestions();
        showAlert('ruleMsg', 'Aturan olahan disimpan.', 'ok');
    }

    function resetRecipeRulesToDefault() {
        setRecipeRules(DEFAULT_RULES);
        renderRecipeSuggestions();
        showAlert('ruleMsg', 'Aturan dikembalikan ke bawaan.', 'ok');
    }

    function renderRecipeSuggestions() {
        const grid = document.getElementById('recipeSuggestionsGrid');
        if (!grid) return;

        const activeIngredients = getIngredients().filter(i => Number(i.qty) > 0);
        const rules = getRecipeRules();

        if (!activeIngredients.length) {
            grid.innerHTML = `<div class="sub">Stok bahan kosong. Isi stok bahan agar ide olahan muncul.</div>`;
            return;
        }

        const suggestions = [];
        activeIngredients.forEach(ing => {
            const ingNameLower = String(ing.name || '').toLowerCase();
            const matchedRules = rules.filter(r => ingNameLower.includes(String(r.keyword || '').toLowerCase()));
            const estPortions = ing.perPortion > 0 ? Math.max(1, Math.floor(Number(ing.qty) / Number(ing.perPortion))) : 1;

            matchedRules.forEach(rule => {
                suggestions.push({
                    ingredient: ing,
                    category: rule.category || ing.category || 'Makanan',
                    dishes: rule.dishes,
                    portions: estPortions
                });
            });
        });

        if (!suggestions.length) {
            grid.innerHTML = `<div class="sub">Belum ada aturan olahan yang cocok dengan bahan aktif.</div>`;
            return;
        }

        grid.innerHTML = suggestions.map(s => {
            const isDrink = s.category === 'Minuman';
            return `
                <div class="idea-card ${isDrink ? 'drink' : ''}">
                    <div class="idea-head">
                        <div>
                            <div class="idea-bahan">${s.ingredient.name}</div>
                            <div class="sub" style="font-size:11px;">Stok: ${s.ingredient.qty} ${s.ingredient.unit} (±${s.portions} porsi)</div>
                        </div>
                        <span class="cat-pill">${s.category}</span>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        ${s.dishes.map(dish => `
                            <div class="dish-row">
                                <button type="button" class="dish-chip ${isDrink ? 'drink-chip' : ''}"
                                    title="Buat menu lauk (harga bebas)"
                                    onclick="promoteDishToMenu('${escapeJs(dish)}', '${escapeJs(s.category)}', ${s.portions}, '${escapeJs(s.ingredient.name)}', false)">
                                    + ${dish}
                                </button>
                                ${!isDrink ? `
                                    <button type="button" class="nasi-mini-btn"
                                        title="Buat menu lauk + Nasi (+Rp5.000)"
                                        onclick="promoteDishToMenu('${escapeJs(dish)}', '${escapeJs(s.category)}', ${s.portions}, '${escapeJs(s.ingredient.name)}', true)">
                                        + Nasi
                                    </button>
                                ` : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }).join('');
    }

    async function ensureRiceMenuExists() {
        const existingRice = menusCache.find(m => String(m.name || '').toLowerCase() === 'nasi putih');
        if (existingRice) return existingRice;

        const categoryId = resolveCategoryId('Makanan');
        const res = await fetch('/menus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({
                category_id: categoryId,
                name: 'Nasi Putih',
                price: HARGA_NASI,
                stock: 50,
                description: 'Nasi putih hangat terpisah (+Rp5.000)'
            })
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'Gagal membuat menu Nasi Putih.');
        return json.data || json;
    }

    async function addStandaloneRiceMenu() {
        try {
            const rice = await ensureRiceMenuExists();
            await loadMenus();
            switchSection('gambar');
            if (rice?.id) {
                document.getElementById('adminMenuSelect').value = rice.id;
                syncAdminPreview();
                renderAdminMenusGrid();
            }
            showAlert('gambarMsg', `Menu "Nasi Putih" (Rp${HARGA_NASI.toLocaleString('id-ID')}) siap diatur gambarnya.`, 'ok');
        } catch (err) {
            showAlert('ruleMsg', err.message || 'Gagal menambahkan Nasi Putih.', 'err');
        }
    }

    async function promoteDishToMenu(dishName, categoryName, estimatedStock, ingredientName, withRice = false) {
        const laukInput = prompt(
            withRice
                ? `Harga lauk "${dishName}" saja (Rp) — otomatis ditambah Nasi Rp${HARGA_NASI.toLocaleString('id-ID')}:`
                : `Harga lauk "${dishName}" saja (Rp) — bebas sesuai keinginan:`,
            categoryName === 'Minuman' ? '5000' : '7000'
        );
        if (laukInput === null) return;

        const hargaLauk = Math.max(0, parseFloat(laukInput) || 0);
        const finalPrice = withRice ? (hargaLauk + HARGA_NASI) : hargaLauk;
        const finalName = withRice ? `${dishName} + Nasi` : dishName;
        const descText = withRice
            ? `Lauk Rp${hargaLauk.toLocaleString('id-ID')} + Nasi Rp${HARGA_NASI.toLocaleString('id-ID')} • Bahan: ${ingredientName}`
            : `Lauk saja Rp${hargaLauk.toLocaleString('id-ID')} • Bahan: ${ingredientName}`;

        const existing = menusCache.find(m => String(m.name || '').toLowerCase() === finalName.toLowerCase());
        if (existing) {
            switchSection('gambar');
            document.getElementById('adminMenuSelect').value = existing.id;
            syncAdminPreview();
            renderAdminMenusGrid();
            showAlert('gambarMsg', `"${existing.name}" sudah ada di menu. Silakan pilih gambar.`, 'ok');
            return;
        }

        const stock = Math.max(1, parseInt(estimatedStock, 10) || 1);
        const categoryId = resolveCategoryId(categoryName);

        try {
            if (withRice) {
                await ensureRiceMenuExists();
            }

            const res = await fetch('/menus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    category_id: categoryId,
                    name: finalName,
                    price: finalPrice,
                    stock: stock,
                    description: descText
                })
            });

            const json = await res.json();
            if (!res.ok) {
                return showAlert('ruleMsg', json.message || 'Gagal menambahkan menu baru.', 'err');
            }

            const created = json.data || json;
            await loadMenus();
            switchSection('gambar');
            if (created?.id) {
                document.getElementById('adminMenuSelect').value = created.id;
                syncAdminPreview();
                renderAdminMenusGrid();
            }
            showAlert('gambarMsg', `Menu "${finalName}" (Rp${finalPrice.toLocaleString('id-ID')}) berhasil dibuat. Silakan unggah gambarnya.`, 'ok');
        } catch (err) {
            showAlert('ruleMsg', err.message || 'Terjadi kesalahan saat mengirim menu ke server.', 'err');
        }
    }

    async function deleteMenu() {
        const sel = document.getElementById('adminMenuSelect');
        const menuId = sel?.value;
        if (!menuId) {
            return showAlert('gambarMsg', 'Pilih menu yang ingin dihapus terlebih dahulu.', 'err');
        }

        const menu = menusCache.find(m => String(m.id) === String(menuId));
        const namaMenu = menu?.name || `ID #${menuId}`;
        if (!confirm(`Hapus menu "${namaMenu}" beserta gambarnya?`)) {
            return;
        }

        try {
            const res = await fetch(`/menus/${menuId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            const json = await res.json();
            if (!res.ok) {
                return showAlert('gambarMsg', json.message || 'Gagal menghapus menu.', 'err');
            }
            resetAdminImageForm();
            await loadMenus();
            showAlert('gambarMsg', `Menu "${namaMenu}" berhasil dihapus.`, 'ok');
        } catch (err) {
            showAlert('gambarMsg', 'Terjadi kesalahan saat menghapus menu.', 'err');
        }
    }

    function renderAdminMenusGrid() {
        const grid = document.getElementById('adminMenusGrid');
        if (!grid) return;

        if (!menusCache.length) {
            grid.innerHTML = `<div class="sub">Menu kosong.</div>`;
            return;
        }

        const selectedId = document.getElementById('adminMenuSelect')?.value;
        grid.innerHTML = menusCache.map(m => {
            const imgSrc = m.image ? `/storage/${m.image}` : 'https://placehold.co/300x180/ede3cf/153b2c?text=No+Image';
            const isActive = String(m.id) === String(selectedId);
            return `
                <div class="menu-item ${isActive ? 'active' : ''}" onclick="selectMenuForImage(${m.id})">
                    <img class="menu-thumb" src="${imgSrc}" alt="${m.name}" onerror="this.src='https://placehold.co/300x180/ede3cf/153b2c?text=No+Image'">
                    <div class="menu-body">
                        <div>
                            <div style="font-weight:700; font-size:13.5px; color:var(--green-dark);">${m.name}</div>
                            <div class="stock">Stok: ${m.stock ?? 0}</div>
                            ${m.description ? `<div class="sub" style="font-size:11px; margin-top:2px;">${m.description}</div>` : ''}
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:6px;">
                            <span class="price">Rp${Number(m.price || 0).toLocaleString('id-ID')}</span>
                            <span class="menu-tag">${m.category?.name || 'Menu'}</span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function selectMenuForImage(id) {
        const sel = document.getElementById('adminMenuSelect');
        if (sel) {
            sel.value = id;
            syncAdminPreview();
            renderAdminMenusGrid();
        }
    }

    function syncAdminPreview() {
        const sel = document.getElementById('adminMenuSelect');
        const imgEl = document.getElementById('adminPreviewImg');
        const labelEl = document.getElementById('adminPreviewLabel');
        const subEl = document.getElementById('adminPreviewSub');
        if (!sel || !imgEl) return;

        const menu = menusCache.find(m => String(m.id) === String(sel.value));
        if (!menu) {
            imgEl.src = 'https://placehold.co/300x180/ede3cf/153b2c?text=Pilih+Menu';
            labelEl.textContent = 'Preview';
            subEl.textContent = '-';
            return;
        }

        labelEl.textContent = menu.name;
        subEl.textContent = `Rp${Number(menu.price || 0).toLocaleString('id-ID')} • Stok ${menu.stock ?? 0}`;

        if (!selectedAdminFile) {
            imgEl.src = menu.image ? `/storage/${menu.image}` : 'https://placehold.co/300x180/ede3cf/153b2c?text=No+Image';
        }
    }

    function initDropzone() {
        const dz = document.getElementById('adminDropzone');
        if (!dz) return;
        ['dragenter', 'dragover'].forEach(ev => {
            dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('dragover'); });
        });
        ['dragleave', 'drop'].forEach(ev => {
            dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('dragover'); });
        });
        dz.addEventListener('drop', e => {
            const file = e.dataTransfer?.files?.[0];
            if (file) applySelectedImage(file);
        });
    }

    function handleAdminImageChange(event) {
        const file = event.target?.files?.[0];
        if (file) applySelectedImage(file);
    }

    function applySelectedImage(file) {
        selectedAdminFile = file;
        document.getElementById('adminFileMeta').textContent = `${file.name} (${Math.round(file.size / 1024)} KB)`;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('adminPreviewImg').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function resetAdminImageForm() {
        selectedAdminFile = null;
        const input = document.getElementById('adminImageInput');
        if (input) input.value = '';
        document.getElementById('adminFileMeta').textContent = 'Belum ada file dipilih';
        syncAdminPreview();
    }

    async function uploadMenuImage() {
        const menuId = document.getElementById('adminMenuSelect').value;
        if (!menuId) return showAlert('gambarMsg', 'Pilih menu terlebih dahulu.', 'err');
        if (!selectedAdminFile) return showAlert('gambarMsg', 'Pilih file gambar terlebih dahulu.', 'err');

        const formData = new FormData();
        formData.append('image', selectedAdminFile);

        try {
            const res = await fetch(`/menus/${menuId}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: formData
            });
            const json = await res.json();
            if (!res.ok) {
                return showAlert('gambarMsg', json.message || 'Gagal mengunggah gambar.', 'err');
            }
            resetAdminImageForm();
            await loadMenus();
            showAlert('gambarMsg', 'Gambar menu berhasil disimpan.', 'ok');
        } catch (err) {
            showAlert('gambarMsg', 'Terjadi kesalahan saat mengunggah gambar.', 'err');
        }
    }

    async function refreshTransactionsView() {
        try {
            const res = await fetch('/transactions', { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const json = await res.json();
            transactionsCache = Array.isArray(json) ? json : (json.data || []);
            renderTransactionsHistory();
        } catch (_) {}
    }

    function renderTransactionsHistory() {
        const q = (document.getElementById('searchTrxInput')?.value || '').toLowerCase().trim();
        const tbody = document.getElementById('trxHistoryBody');
        if (!tbody) return;

        const filtered = transactionsCache.filter(t => {
            if (!q) return true;
            return String(t.id || '').toLowerCase().includes(q) ||
                String(t.customer_name || '').toLowerCase().includes(q) ||
                String(t.menu?.name || '').toLowerCase().includes(q);
        });

        const totalOmzet = filtered.reduce((acc, t) => acc + Number(t.total_price || t.total || 0), 0);
        document.getElementById('kpiTrxCount').textContent = filtered.length;
        document.getElementById('kpiOmzet').textContent = `Rp${totalOmzet.toLocaleString('id-ID')}`;

        if (!filtered.length) {
            tbody.innerHTML = `<tr><td colspan="7" class="sub">Belum ada transaksi.</td></tr>`;
            return;
        }

        tbody.innerHTML = filtered.map(t => `
            <tr>
                <td>#${t.id}</td>
                <td>${t.customer_name || '-'}</td>
                <td>${t.created_at || '-'}</td>
                <td>${t.menu?.name || '-'}</td>
                <td>${t.quantity ?? 1}</td>
                <td>Rp${Number(t.total_price || t.total || 0).toLocaleString('id-ID')}</td>
                <td><button type="button" class="btn-soft btn-sm" onclick="openStruk(${t.id})">Struk</button></td>
            </tr>
        `).join('');
    }

    function openStruk(id) {
        const trx = transactionsCache.find(t => String(t.id) === String(id));
        if (!trx) return;
        const total = Number(trx.total_price || trx.total || 0);
        document.getElementById('strukContent').innerHTML = `
            <div class="struk-line"><span>ID Transaksi</span><strong>#${trx.id}</strong></div>
            <div class="struk-line"><span>Pelanggan</span><span>${trx.customer_name || '-'}</span></div>
            <div class="struk-line"><span>Menu</span><span>${trx.menu?.name || '-'}</span></div>
            <div class="struk-line"><span>Jumlah</span><span>${trx.quantity ?? 1}</span></div>
            <div class="struk-total"><span>Total</span><span>Rp${total.toLocaleString('id-ID')}</span></div>
        `;
        document.getElementById('sec-struk').style.display = 'block';
        window.print();
    }

    async function logoutUser() {
        try {
            await fetch('/logout', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            });
        } finally {
            window.location.href = '/admin/login';
        }
    }

    function showAlert(elId, msg, type) {
        const el = document.getElementById(elId);
        if (!el) return;
        el.textContent = msg;
        el.className = `alert ${type}`;
    }

    function escapeJs(str) {
        return String(str || '').replace(/\\/g, '\\\\').replace(/'/g, "\\'");
    }
</script>
</body>
</html>