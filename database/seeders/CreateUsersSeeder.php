<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'first_name' => 'Rhay Christian',
                'last_name' => 'Ras',
                'username' => 'rhayras22',
                'password' => bcrypt('Admin123'),
            ],

        ];



        foreach ($user as $key => $value) {

            User::create($value);
        }
    }
}
