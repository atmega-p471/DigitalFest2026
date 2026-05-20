<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label DataHub</title>
    <style>
        :root {
            --bg-main: #0b0f17;
            --bg-panel: #141b2a;
            --bg-soft: #1b2436;
            --text-main: #edf2ff;
            --text-muted: #a0afcb;
            --line: rgba(255, 255, 255, 0.08);
            --accent-green: #1db954;
            --accent-blue: #3b82f6;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--text-main);
            font-family: Inter, Segoe UI, Arial, sans-serif;
            background:
                radial-gradient(circle at 14% 8%, rgba(29, 185, 84, 0.12), transparent 38%),
                linear-gradient(145deg, #0b0f17 0%, #0f1727 52%, #111a2b 100%);
            height: 100vh;
            overflow: hidden;
        }

        .app-shell {
            display: grid;
            grid-template-columns: 260px 1fr;
            height: 100vh;
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid var(--line);
            background: rgba(12, 18, 30, 0.92);
            padding: 14px 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .brand {
            padding: 12px 12px;
            border-radius: 12px;
            background: rgba(29, 185, 84, 0.1);
            border: 1px solid rgba(29, 185, 84, 0.22);
        }

        .brand-title {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
        }

        .brand-sub {
            margin: 3px 0 0;
            color: var(--text-muted);
            font-size: 12px;
        }

        .side-nav {
            display: grid;
            gap: 8px;
        }

        .side-nav a,
        .logout-btn {
            color: var(--text-main);
            text-decoration: none;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
            padding: 10px 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s ease;
            text-align: left;
        }

        .side-nav a:hover,
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .side-nav a.active {
            border-color: rgba(59, 130, 246, 0.45);
            background: rgba(59, 130, 246, 0.16);
        }

        .role-pill {
            color: var(--text-muted);
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.04);
            display: inline-block;
        }

        .sidebar-bottom {
            margin-top: auto;
            display: grid;
            gap: 10px;
        }

        .main {
            height: 100vh;
            overflow-y: auto;
            padding: 14px 16px;
        }

        .main-header {
            margin-bottom: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            background: var(--bg-panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 10px;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);
        }

        .title {
            margin: 0 0 10px;
            font-size: 24px;
            line-height: 1.2;
            letter-spacing: 0.2px;
        }

        .grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }

        .split-2 {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .muted {
            color: var(--text-muted);
            font-size: 14px;
        }

        .ok {
            background: rgba(29, 185, 84, 0.16);
            color: #b8ffd1;
            padding: 11px 12px;
            border: 1px solid rgba(29, 185, 84, 0.35);
            border-radius: 12px;
            margin-bottom: 12px;
        }

        input,
        select {
            width: 100%;
            padding: 10px 11px;
            margin-bottom: 10px;
            border-radius: 10px;
            border: 1px solid var(--line);
            color: var(--text-main);
            background: var(--bg-soft);
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: rgba(59, 130, 246, 0.7);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        button.primary {
            border: 0;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            color: #fff;
            background: var(--accent-green);
        }

        button.secondary {
            border: 1px solid var(--line);
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            color: #dce7ff;
            background: rgba(255, 255, 255, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
        }

        th, td {
            text-align: left;
            padding: 10px 9px;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
        }

        th {
            color: #d2ddf8;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.03);
        }

        ul {
            margin: 8px 0 10px;
            padding-left: 18px;
        }

        li { color: #dce4fa; }

        @media (max-width: 900px) {
            body { height: auto; overflow: auto; }
            .app-shell { grid-template-columns: 1fr; height: auto; }
            .sidebar {
                position: static;
                height: auto;
                overflow: visible;
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }
            .side-nav { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .main { height: auto; overflow: visible; padding: 14px; }
            .split-2 { grid-template-columns: 1fr; }
            .title { font-size: 20px; }
            th, td { font-size: 12px; }
        }
    </style>
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        @auth
            <div class="brand">
                <p class="brand-title">Label DataHub</p>
                <p class="brand-sub">Music Analytics Platform</p>
            </div>

            <nav class="side-nav">
                <a href="{{ route('tracks.index') }}" class="{{ request()->routeIs('tracks.*') ? 'active' : '' }}">Треки</a>
                <a href="{{ route('artists.index') }}" class="{{ request()->routeIs('artists.*') ? 'active' : '' }}">Артисты</a>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Отчеты</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>
                @endif
            </nav>

            <div class="sidebar-bottom">
                <span class="role-pill">Роль: {{ auth()->user()->role }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-btn" type="submit">Выход</button>
                </form>
            </div>
        @endauth
    </aside>

    <main class="main">
        @if(session('status'))
            <div class="ok">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
