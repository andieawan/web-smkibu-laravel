<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - SMKS Islam Bustanul Ulum</title>
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="login">
<form method="POST" action="{{ route('login.proses') }}" class="login__kotak">
    @csrf
    <img src="{{ asset('images/logo.png') }}" alt="" class="login__logo" onerror="this.style.display='none'">
    <h1>Login Admin</h1>
    <p>SMKS Islam Bustanul Ulum Pakusari</p>
    <label>Email
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
    </label>
    @error('email')<div class="galat">{{ $message }}</div>@enderror
    <label>Password
        <input type="password" name="password" required>
    </label>
    <label class="cek"><input type="checkbox" name="ingat" value="1"> Ingat saya</label>
    <button type="submit" class="tombol">Masuk</button>
    <a href="{{ route('beranda') }}" class="kembali">← Kembali ke website</a>
</form>
</body>
</html>
