<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class PembayaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $transaksi = Transaksi::with('detailTransaksi', 'pembayaran')->get();
        $isNotAvailable = Pembayaran::where('transaksi_id', '=', $transaksi->random()->id)
                ->doesntExist();
        // $isAvailable = Pembayaran::where('transaksi_id', $transaksi->random()->id)->doesntExist();
        // if($isNotAvailable) {
            $totalPembayaran = $transaksi->detailTransaksi->sum('harga');
            $biayaTambahan = round($this->faker->numberBetween(1000, 10000), -3);
            $diskon = $this->faker->numberBetween(0, 25);
            $afterDiskon = ($totalPembayaran + $biayaTambahan) * $diskon / 100;
            $totalPembayaran = $totalPembayaran - $afterDiskon;
            $afterPajak = $totalPembayaran * 10 / 100;
            $totalPembayaran = $totalPembayaran + $afterPajak;
        // } else {
        //     $totalPembayaran = $transaksi->detailTransaksi->sum('harga');
        //     $biayaTambahan = round($this->faker->numberBetween(1000, 10000), -3);
        //     $diskon = $this->faker->numberBetween(0, 25);
        //     $afterDiskon = ($totalPembayaran + $biayaTambahan) * $diskon / 100;
        //     $totalPembayaran = $totalPembayaran - $afterDiskon;
        //     $afterPajak = $totalPembayaran * 10 / 100;
        //     $totalPembayaran = $totalPembayaran + $afterPajak;
        // }

        return [
            'transaksi_id' => $transaksi->id,
            'biaya_tambahan' => $biayaTambahan,
            'diskon' => $diskon,
            'pajak' => 10,
            'total_pembayaran' => $totalPembayaran,
            'total_bayar' => round($this->faker->numberBetween($totalPembayaran, $totalPembayaran + 100000), -3),
        ];
    }
}
