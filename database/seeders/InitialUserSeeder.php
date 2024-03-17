<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Ian Joseph Navarro',
            'username' => 'iannavarro',
            'email' => 'navarroian1991@gmail.com',
            'password' => Hash::make('admin12345'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
