<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password'
        ]);

        \App\Models\Kelompok::create([
            'nama_kelompok' => 'KTU'
        ]);

        \App\Models\Pegawai::create([
            'NIP' => '00001',
            'nama' => 'andre',
            'jabatan' => 'Wakil Kasubag',
            'masa_kerja' => '5',
            'email' => 'andre@gmail.com',
            'password' => 'password',
            'golongan' => 'Pembina, V/a',
            'tahun_mulai_masuk' => '2024-05-12',
            'nama_kelompok' => 'KTU',
            'ttd' => 'ttd.png',
            'no_hp' => '082387120438'
        ]);

        \App\Models\Atasan::create([
            'NIP' => '00005',
            'nama' => 'Taufiq',
            'jabatan' => 'Ketua Balai',
            'masa_kerja' => '6',
            'email' => 'taufiq@gmail.com',
            'golongan' => 'Pembina, X/b',
            'ttd' => 'ttd_kasubag.jpg',
            'password' => 'password',
            'nama_kelompok' => 'KTU'
        ]);

        \App\Models\JatahCuti::create([
            'NIP' => '00001',
            'tahun' => '2023',
            'jatah' => 12
        ]);

        \App\Models\JatahCuti::create([
            'NIP' => '00001',
            'tahun' => '2024',
            'jatah' => 12
        ]);
    }
}
