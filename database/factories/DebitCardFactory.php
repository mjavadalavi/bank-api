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
            'bank_account_id'=> $this->faker->randomNumber(),
            'card_number' => $this->faker->unique()->creditCardNumber,
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


    public function forUser($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }


    public function forBankAccount($bankAccount)
    {
        return $this->state(function (array $attributes) use ($bankAccount) {
            return [
                'bank_account_id' => $bankAccount->id,
            ];
        });
    }

}
