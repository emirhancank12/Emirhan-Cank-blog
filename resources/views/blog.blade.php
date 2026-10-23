<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emirhan Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/blog">Emirhan Blog</a>

        <form action="/cikis" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light">
                Çıkış yap
            </button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    <h1>Emirhan'ın Blogu</h1>

    <p class="text-muted">
        Filmler, oyunlar ve spor üzerine yazılarım.
    </p>

    <p>
        Hoş geldin, {{ session('kullanici') }}

        @if(session('admin'))
            <span class="badge bg-danger">Admin</span>
        @endif
    </p>

    <a href="/makale-ekle" class="btn btn-primary mb-4">
        Yeni makale ekle
    </a>

    <div class="row">
        @forelse($makaleler as $id => $makale)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title h5">
                            {{ $makale['baslik'] }}
                        </h2>

                        <p class="text-muted small">
                            Yayın tarihi: {{ $makale['tarih'] }}
                            <br>
                            Yazar: {{ $makale['yazar'] ?? 'Belirtilmemiş' }}
                        </p>

                        <p class="card-text">
                            {{ $makale['ozet'] }}
                        </p>

                        <a href="/makale/{{ $id }}"
                           class="btn btn-outline-primary">
                            Devamını oku
                        </a>

                        @if(session('admin') || (session('kullanici') && ($makale['yazar'] ?? null) === session('kullanici')))
                            <div class="mt-3">
                                <a href="/makale/{{ $id }}/duzenle"
                                   class="btn btn-warning btn-sm">
                                    Düzenle
                                </a>

                                <form action="/makale/{{ $id }}/sil"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu makale silinsin mi?')">
                                    @csrf

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Sil
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Henüz makale yok. İlk makaleyi ekleyebilirsin.
                </div>
            </div>
        @endforelse
    </div>
</div>

</body>
</html>
