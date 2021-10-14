<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "test";
        $user->email = "test@test";
        $user->password = Hash::make("12345678");
        $user->balance = 100000;
        $user->role = 'admin';
        $user->save();

        $user = new User();
        $user->name = "test2";
        $user->email = "test2@test2";
        $user->password = Hash::make("12345678");
        $user->balance = 100000;
        $user->save();
    }
}
