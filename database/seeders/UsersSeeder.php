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
                'birthday' =>'1997-08-15',
                'email_verified_at' => now(),
                'role_id' => 1,
            ],
            [
                'email' => 'elisaronconi28@gmail.com',
                'firstname' => "Elisa",
                'lastname' => "Ronconi",
                'password' => "1234",
                'birthday' =>'2000-07-15',
                'email_verified_at' => now(),
                'role_id' => 1,
            ],
            [
                'email' => 'lunamarrano2@gmail.com',
                'firstname' => "Luna",
                'lastname' => "Marrano",
                'password' => "1234",
                'birthday' =>'2003-04-26',
                'email_verified_at' => now(),
                'role_id' => 1,
            ],
            [
                'email' => 'kdt@gmail.com',
                'firstname' => "Patricio",
                'lastname' => "Cadete",
                'password' => "1234",
                'birthday' =>'2000-04-26',
                'email_verified_at' => now(),
                'role_id' => 2,
            ],
             [
                'email' => 'cadete@gmail.com',
                'firstname' => "Pepito",
                'lastname' => "Flores",
                'password' => "1234",
                'birthday' =>'1996-04-26',
                'email_verified_at' => now(),
                'role_id' => 2,
            ],
        ];

        foreach ($usuarios as $data) {
            User::factory()->create($data);
        }

        User::factory(20)->create();

    }
}
