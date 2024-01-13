<?php

namespace Database\Factories;

use App\Models\DebitCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DebitCardFactory extends Factory
{
    protected $model = DebitCard::class;

    public function definition()
    {
        return [
            'user_id'=> $this->faker->randomNumber(),
            'credit_number' => $this->faker->randomNumber(16),
            'balance' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
