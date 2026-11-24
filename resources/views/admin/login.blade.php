<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin — APB Warteg</title>
    <style>
        :root {
            --cream-bg: #f5efe3;
            --cream-card: #fffdf9;
            --cream-soft: #efe6d4;
            --green-dark: #153b2c;
            --green-deep: #0d281d;
            --orange: #e86a17;
            --orange-hover: #c9550a;
            --text-main: #18221d;
            --text-muted: #5c6862;
            --border: #dfd3bd;
            --ok-bg: #e2f5ea;
            --ok-text: #145c36;
            --err-bg: #fde8e4;
            --err-text: #9b2c1d;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; }
        body {
            min-height: 100vh;
            background: var(--cream-bg);
            color: var(--text-main);
            display: grid;
            place-items: center;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--cream-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 26px;
            box-shadow: 0 8px 24px rgba(21, 59, 44, 0.08);
        }
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
        .brand-box {
            width: 44px; height: 44px; border-radius: 12px;
            background: var(--green-dark); color: #fffdf9;
            border: 2px solid var(--orange);
            display: grid; place-items: center; font-weight: 800; font-size: 16px;
        }
        .title { font-size: 19px; font-weight: 800; color: var(--green-dark); }
        .sub { font-size: 13px; color: var(--text-muted); margin-top: 2px; }
        label { display: block; font-size: 12px; font-weight: 700; color: var(--green-dark); margin-top: 12px; margin-bottom: 6px; }
        input {
            width: 100%; padding: 10px 12px; border-radius: 10px;
            border: 1px solid #c9bba1; background: #fff; color: var(--text-main); font-size: 13px;
        }
        input:focus { outline: none; border-color: var(--green-dark); box-shadow: 0 0 0 3px rgba(21, 59, 44, 0.12); }
        button {
            cursor: pointer; border: none; border-radius: 10px;
            padding: 10px 14px; font-weight: 700; font-size: 13px;
        }
        .btn-orange { width: 100%; margin-top: 16px; background: var(--orange); color: #fff; }
        .btn-orange:hover { background: var(--orange-hover); }
        .btn-soft { background: var(--cream-soft); color: var(--green-dark); border: 1px solid #d4c5aa; }
        .alert { padding: 10px 12px; border-radius: 10px; font-size: 13px; margin-top: 12px; display: none; }
        .alert.ok { display: block; background: var(--ok-bg); border: 1px solid #9fd4b5; color: var(--ok-text); }
        .alert.err { display: block; background: var(--err-bg); border: 1px solid #f3b5a8; color: var(--err-text); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <div class="brand-box">AW</div>
            <div>
                <div class="title">Login Admin Warteg</div>
                <div class="sub">Masuk dulu untuk membuka panel admin</div>
            </div>
        </div>

        <label>Email Admin</label>
        <input type="email" id="authEmail" placeholder="admin@warteg.com">

        <label>Password</label>
        <div style="display:flex; gap:8px; align-items:center;">
            <input type="password" id="authPassword" placeholder="password123" style="flex:1;">
            <button type="button" class="btn-soft" id="togglePwBtn" onclick="togglePasswordVisibility()">Lihat</button>
        </div>

        <button type="button" class="btn-orange" onclick="loginUser()">Masuk ke Panel Admin</button>
        <div id="authMsg" class="alert"></div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showAlert(type, text) {
            const el = document.getElementById('authMsg');
            el.className = 'alert ' + (type === 'ok' ? 'ok' : 'err');
            el.textContent = text;
        }

        function togglePasswordVisibility() {
            const input = document.getElementById('authPassword');
            const btn = document.getElementById('togglePwBtn');
            const hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            btn.textContent = hidden ? 'Sembunyi' : 'Lihat';
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
                showAlert('ok', data.message || 'Login berhasil, mengalihkan...');
                setTimeout(() => {
                    window.location.replace('/warteg');
                }, 400);
            } else {
                showAlert('err', data.message || 'Email atau password salah.');
            }
        }
    </script>
</body>
</html>