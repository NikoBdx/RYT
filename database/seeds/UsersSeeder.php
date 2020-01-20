<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Nicolas',
            'lastname'  => 'Brunet',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => '2020-01-01 00:00:00',
            'role'  => 'admin',
            'address' => '62-rue Abbé de l\'epée',
            'town'  => 'Bordeaux',
            'cp'    => '33000',
            'vehicule'  => 'null',
            'latitude'  => 'null',
            'longitude' => 'null',
        ]);

        DB::table('users')->insert([
            'firstname' => 'User',
            'lastname'  => 'website',
            'email' => 'user@gmail.com',
            'password' => bcrypt('1234'),
            'email_verified_at' => '2020-01-01 00:00:00',
            'role'  => 'admin',
            'address' => '18-rue Abbé de l\'epée',
            'town'  => 'Bordeaux',
            'cp'    => '33800',
            'vehicule'  => 'null',
            'latitude'  => 'null',
            'longitude' => 'null',
        ]);

    }
}
