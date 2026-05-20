<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, Segoe UI, Arial, sans-serif;
            color: #eef3ff;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at 20% 20%, rgba(29, 185, 84, 0.22), transparent 35%),
                radial-gradient(circle at 82% 8%, rgba(252, 63, 29, 0.24), transparent 36%),
                linear-gradient(140deg, #060810, #090f1e 54%, #080d18);
        }
        .box {
            width: min(440px, calc(100vw - 32px));
            background: rgba(17, 22, 34, 0.86);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 24px 52px rgba(0, 0, 0, 0.38);
            backdrop-filter: blur(10px);
        }
        .logo {
            display: inline-block;
            margin-bottom: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(29, 185, 84, 0.36);
            background: rgba(29, 185, 84, 0.12);
            font-size: 12px;
            font-weight: 700;
        }
        h2 { margin: 0 0 8px; font-size: 28px; letter-spacing: 0.2px; }
        p { margin: 0 0 14px; color: #9ca9c7; font-size: 14px; }
        input {
            width: 100%;
            padding: 11px 12px;
            margin-bottom: 10px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: #eef3ff;
            outline: none;
        }
        input:focus {
            border-color: rgba(59, 130, 246, 0.8);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        button {
            width: 100%;
            padding: 11px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            color: white;
            background: #1db954;
        }
        .err {
            color: #ffd2cc;
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid rgba(239, 68, 68, 0.35);
            font-size: 13px;
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="box">
    <span class="logo">MUSIC ANALYTICS</span>
    <h2>Label DataHub</h2>
    <p>Войдите как artist или admin</p>

    @if($errors->any())
        <div class="err">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</div>
</body>
</html>
