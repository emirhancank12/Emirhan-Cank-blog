<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Emirhan Blog - Giriş</title>
</head>
<body>
<h1>Emirhan Blog</h1>
<p>Yazıları okumak için giriş yap.</p>

@if(session('hata'))
    <p>{{ session('hata') }}</p>
@endif

@if($errors->any())
    <p>Kullanıcı adı ve şifre alanlarını doldur.</p>
@endif

<form action="/giris" method="POST">
    @csrf

    <label>Kullanıcı adı:</label>
    <input type="text" name="username" required>

    <br><br>

    <label>Şifre:</label>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">Giriş yap</button>
</form>
</body>
</html>
