<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'Standar',
                'price' => 450000,
                'capacity' => '2 orang',
                'size' => '20 m²',
                'description' => 'Kamar nyaman dengan tempat tidur double, pendingin ruangan, TV, dan kamar mandi dalam. Cocok untuk perjalanan singkat.',
                'facilities' => ['AC', 'TV LED', 'Wi-Fi gratis', 'Kamar mandi dalam', 'Air panas'],
                'image_url' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Deluxe',
                'price' => 750000,
                'capacity' => '2 orang',
                'size' => '28 m²',
                'description' => 'Kamar lebih luas dengan king bed, area kerja, minibar, dan pemandangan kota yang menenangkan.',
                'facilities' => ['AC', 'Smart TV', 'Wi-Fi gratis', 'Minibar', 'Balkon kota', 'Air panas'],
                'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Family',
                'price' => 1200000,
                'capacity' => '4 orang',
                'size' => '42 m²',
                'description' => 'Kamar keluarga dengan dua tempat tidur besar, ruang tamu kecil, dan fasilitas lengkap untuk liburan bersama.',
                'facilities' => ['AC', '2 Smart TV', 'Wi-Fi gratis', 'Ruang tamu', 'Bathtub', 'Breakfast 4 orang'],
                'image_url' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::updateOrCreate(['name' => $roomType['name']], $roomType);
        }
    }
}