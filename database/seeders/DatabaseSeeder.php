<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;
use \Faker\Generator;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Member::factory(10)->create();
        \App\Models\Outlet::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Paket::factory(10)->create();
        $transaksi = 50;
        \App\Models\Transaksi::factory($transaksi)->create();
        \App\Models\DetailTransaksi::factory($transaksi * 5)->create();

        $data = Transaksi::with('detailTransaksi')->get();
        foreach($data as $item) {
            $faker = new Generator();
            $totalPembayaran = $item->detailTransaksi->sum('harga');
            $biayaTambahan = round($faker->numberBetween(1000, 10000), -3);
            $diskon = $faker->numberBetween(0, 25);
            $afterDiskon = ($totalPembayaran + $biayaTambahan) * $diskon / 100;
            $totalPembayaran = $totalPembayaran - $afterDiskon;
            $afterPajak = $totalPembayaran * 10 / 100;
            $totalPembayaran = $totalPembayaran + $afterPajak;

            Pembayaran::create([
                'transaksi_id' => $item->id,
                'biaya_tambahan' => $biayaTambahan,
                'diskon' => $diskon,
                'pajak' => 10,
                'total_pembayaran' => $totalPembayaran,
                'total_bayar' => round($faker->numberBetween($totalPembayaran, $totalPembayaran + 100000), -3),
            ]);
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'outlet_id' => 1,
            'password' => Hash::make('admin')
        ]);

        User::create([
            'name' => 'ihsan',
            'email' => 'm.ihsanwahyudin@outlook.com',
            'role' => 'admin',
            'outlet_id' => 1,
            'password' => Hash::make('ihsan')
        ]);

        User::create([
            'name' => 'owner',
            'email' => 'owner@owner.com',
            'role' => 'owner',
            'outlet_id' => 1,
            'password' => Hash::make('owner')
        ]);
    }
}
