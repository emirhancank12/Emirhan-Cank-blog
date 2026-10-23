<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Makale Yönetimi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h1 class="h3">
                {{ isset($id) ? 'Makaleyi düzenle' : 'Yeni makale ekle' }}
            </h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST"
                  action="{{ isset($id) ? '/makale/'.$id.'/guncelle' : '/makale-kaydet' }}">
                @csrf

                <div class="mb-3">
                    <label for="baslik" class="form-label">Başlık</label>
                    <input id="baslik" type="text" name="baslik"
                           class="form-control" maxlength="150" required
                           value="{{ old('baslik', $makale['baslik'] ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="ozet" class="form-label">Kısa özet</label>
                    <textarea id="ozet" name="ozet" class="form-control"
                              rows="3" maxlength="500" required>{{ old('ozet', $makale['ozet'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="icerik" class="form-label">İçerik</label>
                    <textarea id="icerik" name="icerik" class="form-control"
                              rows="10" maxlength="20000" required>{{ old('icerik', $makale['icerik'] ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="/blog" class="btn btn-secondary">Vazgeç</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
