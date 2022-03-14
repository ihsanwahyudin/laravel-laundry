<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Outlet;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    private function generateCode()
    {
        $latest = Transaksi::latest()->first();
        $format = "INV" . date('Ym');
        $noUrut = (is_null($latest)) ? "001" : (int)Str::substr($latest->kode_invoice, Str::length($format) + 1, Str::length($latest->kode_invoice)) + 1;
        $noUrutAfter = (Str::length($noUrut) < 3) ? str_repeat('0', 3 - Str::length($noUrut)) . $noUrut : $noUrut;
        $kodeInvoice = $format . $noUrutAfter;

        return $kodeInvoice;
    }

    public function definition()
    {
        $kodeInvoice = $this->generateCode();
        $user = User::inRandomOrder()->where('outlet_id', '!=', null)->first();
        $member = Member::inRandomOrder()->first();

        return [
            'outlet_id' => $user->outlet_id,
            'kode_invoice' => $kodeInvoice,
            'member_id' => $member->id,
            'tgl_bayar' => date('Y-m-d', strtotime($this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'))),
            'batas_waktu' => date('Y-m-d', strtotime($this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'))),
            'metode_pembayaran' => $this->faker->randomElement(['cash', 'dp', 'bayar nanti']),
            'status_transaksi' => $this->faker->randomElement(['baru', 'proses', 'selesai', 'diambil']),
            'status_pembayaran' => $this->faker->randomElement(['lunas', 'belum lunas']),
            'user_id' => $user->id
        ];
    }
}
