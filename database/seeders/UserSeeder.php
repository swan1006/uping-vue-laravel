<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
            'name' => Str::random(10),
            'username' => Str::random(10),
            'avatar' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'status' => '1',
            'is_admin' => '1',
            'role' => '1',
            'created_at' => '1',
        ]);

        DB::table('companies')->insert([
            'user_id' => $user-id,
            'username' => Str::random(10),
            'avatar' => '12/12/1990',
            'website' => $this->faker->number,
            'password' => Hash::make('password'),
            'status' => '1',
            'is_admin' => '1',
            'role' => '1',
            'created_at' => '1',
        ]);
    }
}
