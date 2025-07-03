<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequestStatus; 

class RequestStatusesSeeder extends Seeder
{
    
        public function run(): void
    {
        RequestStatus::create([
            'name' =>'solicitada',
        ]);
        RequestStatus::create([
            'name' =>'ofertada',
        ]);
        RequestStatus::create([
            'name' =>'aceptada',
        ]);
    }

}

