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
            'latitude'  => '45.0582',
            'longitude' => '0.418498',
            'email_verified_at' => '2020-01-17 10:21:11'
        ]);

    }
}
