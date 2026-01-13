<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < 10; $i++) {
                DB::table('companies')->insert([
                    'name' => fake()->company(),
                    'email' => fake()->unique()->safeEmail(),
                    'logo' => fake()->imageUrl(450, 450, 'business', true),
                    'website' => fake()->url(),
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
        }
    }
}
