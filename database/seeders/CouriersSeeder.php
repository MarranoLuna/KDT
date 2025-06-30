<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Courier;

class CouriersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 4; $i <= 10; $i++) {
            Courier::factory()->create(["user_id"=>$i]);
        }
    }
}
