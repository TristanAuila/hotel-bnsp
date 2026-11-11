<?php

namespace App\Http\Controllers;

use App\Models\RoomType;

class PageController extends Controller
{
    public function home()
    {
        return view('home', ['rooms' => RoomType::activeByName()]);
    }

    public function produk()
    {
        return view('produk', ['rooms' => RoomType::activeByName()]);
    }

    public function harga()
    {
        return view('harga', ['rooms' => RoomType::activeByName()]);
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function galeri()
    {
        $foto = fn (string $id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=900&q=80";

        $galeri = [
            ['gambar' => $foto('1611892440504-42a792e24d32'), 'caption' => 'Kamar Standar yang nyaman'],
            ['gambar' => $foto('1590490360182-c33d57733427'), 'caption' => 'Kamar Deluxe dengan king bed'],
            ['gambar' => $foto('1566665797739-1674de7a421a'), 'caption' => 'Kamar Family yang luas'],
            ['gambar' => $foto('1566073771259-6a8506099945'), 'caption' => 'Area kolam renang hotel'],
            ['gambar' => $foto('1551882547-ff40c63fe5fa'), 'caption' => 'Lobi utama dan resepsionis'],
            ['gambar' => $foto('1414235077428-338989a2e8c0'), 'caption' => 'Restoran sarapan hotel'],
        ];

        return view('galeri', compact('galeri'));
    }
}
