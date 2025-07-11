<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'email' => 'fefogs@gmail.com',
                'firstname' => "Federico",
                'lastname' => "Guigou",
                'password' => "1234",
                'phone'=> '215474',
                'birthday' =>'1997-08-15',
                'email_verified_at' => now(),
            ],
            [
                'email' => 'elisaronconi28@gmail.com',
                'firstname' => "Elisa",
                'lastname' => "Ronconi",
                'password' => "1234",
                'phone'=> '621245',
                'birthday' =>'2000-07-15',
                'email_verified_at' => now(),
            ],
            [
                'email' => 'lunamarrano2@gmail.com',
                'firstname' => "Luna",
                'lastname' => "Marrano",
                'password' => "1234",
                'phone'=> '541881',
                'birthday' =>'2003-04-26',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($usuarios as $data) {
            User::factory()->create($data);
        }

        User::factory(20)->create();

    }
}
