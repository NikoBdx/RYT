<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Tool;
use Faker\Generator as Faker;

$factory->define(Tool::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigitNotNull,
        'title' => $faker->word,
        'description' => $faker->text($maxNbChars = 200)   ,
        'price' => $faker->randomNumber(3),
        'image' =>  $faker->imageUrl($width = 640, $height = 480),
    ];
});
