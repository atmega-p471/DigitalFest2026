<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — Label DataHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #41354d;
            --bg-card: rgba(75, 61, 88, 0.85);
            --bg-input: rgba(46, 37, 56, 0.9);
            --accent: #cff784;
            --accent-dim: rgba(207, 247, 132, 0.14);
            --accent-glow: rgba(207, 247, 132, 0.35);
            --text: #f5f3f8;
            --text-muted: rgba(245, 243, 248, 0.55);
            --line: rgba(255, 255, 255, 0.07);
            --radius: 14px;
            --radius-xl: 22px;
            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
            --ease-spring: cubic-bezier(0.34, 1.2, 0.64, 1);
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        @keyframes glowOrb {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.1); }
        }

        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        * { box-sizing: border-box; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Onest, 'Segoe UI', system-ui, sans-serif;
            color: var(--text);
            display: grid;
            place-items: center;
            background: var(--bg);
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(70px);
            pointer-events: none;
            animation: glowOrb 8s ease-in-out infinite;
        }

        body::before {
            width: 400px;
            height: 400px;
            top: -10%;
            left: -5%;
            background: rgba(207, 247, 132, 0.16);
        }

        body::after {
            width: 320px;
            height: 320px;
            bottom: -8%;
            right: -5%;
            background: rgba(207, 247, 132, 0.1);
            animation-delay: -4s;
        }

        .wrap {
            position: relative;
            z-index: 1;
            width: min(420px, calc(100vw - 32px));
        }

        .logo-mark {
            width: 60px;
            height: 60px;
            border-radius: var(--radius);
            background: linear-gradient(145deg, rgba(207, 247, 132, 0.35), rgba(46, 37, 56, 0.95));
            border: 1px solid rgba(207, 247, 132, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: var(--accent);
            margin-bottom: 22px;
            box-shadow: 0 8px 32px rgba(207, 247, 132, 0.2);
            animation: fadeSlideUp 0.6s var(--ease-out) 0.05s backwards, floatLogo 4s ease-in-out 0.6s infinite;
        }

        .box {
            background: var(--bg-card);
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            padding: 36px 30px 30px;
            box-shadow: 0 20px 56px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(14px);
            animation: fadeSlideUp 0.65s var(--ease-out) 0.15s backwards;
        }

        h2 {
            margin: 0 0 8px;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -0.04em;
            background: linear-gradient(120deg, var(--text) 0%, var(--accent) 50%, var(--text) 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 5s linear infinite;
        }

        .subtitle {
            margin: 0 0 28px;
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
        }

        input {
            width: 100%;
            padding: 13px 16px;
            margin-bottom: 16px;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            background: var(--bg-input);
            color: var(--text);
            outline: none;
            font-family: inherit;
            font-size: 15px;
            transition: border-color 0.25s var(--ease-out), box-shadow 0.25s var(--ease-out), transform 0.25s var(--ease-spring);
        }

        input::placeholder { color: rgba(245, 243, 248, 0.32); }

        input:focus {
            border-color: rgba(207, 247, 132, 0.5);
            box-shadow: 0 0 0 3px var(--accent-dim);
            transform: scale(1.01);
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 6px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 600;
            font-family: inherit;
            font-size: 15px;
            color: #2a2233;
            background: var(--accent);
            box-shadow: 0 4px 28px var(--accent-glow);
            transition: transform 0.25s var(--ease-spring), filter 0.25s var(--ease-out), box-shadow 0.25s var(--ease-out);
        }

        button:hover {
            filter: brightness(1.1);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 36px var(--accent-glow);
        }

        button:active {
            transform: scale(0.98);
        }

        .err {
            color: #ffb4a8;
            background: rgba(255, 100, 80, 0.1);
            border: 1px solid rgba(255, 120, 100, 0.22);
            font-size: 13px;
            border-radius: var(--radius);
            padding: 12px 14px;
            margin-bottom: 16px;
            animation: fadeSlideUp 0.4s var(--ease-out);
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="logo-mark">♪</div>
    <div class="box">
        <h2>Label DataHub</h2>
        <p class="subtitle">Войдите как артист или администратор</p>

        @if($errors->any())
            <div class="err">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <label for="email">Эл. почта</label>
            <input id="email" type="email" name="email" placeholder="you@label.ru" value="{{ old('email') }}" required>
            <label for="password">Пароль</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</div>
</body>
</html>
