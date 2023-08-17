<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @since 
     * @author 
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'phil.k@appwrk.com',
                'password' =>  bcrypt('Phil@123'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
