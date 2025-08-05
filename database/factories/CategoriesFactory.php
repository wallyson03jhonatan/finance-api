<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriesFactory extends Factory
{
    protected $model = Categories::class;

    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'name'         => $this->faker->word(),
            'description'  => $this->faker->sentence(3),
        ];
    }
}
