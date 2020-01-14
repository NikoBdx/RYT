<?php

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use Illuminate\support\Facades\DB;
=======
use Illuminate\Support\Facades\DB;
>>>>>>> 4c4fb86ab7d8ba4b2068caf742e7a1a1e53b2e5e

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
