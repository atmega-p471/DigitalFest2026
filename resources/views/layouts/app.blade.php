<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Income App</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6fa; color: #1f2937; }
        .container { max-width: 1100px; margin: 0 auto; padding: 20px; }
        .nav { background: #111827; padding: 12px 0; }
        .nav a, .nav button { color: #fff; text-decoration: none; margin-right: 14px; background: transparent; border: 0; cursor: pointer; font-size: 14px; }
        .card { background: #fff; border-radius: 10px; padding: 16px; margin-bottom: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .title { margin: 0 0 8px; }
        .grid { display: grid; gap: 14px; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
        .muted { color: #6b7280; font-size: 14px; }
        .ok { background: #ecfdf5; color: #065f46; padding: 10px; border-radius: 8px; margin-bottom: 12px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        button.primary { background: #2563eb; color: white; border: 0; padding: 9px 12px; border-radius: 6px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
    </style>
</head>
<body>
<nav class="nav">
    <div class="container">
        @auth
            <a href="{{ route('tracks.index') }}">Tracks</a>
            <a href="{{ route('artists.index') }}">Artists</a>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span style="color:#9ca3af; margin-right:12px;">Role: {{ auth()->user()->role }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </div>
</nav>

<main class="container">
    @if(session('status'))
        <div class="ok">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>
</body>
</html>
