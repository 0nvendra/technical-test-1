<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            /*Email: admin@grtech.com 
            Password: password

            Email: user@grtech.com
            Password: password
            */
            DB::table('users')->insert([
                'name' => 'admin@grtech.com',
                'email' => 'admin@grtech.com',
                'role' => 0,
                'password' => bcrypt('password'),
            ]);
            DB::table('users')->insert([
                'name' => 'user@grtech.com',
                'email' => 'user@grtech.com',
                'password' => bcrypt('password'),

            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
        }
    }
}
