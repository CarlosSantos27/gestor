<?php

use App\User;
use Illuminate\Database\Seeder;

class UserDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();

        $user = new User();
        $user->name = "Test";
        $user->email = "test@test.com";
        $user->password = bcrypt('123456');
        $user->save();
    }
}
