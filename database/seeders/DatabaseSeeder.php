<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;
use \Faker\Generator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    private function generateCode()
    {
        $latest = Transaksi::latest()->first();
        $format = "INV" . date('Ym');
        $noUrut = (is_null($latest)) ? "001" : (int)Str::substr($latest->kode_invoice, Str::length($format) + 1, Str::length($latest->kode_invoice)) + 1;
        $noUrutAfter = (Str::length($noUrut) < 3) ? str_repeat('0', 3 - Str::length($noUrut)) . $noUrut : $noUrut;
        $kodeInvoice = $format . $noUrutAfter;

        return $kodeInvoice;
    }
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
        // $transaksi = 50;

        // \App\Models\Transaksi::factory($transaksi)->create();

        // $faker = \Faker\Factory::create();

        // for($i = 1; $i <= $transaksi; $i++) {
        //     $user = User::inRandomOrder()->where('outlet_id', '!=', null)->first();
        //     $member = Member::inRandomOrder()->first();

        //     Transaksi::create([
        //         'outlet_id' => $user->outlet_id,
        //         'kode_invoice' => "INV" . date('Ym') . (Str::length((string)$i) < 3 ? str_repeat('0', 3 - Str::length((string)$i)) . $i : (string)$i),
        //         'member_id' => $member->id,
        //         'tgl_bayar' => date('Y-m-d', strtotime($faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'))),
        //         'batas_waktu' => date('Y-m-d', strtotime($faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'))),
        //         'metode_pembayaran' => $faker->randomElement(['cash', 'dp', 'bayar nanti']),
        //         'status_transaksi' => $faker->randomElement(['baru', 'proses', 'selesai', 'diambil']),
        //         'status_pembayaran' => $faker->randomElement(['lunas', 'belum lunas']),
        //         'user_id' => $user->id
        //     ]);
        // }

        // \App\Models\DetailTransaksi::factory($transaksi * 5)->create();

        // $data = Transaksi::with('detailTransaksi')->get();
        // foreach($data as $item) {
        //     $faker = new Generator();
        //     $totalPembayaran = $item->detailTransaksi->sum('harga');
        //     $biayaTambahan = round($faker->numberBetween(1000, 10000), -3);
        //     $diskon = $faker->numberBetween(0, 25);
        //     $afterDiskon = ($totalPembayaran + $biayaTambahan) * $diskon / 100;
        //     $totalPembayaran = $totalPembayaran - $afterDiskon;
        //     $afterPajak = $totalPembayaran * 10 / 100;
        //     $totalPembayaran = $totalPembayaran + $afterPajak;

        //     Pembayaran::create([
        //         'transaksi_id' => $item->id,
        //         'biaya_tambahan' => $biayaTambahan,
        //         'diskon' => $diskon,
        //         'pajak' => 10,
        //         'total_pembayaran' => $totalPembayaran,
        //         'total_bayar' => round($faker->numberBetween($totalPembayaran, $totalPembayaran + 100000), -3),
        //     ]);
        // }

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'role' => 'admin',
            'outlet_id' => 1,
            'password' => Hash::make('admin')
        ]);

        User::create([
            'name' => 'ihsan',
            'email' => 'm.ihsanwahyudin@outlook.com',
            'username' => 'ihsan',
            'role' => 'kasir',
            'outlet_id' => 1,
            'password' => Hash::make('ihsan')
        ]);

        User::create([
            'name' => 'owner',
            'email' => 'owner@owner.com',
            'username' => 'owner',
            'role' => 'owner',
            'outlet_id' => 1,
            'password' => Hash::make('owner')
        ]);
    }
}
