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
            'debit_card_id' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomFloat(2, 1000, 50000000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }


    public function withTransactions()
    {
        return $this->has(Transaction::factory()->count(5), 'transactions');
    }


    public function forDebitCard($debitCard)
    {
        return $this->state(function (array $attributes) use ($debitCard) {
            return [
                'debit_card_id' => $debitCard->id,
            ];
        });
    }
}
