<?php

return [
    'name' => env('HOTEL_NAME', 'Hotel Pesona Nusantara'),
    'tagline' => env('HOTEL_TAGLINE', 'Menginap nyaman dengan harga bersahabat'),
    'address' => env('HOTEL_ADDRESS', 'Jl. Jenderal Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220'),
    'phone' => env('HOTEL_PHONE', '+62 21 555-0123'),
    'whatsapp' => env('HOTEL_WHATSAPP', '+62 812-3456-7890'),
    'email' => env('HOTEL_EMAIL', 'reservasi@pesonanusantara.co.id'),
    'maps_query' => env('HOTEL_MAPS_QUERY', 'Jl. Jenderal Sudirman No. 123, Jakarta Pusat'),

    'breakfast_fee' => (int) env('BREAKFAST_FEE', 80000),
    'discount_rate' => (float) env('DISCOUNT_RATE', 0.10),
    'discount_rate2' => (float) env('DISCOUNT_RATE2', 0.05),
    'discount_min_nights' => (int) env('DISCOUNT_MIN_NIGHTS', 3),
];