<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


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
          "Auto/Moto",
          "Couverture",
          "Cycle",
          "Echelle / Escabeau",
          "Electricité",
          "Electroportatif",
          "Fixation",
          "Jardinage",
          "Levage Manutention",
          "Maçonnerie",
          "Materiel d'atelier",
          "Mesure",
          "Nettoyage",
          "Plomberie",
        ];

        foreach($categories as $categorie){
          DB::table('categories')->insert([
            'name'=>$categorie
          ]);
        }
    }
}
