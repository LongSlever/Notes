<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
        [
            'username' => "user1@gmail.com",
            'password' => bcrypt('Vitor.1vit'),
        ],

        [
            'username' => "user2@gmail.com",
            'password' => bcrypt('Vitor.1vit'),
        ],

        [
            'username' => "user3@gmail.com",
            'password' => bcrypt('Vitor.1vit'),
        ],
        );
    }
}
