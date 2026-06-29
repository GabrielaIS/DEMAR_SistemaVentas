<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMAR | Acceso al sistema</title>
    <style>
        :root {
            --deep: #09192e;
            --mid: #163352;
            --teal: #287a7a;
            --aqua: #4ecdc4;
            --pearl: #f2ede6;
            --cream: #faf8f4;
            --gold: #c6954e;
            --text: #1e2a35;
            --muted: #6b7a8a;
            --border: rgba(9, 25, 46, 0.12);
            --panel: rgba(255, 255, 255, 0.97);
            --danger: #c0392b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 12% 14%, rgba(78, 205, 196, 0.24), transparent 26%),
                radial-gradient(circle at 82% 78%, rgba(198, 149, 78, 0.22), transparent 28%),
                linear-gradient(135deg, var(--deep) 0%, var(--mid) 48%, var(--teal) 100%);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .login-shell {
            width: min(100%, 460px);
            background: var(--panel);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 28px 80px rgba(0, 0, 0, 0.28);
            position: relative;
        }

        .login-shell::before {
            content: "";
            display: block;
            height: 8px;
            background: linear-gradient(90deg, var(--gold), var(--aqua), var(--teal));
        }

        .form-panel {
            padding: 42px 40px 40px;
            background: linear-gradient(180deg, #fff 0%, var(--cream) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-lockup {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 26px;
        }

        .brand-logo {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            border: 1px solid var(--border);
            background: #fff;
            object-fit: cover;
            box-shadow: 0 14px 28px rgba(9, 25, 46, 0.12);
        }

        .brand-name {
            color: var(--deep);
            font-size: 1.2rem;
            font-weight: 900;
            line-height: 1;
        }

        .brand-subtitle {
            margin-top: 6px;
            color: var(--muted);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .form-kicker {
            color: var(--teal);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .form-title {
            margin: 0 0 10px;
            font-size: 1.9rem;
            line-height: 1.1;
            color: var(--deep);
        }

        .form-text {
            color: var(--muted);
            line-height: 1.6;
            margin: 0 0 24px;
        }

        .field { margin-bottom: 16px; }

        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--mid);
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            height: 50px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0 14px;
            color: var(--text);
            font: inherit;
            outline: none;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        input:focus {
            border-color: var(--aqua);
            box-shadow: 0 0 0 4px rgba(78,205,196,0.18);
            transform: translateY(-1px);
        }

        .submit-btn {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--aqua) 100%);
            color: #fff;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 12px 24px rgba(40,122,122,0.22);
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(40,122,122,0.28);
        }

        .error-box {
            border: 1px solid rgba(192,57,43,0.24);
            border-radius: 10px;
            background: rgba(192,57,43,0.08);
            color: var(--danger);
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 0.92rem;
            line-height: 1.45;
        }

        .helper-row {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            gap: 14px;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .helper-row a {
            color: var(--teal);
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 900px) {
            .login-shell { grid-template-columns: 1fr; }
            .brand-panel { min-height: 280px; }
        }

        @media (max-width: 560px) {
            body { padding: 0; }
            .login-shell { min-height: 100vh; border-radius: 0; }
            .brand-panel, .form-panel { padding: 28px 22px; }
            .brand-lockup { margin-bottom: 22px; }
            .helper-row { flex-direction: column; }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="form-panel" aria-label="Inicio de sesión">
            <div class="brand-lockup">
                <img class="brand-logo" src="{{ asset('Logo.png') }}" alt="DEMAR">
                <div>
                    <div class="brand-name">DEMAR</div>
                    <div class="brand-subtitle">Sistema de ventas</div>
                </div>
            </div>

            <div class="form-kicker">Acceso autorizado</div>
            <h2 class="form-title">Iniciar sesión</h2>
            <p class="form-text">Ingresa tu usuario y contraseña para entrar al sistema.</p>

            @if ($errors->any())
                <div class="error-box" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('cajero.login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">Usuario</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="admin@demar.com"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="field">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Ingresa tu contraseña"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button class="submit-btn" type="submit">Entrar al sistema</button>
            </form>

            <div class="helper-row">
                <span>Solo personal autorizado.</span>
            </div>
        </section>
    </main>
</body>
</html>
