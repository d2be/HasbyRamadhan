<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_mahasiswa')->insert([
            [
                'nama' => 'Andi Saputra',
                'jenis_kelamin' => 'laki-laki',
                'jurusan' => 'Informatika',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'perempuan',
                'jurusan' => 'Sistem Informasi',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'laki-laki',
                'jurusan' => 'Teknik Komputer',
                'status' => 'tidak aktif'
            ],
            [
                'nama' => 'Rina Kartika',
                'jenis_kelamin' => 'perempuan',
                'jurusan' => 'Informatika',
                'status' => 'aktif'
            ],
            [
                'nama' => 'Dedi Pratama',
                'jenis_kelamin' => 'laki-laki',
                'jurusan' => 'Sistem Informasi',
                'status' => 'tidak aktif'
            ]
        ]);
    }
}