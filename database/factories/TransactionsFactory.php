<?php

namespace Database\Factories;

use App\Models\Transactions;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionsFactory extends Factory
{
    protected $model = Transactions::class;

    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'description'  => $this->faker->sentence(3),
            'value'        => $this->faker->randomFloat(2, 10, 5000),
            'registerType' => $this->faker->randomElement(['income','outcome']),
            'category'     => $this->faker->word(),
        ];
    }
}
