<?php

if (! function_exists('rupiah')) {
    /**
     * Format angka ke Rupiah, contoh: 450000 -> "Rp 450.000".
     */
    function rupiah(int|float|string|null $angka): string
    {
        return 'Rp '.number_format((float) $angka, 0, ',', '.');
    }
}
