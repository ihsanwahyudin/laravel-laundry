<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AbsensiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_data_absensi()
    {
        $user = User::find(11);
        $response = $this->actingAs($user)->get('/api/absensi')->dd();

        $response->assertStatus(200);
    }

    public function test_post_data_absensi()
    {
        $user = User::find(11);
        $response = $this->actingAs($user)->post('/api/absensi', [
            'nama_karyawan' => 'ihsan',
            'tanggal_masuk' => '2022-03-21',
            'waktu_masuk' => '08:00',
            'status' => 'masuk',
            'waktu_selesai_kerja' => '12:00'
        ]);

        $response->assertStatus(201);
    }
}
