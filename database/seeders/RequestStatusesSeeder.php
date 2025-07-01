<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequestStatuses; 

class RequestStatusesSeeder extends Seeder
{
    
        public function run(): void
    {
        RequestStatuses::create([
            'name' =>'solicitada',
        ]);
        RequestStatuses::create([
            'name' =>'ofertada',
        ]);
        RequestStatuses::create([
            'name' =>'aceptada',
        ]);
    }

}

