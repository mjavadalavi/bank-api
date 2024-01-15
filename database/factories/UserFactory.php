<?php

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withBankAccount()
    {
        return $this->has(BankAccount::factory()->count(3), 'bank_accounts');
    }




    // Nested factory for bank accounts
    public function withBankAccountsAndCreditsAndTransactions($bankAccountsCount = 3, $debitsCount = 5, $transactionsCount = 10)
    {
        return $this->afterCreating(function (User $user) use ($bankAccountsCount, $debitsCount, $transactionsCount) {
            BankAccount::factory()
                ->count($bankAccountsCount)
                ->forUser($user)
                ->withCreditsAndTransactions($debitsCount, $transactionsCount)
                ->create();
        });
    }
}
