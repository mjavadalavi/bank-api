<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\DebitCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BankAccountFactory extends Factory
{
    protected $model = BankAccount::class;

    public function definition(): array
    {
        return [
            'account_number' => $this->faker->unique()->numerify('########'),
            'user_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    // Custom method to associate the transaction with a specific debit card
    public function forUser($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }


    // Nested factory for credits and transactions
    public function withCreditsAndTransactions($creditsCount = 5, $transactionsCount = 10)
    {
        return $this->afterCreating(function (BankAccount $bankAccount) use ($creditsCount, $transactionsCount) {
            DebitCard::factory()
                ->count($creditsCount)
                ->forBankAccount($bankAccount)
                ->withTransactions($transactionsCount)
                ->create();
        });
    }
}
