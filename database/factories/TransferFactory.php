<?php

namespace Database\Factories;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransferFactory extends Factory
{
    protected $model = Transfer::class;

    public function definition()
    {
        return [
            'sender_debit_card_id' => $this->faker->randomNumber(),
            'receiver_debit_card_id' => $this->faker->randomNumber(),
            'amount' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
