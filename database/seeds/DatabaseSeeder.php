<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //$this->call(ToolsTableSeeder::class);
        //$this->call(UsersSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
