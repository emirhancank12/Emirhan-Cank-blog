<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    private $makaleler = [
        1 => [
            'baslik' => 'Eski filmler...',
            'tarih' => '21.10.2026',
            'ozet' => 'Eski filmler neden her zaman insanı içine çekiyor?',
            'icerik' => 'Eski filmler bana geçmişin atmosferini hissettiriyor. Dönemin kıyafetleri, sokakları ve konuşma biçimleri dikkatimi çekiyor. Özellikle samimi karakterler ve sade hikâyeler bu filmleri benim için özel yapıyor.'
        ],
        2 => [
            'baslik' => 'Oyun Dünyasındaki Yenilikler!',
            'tarih' => '23.10.2026',
            'ozet' => 'Oyun dünyası yapay zeka entegrasyonu, yeni yasal düzenlemeler ve gelişen grafik teknolojileriyle büyük bir dönüşüm geçiriyor.',
            'icerik' => 'Oyunlarda en çok ilgimi çeken yenilik, karakterlerin daha doğal davranabilmesi. Yapay zekanın daha canlı oyun dünyaları oluşturmasını istiyorum. Ancak benim için güzel grafikler kadar oyunun akıcı çalışması ve eğlenceli olması da önemli.'
        ],
        3 => [
            'baslik' => 'Balıkesirsporun tarihçesi...',
            'tarih' => '27.10.2026',
            'ozet' => 'Birgün herkes balıkesirsporlu olacak.',
            'icerik' => 'Bu yazıda Balıkesirsporun kuruluşunu, önemli sezonlarını ve taraftar kültürünü anlatacağım. Araştırdığım tarihî bilgileri ve takımın geçmişindeki önemli olayları buraya ekleyeceğim.'
        ]
    ];

    private function makaleleriOku()
    {
        if (Storage::disk('local')->exists('makaleler.json')) {
            return Storage::disk('local')->json('makaleler.json');
        }

        return $this->makaleler;
    }

    private function dosyayaYaz($makaleler)
    {
        $sonuc = Storage::disk('local')->put(
            'makaleler.json',
            json_encode($makaleler, JSON_UNESCAPED_UNICODE)
        );

        if (!$sonuc) {
            abort(500, 'Makaleler kaydedilemedi.');
        }
    }

    private function yetkiKontrol($makale)
    {
        if (!session('giris') || !session('kullanici')) {
            abort(403, 'Önce yeniden giriş yapmalısınız.');
        }

        if (
            !session('admin') &&
            ($makale['yazar'] ?? null) !== session('kullanici')
        ) {
            abort(403, 'Bu makaleyi değiştiremezsiniz.');
        }
    }

    public function index()
    {
        if (!session('giris')) {
            return redirect('/');
        }

        return view('blog', [
            'makaleler' => $this->makaleleriOku()
        ]);
    }

    public function detay($id)
    {
        if (!session('giris')) {
            return redirect('/');
        }

        $makaleler = $this->makaleleriOku();

        if (!isset($makaleler[$id])) {
            abort(404);
        }

        return view('detay', [
            'makale' => $makaleler[$id]
        ]);
    }

    public function ekle()
    {
        if (!session('giris') || !session('kullanici')) {
            return redirect('/');
        }

        return view('ekle', [
            'makale' => null,
            'id' => null
        ]);
    }

    public function kaydet(Request $request)
    {
        if (!session('giris') || !session('kullanici')) {
            return redirect('/');
        }

        $yeniMakale = $request->validate([
            'baslik' => 'required|string|max:150',
            'ozet' => 'required|string|max:500',
            'icerik' => 'required|string|max:20000'
        ]);

        $yeniMakale['tarih'] = now()
            ->timezone('Europe/Istanbul')
            ->format('d.m.Y');

        $yeniMakale['yazar'] = session('kullanici');

        $makaleler = $this->makaleleriOku();
        $makaleler[] = $yeniMakale;

        $this->dosyayaYaz($makaleler);

        return redirect('/blog');
    }

    public function duzenle($id)
    {
        $makaleler = $this->makaleleriOku();

        if (!isset($makaleler[$id])) {
            abort(404);
        }

        $this->yetkiKontrol($makaleler[$id]);

        return view('ekle', [
            'makale' => $makaleler[$id],
            'id' => $id
        ]);
    }

    public function guncelle(Request $request, $id)
    {
        $makaleler = $this->makaleleriOku();

        if (!isset($makaleler[$id])) {
            abort(404);
        }

        $this->yetkiKontrol($makaleler[$id]);

        $bilgiler = $request->validate([
            'baslik' => 'required|string|max:150',
            'ozet' => 'required|string|max:500',
            'icerik' => 'required|string|max:20000'
        ]);

        $makaleler[$id]['baslik'] = $bilgiler['baslik'];
        $makaleler[$id]['ozet'] = $bilgiler['ozet'];
        $makaleler[$id]['icerik'] = $bilgiler['icerik'];

        $this->dosyayaYaz($makaleler);

        return redirect('/blog');
    }

    public function sil($id)
    {
        $makaleler = $this->makaleleriOku();

        if (!isset($makaleler[$id])) {
            abort(404);
        }

        $this->yetkiKontrol($makaleler[$id]);

        unset($makaleler[$id]);

        $this->dosyayaYaz($makaleler);

        return redirect('/blog');
    }
}
