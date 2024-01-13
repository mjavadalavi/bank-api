<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'from_debit_card_id' => $this->faker->randomNumber(),
            'to_debit_card_id' => $this->faker->randomNumber(),
            'from_user_balance' => $this->faker->randomFloat(),
            'to_user_balance' => $this->faker->randomFloat(),
            'amount' => $this->faker->randomFloat(),
            'verified' => rand(0, 1),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
