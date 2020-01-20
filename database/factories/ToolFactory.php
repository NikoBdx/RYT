<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Tool;
use Faker\Generator as Faker;

$factory->define(Tool::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->word,
        'description' => $faker->text($maxNbChars = 200)   ,
        'price' => $faker->randomNumber(3),
        'image' =>  'https://picsum.photos/300/300',
    ];
});
