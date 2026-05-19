<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; }
        .box { max-width: 400px; margin: 80px auto; background: white; border-radius: 10px; padding: 20px; }
        input { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; border: 0; background: #2563eb; color: white; border-radius: 6px; cursor: pointer; }
        .err { color: #b91c1c; font-size: 14px; margin-bottom: 8px; }
    </style>
</head>
<body>
<div class="box">
    <h2>Label Income App</h2>
    <p>Sign in as artist or admin</p>

    @if($errors->any())
        <div class="err">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
