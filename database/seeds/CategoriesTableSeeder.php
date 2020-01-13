<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
          "Jardinage",
          "Maçonnerie",
          "Couverture",
          "Electroportatif",
          "Electricité",
        ];

        foreach($categories as $categorie){
          DB::table('categories')->insert([
            'name'=>$categorie
          ]);
        }
    }
}
