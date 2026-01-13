<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < 10; $i++) {
                DB::table('employees')->insert([
                    'firstName' => fake()->firstName(),
                    'lastName' => fake()->lastName(),
                    'email' => fake()->unique()->safeEmail(),
                    'phone' => fake()->phoneNumber(),

                    // relaso
                    'company_id' => fake()->numberBetween(1, 10),
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $e->getMessage();
        }
    }
}
