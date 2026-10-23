<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $makale['baslik'] }}</title>
</head>
<body>
<h1>{{ $makale['baslik'] }}</h1>

<p>Yayın tarihi: {{ $makale['tarih'] }}</p>

<p style="white-space: pre-wrap;">{{ $makale['icerik'] }}</p>

<a href="/blog">Makalelere geri dön</a>
</body>
</html>
