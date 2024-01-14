<?php

namespace Database\Factories;

use App\Models\DebitCard;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DebitCardFactory extends Factory
{
    protected $model = DebitCard::class;

    public function definition()
    {
        return [
            'user_id'=> $this->faker->randomNumber(),
            'card_number' => $this->faker->unique()->creditCardNumber,
            'balance' => $this->faker->randomFloat(0, 100, 50000000),
            'cvv2' => $this->faker->randomFloat(0, 100, 9999),
            'expired_at' => now()->addYears(2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }


    public function withTransactions()
    {
        return $this->has(Transaction::factory()->count(5), 'transactions');
    }

}
