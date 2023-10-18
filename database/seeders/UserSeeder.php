<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array('Pronoy', 'Wasik');
        $numOfUsers = count($users);

        for ($i = 0; $i < $numOfUsers; $i++) {
            User::create([
                'name' => $users[$i],
                'email' => strtolower($users[$i]) . '@gmail.com',
                'mobile' => '01685010517',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
