<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'loremipsum',
            'email' => 'loremipsum@gmail.com',
            'password' => bcrypt('admincattery'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'budi',
            'email' => 'budi@gmail.com',
            'password' => bcrypt('budi12345'),
            'role' => 'admin'
        ]);
    }
}
