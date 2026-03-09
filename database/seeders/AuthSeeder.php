<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_auth')->insert([
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('admin123')
        ]);
    }
    
}