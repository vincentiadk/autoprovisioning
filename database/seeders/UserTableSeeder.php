<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid'  => '878a7876-38ce-400a-8429-7e1ddd369e40',
                'name' => 'Super Admin',
                'email' => 'admin@mail.com',
                'username' => 'superadmin',
                'password' => 'secret',
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'otp_login' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
    }
}
